<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL CONTROLADOR BASE RESOURCECONTROLLER DE CODEIGNITER
use CodeIgniter\RESTful\ResourceController;

// IMPORTAMOS EL MODELO DE PELÍCULAS
use App\Models\PeliculaModel;

// CONTROLADOR API REST PARA GESTIONAR PELÍCULAS
// EXTIENDE DE RESOURCECONTROLLER QUE PROPORCIONA RESPUESTAS JSON AUTOMÁTICAS
// SECCIÓN 19: SE AÑADEN ENDPOINTS AVANZADOS (UPLOAD, PAGINACIÓN, FILTROS, ETIQUETAS)
class ApiPelicula extends ResourceController
{
    // INDICAMOS QUE EL MODELO ASOCIADO A ESTE CONTROLADOR ES PeliculaModel
    protected $modelName = 'App\Models\PeliculaModel';

    // INDICAMOS QUE EL FORMATO DE RESPUESTA ES JSON
    protected $format    = 'json';

    // =============================================
    // SECCIÓN 19: MÉTODO INDEX CON PAGINACIÓN Y FILTROS
    // GET /api/peliculas
    // GET /api/peliculas?busqueda=matrix
    // GET /api/peliculas?categoria_id=5
    // GET /api/peliculas?page=2&per_page=10
    // =============================================
    public function index()
    {
        // RECOGEMOS LOS FILTROS DEL QUERY STRING (?busqueda=matrix&categoria_id=5)
        $filtros = [
            // TEXTO DE BÚSQUEDA: SE BUSCARÁ CON LIKE EN TÍTULO Y DESCRIPCIÓN
            'busqueda'     => $this->request->getGet('busqueda'),
            // ID DE LA CATEGORÍA PARA FILTRAR
            'categoria_id' => $this->request->getGet('categoria_id'),
            // ID DE LA ETIQUETA PARA FILTRAR
            'etiqueta_id'  => $this->request->getGet('etiqueta_id'),
        ];

        // OBTENEMOS EL NÚMERO DE RESULTADOS POR PÁGINA (POR DEFECTO 10)
        // EL CLIENTE PUEDE ENVIAR ?per_page=20 PARA CAMBIAR EL TAMAÑO DE PÁGINA
        $porPagina = (int) ($this->request->getGet('per_page') ?? 10);
        // LIMITAMOS EL MÁXIMO A 100 PARA EVITAR CONSULTAS DEMASIADO GRANDES
        $porPagina = min($porPagina, 100);

        // USAMOS EL MÉTODO getPeliculasFiltradas() QUE APLICA FILTROS Y PAGINACIÓN
        $peliculas = $this->model->getPeliculasFiltradas($filtros, $porPagina);

        // OBTENEMOS INFORMACIÓN DE LA PAGINACIÓN PARA INCLUIRLA EN LA RESPUESTA
        $pager = $this->model->pager;

        // DEVOLVEMOS LA RESPUESTA EN FORMATO JSON CON CÓDIGO 200 (OK)
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DESCRIPTIVO
            'mensaje' => 'LISTADO DE PELÍCULAS',
            // INCLUIMOS LOS DATOS DE LAS PELÍCULAS
            'datos'   => $peliculas,
            // INCLUIMOS INFORMACIÓN DE PAGINACIÓN PARA QUE EL FRONTEND SEPA
            // EN QUÉ PÁGINA ESTAMOS, CUÁNTAS HAY EN TOTAL, ETC.
            'paginacion' => [
                // PÁGINA ACTUAL
                'pagina_actual'   => $pager->getCurrentPage(),
                // NÚMERO DE RESULTADOS POR PÁGINA
                'por_pagina'      => $porPagina,
                // TOTAL DE REGISTROS QUE COINCIDEN CON LOS FILTROS
                'total_registros' => $pager->getTotal(),
                // TOTAL DE PÁGINAS DISPONIBLES
                'total_paginas'   => $pager->getPageCount(),
            ],
        ]);
    }

    // =============================================
    // MÉTODO SHOW: OBTENER UNA PELÍCULA POR SU ID (GET /api/peliculas/5)
    // INCLUYE LAS ETIQUETAS ASIGNADAS (RELACIÓN N:M)
    // =============================================
    public function show($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID EN LA BASE DE DATOS
        $pelicula = $this->model->find($id);

        // SI NO EXISTE LA PELÍCULA, DEVOLVEMOS ERROR 404
        if ($pelicula === null) {
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // OBTENEMOS LAS ETIQUETAS ASIGNADAS A ESTA PELÍCULA (RELACIÓN N:M)
        $pivote = new \App\Models\PeliculaEtiquetaModel();
        // OBTENEMOS LOS IDs DE LAS ETIQUETAS DESDE LA TABLA PIVOTE
        $etiquetaIds = $pivote->getEtiquetasDePelicula($id);
        // SI HAY ETIQUETAS, OBTENEMOS SUS DATOS COMPLETOS
        $etiquetas = [];
        if (!empty($etiquetaIds)) {
            $etiquetaModel = new \App\Models\EtiquetaModel();
            // whereIn() GENERA: WHERE id IN (1, 3, 7) - UNA SOLA CONSULTA EFICIENTE
            $etiquetas = $etiquetaModel->whereIn('id', $etiquetaIds)->findAll();
        }

        // AÑADIMOS LAS ETIQUETAS AL ARRAY DE LA PELÍCULA
        $pelicula['etiquetas'] = $etiquetas;

        // DEVOLVEMOS LA PELÍCULA CON SUS ETIQUETAS EN FORMATO JSON
        return $this->respond([
            'status'  => 200,
            'mensaje' => 'PELÍCULA ENCONTRADA',
            'datos'   => $pelicula,
        ]);
    }

    // =============================================
    // MÉTODO CREATE: CREAR UNA NUEVA PELÍCULA (POST /api/peliculas)
    // =============================================
    public function create()
    {
        // RECOGEMOS LOS DATOS ENVIADOS EN LA PETICIÓN (JSON O FORM-DATA)
        // getVar() FUNCIONA TANTO CON JSON COMO CON FORM-DATA
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DE LA PETICIÓN
            'titulo'       => $this->request->getVar('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DE LA PETICIÓN
            'descripcion'  => $this->request->getVar('descripcion'),
            // OBTENEMOS EL CAMPO 'categoria_id' DE LA PETICIÓN (RELACIÓN 1:N)
            // SI VIENE VACÍO, LO CONVERTIMOS A NULL
            'categoria_id' => $this->request->getVar('categoria_id') ?: null,
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->model->save($datos)) {
            // failValidationErrors() DEVUELVE CÓDIGO 400 CON LOS ERRORES DE VALIDACIÓN
            return $this->failValidationErrors($this->model->errors());
        }

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 201 (CREATED)
        return $this->respondCreated([
            'status'  => 201,
            'mensaje' => 'PELÍCULA CREADA CORRECTAMENTE',
            // INCLUIMOS EL ID DE LA NUEVA PELÍCULA
            'id'      => $this->model->getInsertID(),
        ]);
    }

    // =============================================
    // MÉTODO UPDATE: ACTUALIZAR UNA PELÍCULA EXISTENTE (PUT /api/peliculas/5)
    // =============================================
    public function update($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID
        $pelicula = $this->model->find($id);

        // SI NO EXISTE, DEVOLVEMOS ERROR 404
        if ($pelicula === null) {
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // RECOGEMOS LOS DATOS ENVIADOS EN LA PETICIÓN
        $datos = [
            'titulo'       => $this->request->getVar('titulo'),
            'descripcion'  => $this->request->getVar('descripcion'),
            'categoria_id' => $this->request->getVar('categoria_id') ?: null,
        ];

        // INTENTAMOS ACTUALIZAR
        if (!$this->model->update($id, $datos)) {
            return $this->failValidationErrors($this->model->errors());
        }

        // DEVOLVEMOS RESPUESTA DE ÉXITO
        return $this->respond([
            'status'  => 200,
            'mensaje' => 'PELÍCULA ACTUALIZADA CORRECTAMENTE',
        ]);
    }

    // =============================================
    // MÉTODO DELETE: ELIMINAR UNA PELÍCULA (DELETE /api/peliculas/5)
    // ELIMINA EN CASCADA: IMAGEN + PIVOTE + PELÍCULA
    // =============================================
    public function delete($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID
        $pelicula = $this->model->find($id);

        // SI NO EXISTE, DEVOLVEMOS ERROR 404
        if ($pelicula === null) {
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // 1. ELIMINAMOS LA IMAGEN DEL SERVIDOR (SI TIENE)
        // HAY QUE ELIMINAR PRIMERO LAS DEPENDENCIAS Y DESPUÉS EL REGISTRO PRINCIPAL
        if (!empty($pelicula['imagen']) && file_exists(FCPATH . 'uploads/peliculas/' . $pelicula['imagen'])) {
            // unlink() ELIMINA UN ARCHIVO DEL SISTEMA DE ARCHIVOS
            unlink(FCPATH . 'uploads/peliculas/' . $pelicula['imagen']);
        }

        // 2. ELIMINAMOS LAS ETIQUETAS ASOCIADAS EN LA TABLA PIVOTE
        $pivote = new \App\Models\PeliculaEtiquetaModel();
        $pivote->where('pelicula_id', $id)->delete();

        // 3. ELIMINAMOS LA PELÍCULA DE LA BASE DE DATOS
        $this->model->delete($id);

        // DEVOLVEMOS RESPUESTA DE ÉXITO
        return $this->respondDeleted([
            'status'  => 200,
            'mensaje' => 'PELÍCULA ELIMINADA CORRECTAMENTE',
        ]);
    }

    // =============================================
    // SECCIÓN 19: MÉTODO UPLOAD - SUBIR IMAGEN A UNA PELÍCULA (POST /api/peliculas/upload/5)
    // =============================================
    // ENDPOINT ESPECÍFICO PARA SUBIR IMÁGENES POR API
    // EL CLIENTE ENVÍA LA IMAGEN COMO form-data (NO JSON, PORQUE JSON NO SOPORTA ARCHIVOS)
    public function upload($id = null)
    {
        // 1. VERIFICAMOS QUE LA PELÍCULA EXISTE
        $pelicula = $this->model->find($id);
        if ($pelicula === null) {
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // 2. OBTENEMOS EL ARCHIVO SUBIDO (CAMPO 'imagen' DEL FORM-DATA)
        $imagen = $this->request->getFile('imagen');

        // 3. VERIFICAMOS QUE SE HAYA ENVIADO UNA IMAGEN VÁLIDA
        // isValid() COMPRUEBA QUE EL ARCHIVO SE SUBIÓ SIN ERRORES
        // hasMoved() COMPRUEBA QUE NO HAYA SIDO MOVIDO YA (EVITA MOVER 2 VECES)
        if (!$imagen || !$imagen->isValid() || $imagen->hasMoved()) {
            // fail() DEVUELVE UNA RESPUESTA JSON CON EL CÓDIGO Y MENSAJE INDICADOS
            return $this->fail('NO SE RECIBIÓ UNA IMAGEN VÁLIDA.', 400);
        }

        // 4. VALIDAMOS QUE EL ARCHIVO SEA UNA IMAGEN REAL Y NO SUPERE 2MB
        $reglas = [
            'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/gif]',
        ];

        // SI LA VALIDACIÓN FALLA, DEVOLVEMOS LOS ERRORES EN JSON
        if (!$this->validate($reglas)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // 5. SI LA PELÍCULA YA TENÍA IMAGEN, LA ELIMINAMOS DEL SERVIDOR
        if (!empty($pelicula['imagen']) && file_exists(FCPATH . 'uploads/peliculas/' . $pelicula['imagen'])) {
            unlink(FCPATH . 'uploads/peliculas/' . $pelicula['imagen']);
        }

        // 6. GENERAMOS UN NOMBRE ALEATORIO PARA EL ARCHIVO
        // getRandomName() GENERA ALGO COMO: 1710234567_abc123.jpg
        $nuevoNombre = $imagen->getRandomName();

        // 7. MOVEMOS LA IMAGEN A LA CARPETA public/uploads/peliculas/
        // FCPATH ES UNA CONSTANTE QUE APUNTA A LA CARPETA public/
        $imagen->move(FCPATH . 'uploads/peliculas', $nuevoNombre);

        // 8. ACTUALIZAMOS EL CAMPO 'imagen' DE LA PELÍCULA EN LA BD
        $this->model->update($id, ['imagen' => $nuevoNombre]);

        // DEVOLVEMOS RESPUESTA DE ÉXITO CON LA INFORMACIÓN DE LA IMAGEN
        return $this->respond([
            'status'  => 200,
            'mensaje' => 'IMAGEN SUBIDA CORRECTAMENTE',
            // INCLUIMOS EL NOMBRE DEL ARCHIVO PARA QUE EL FRONTEND PUEDA CONSTRUIR LA URL
            'imagen'  => $nuevoNombre,
        ]);
    }

    // =============================================
    // SECCIÓN 19: MÉTODO ASIGNAR ETIQUETAS (POST /api/peliculas/5/etiquetas)
    // =============================================
    // ENDPOINT PARA ASIGNAR ETIQUETAS A UNA PELÍCULA POR API
    // EL CLIENTE ENVÍA UN ARRAY DE IDs DE ETIQUETAS
    // EJEMPLO JSON: { "etiquetas": [1, 3, 7] }
    public function asignarEtiquetas($id = null)
    {
        // 1. VERIFICAMOS QUE LA PELÍCULA EXISTE
        $pelicula = $this->model->find($id);
        if ($pelicula === null) {
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // 2. OBTENEMOS EL ARRAY DE IDs DE ETIQUETAS DE LA PETICIÓN
        // getVar() FUNCIONA TANTO CON JSON COMO CON FORM-DATA
        $etiquetaIds = $this->request->getVar('etiquetas');

        // 3. VALIDAMOS QUE SE HAYA ENVIADO UN ARRAY
        if (!is_array($etiquetaIds)) {
            return $this->fail('DEBES ENVIAR UN ARRAY DE IDs DE ETIQUETAS EN EL CAMPO "etiquetas".', 400);
        }

        // 4. USAMOS EL MÉTODO sincronizar() DEL MODELO PIVOTE
        // SINCRONIZAR = BORRAR LAS ETIQUETAS ANTERIORES + INSERTAR LAS NUEVAS
        $pivote = new \App\Models\PeliculaEtiquetaModel();
        $pivote->sincronizar($id, $etiquetaIds);

        // DEVOLVEMOS RESPUESTA DE ÉXITO
        return $this->respond([
            'status'  => 200,
            'mensaje' => 'ETIQUETAS ASIGNADAS CORRECTAMENTE',
            // INCLUIMOS LAS ETIQUETAS ASIGNADAS PARA CONFIRMACIÓN
            'etiquetas_asignadas' => $etiquetaIds,
        ]);
    }
}
