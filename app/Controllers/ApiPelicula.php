<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL CONTROLADOR BASE RESOURCECONTROLLER DE CODEIGNITER
use CodeIgniter\RESTful\ResourceController;

// IMPORTAMOS EL MODELO DE PELÍCULAS
use App\Models\PeliculaModel;

// CONTROLADOR API REST PARA GESTIONAR PELÍCULAS
// EXTIENDE DE RESOURCECONTROLLER QUE PROPORCIONA RESPUESTAS JSON AUTOMÁTICAS
class ApiPelicula extends ResourceController
{
    // INDICAMOS QUE EL MODELO ASOCIADO A ESTE CONTROLADOR ES PeliculaModel
    protected $modelName = 'App\Models\PeliculaModel';

    // INDICAMOS QUE EL FORMATO DE RESPUESTA ES JSON
    protected $format    = 'json';

    // =============================================
    // MÉTODO INDEX: OBTENER TODAS LAS PELÍCULAS (GET /api/peliculas)
    // INCLUYE EL NOMBRE DE LA CATEGORÍA GRACIAS AL JOIN
    // =============================================
    public function index()
    {
        // USAMOS EL MÉTODO PERSONALIZADO QUE TRAE PELÍCULAS CON CATEGORÍA (JOIN)
        $peliculas = $this->model->getPeliculasConCategoria();

        // DEVOLVEMOS LA RESPUESTA EN FORMATO JSON CON CÓDIGO 200 (OK)
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DESCRIPTIVO
            'mensaje' => 'LISTADO DE PELÍCULAS',
            // INCLUIMOS LOS DATOS DE LAS PELÍCULAS (CON CATEGORÍA)
            'datos'   => $peliculas,
        ]);
    }

    // =============================================
    // MÉTODO SHOW: OBTENER UNA PELÍCULA POR SU ID (GET /api/peliculas/5)
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
        // OBTENEMOS LOS IDs DE LAS ETIQUETAS
        $etiquetaIds = $pivote->getEtiquetasDePelicula($id);
        // SI HAY ETIQUETAS, OBTENEMOS SUS NOMBRES COMPLETOS
        $etiquetas = [];
        if (!empty($etiquetaIds)) {
            $etiquetaModel = new \App\Models\EtiquetaModel();
            // whereIn() BUSCA REGISTROS CUYO ID ESTÉ EN EL ARRAY
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
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DE LA PETICIÓN
            'titulo'       => $this->request->getVar('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DE LA PETICIÓN
            'descripcion'  => $this->request->getVar('descripcion'),
            // OBTENEMOS EL CAMPO 'categoria_id' DE LA PETICIÓN (RELACIÓN 1:N)
            'categoria_id' => $this->request->getVar('categoria_id') ?: null,
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->model->save($datos)) {
            return $this->failValidationErrors($this->model->errors());
        }

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 201 (CREATED)
        return $this->respondCreated([
            'status'  => 201,
            'mensaje' => 'PELÍCULA CREADA CORRECTAMENTE',
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
    // =============================================
    public function delete($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID
        $pelicula = $this->model->find($id);

        // SI NO EXISTE, DEVOLVEMOS ERROR 404
        if ($pelicula === null) {
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // SI TIENE IMAGEN, LA ELIMINAMOS DEL SERVIDOR
        if (!empty($pelicula['imagen']) && file_exists(FCPATH . 'uploads/peliculas/' . $pelicula['imagen'])) {
            unlink(FCPATH . 'uploads/peliculas/' . $pelicula['imagen']);
        }

        // ELIMINAMOS LAS ETIQUETAS ASOCIADAS EN LA TABLA PIVOTE
        $pivote = new \App\Models\PeliculaEtiquetaModel();
        $pivote->where('pelicula_id', $id)->delete();

        // ELIMINAMOS LA PELÍCULA DE LA BASE DE DATOS
        $this->model->delete($id);

        // DEVOLVEMOS RESPUESTA DE ÉXITO
        return $this->respondDeleted([
            'status'  => 200,
            'mensaje' => 'PELÍCULA ELIMINADA CORRECTAMENTE',
        ]);
    }
}
