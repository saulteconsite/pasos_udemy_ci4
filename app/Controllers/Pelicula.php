<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL MODELO DE PELÍCULAS
use App\Models\PeliculaModel;
// IMPORTAMOS EL MODELO DE CATEGORÍAS (PARA EL SELECT DEL FORMULARIO)
use App\Models\CategoriaModel;
// IMPORTAMOS EL MODELO DE ETIQUETAS (PARA LOS CHECKBOXES DEL FORMULARIO)
use App\Models\EtiquetaModel;
// IMPORTAMOS EL MODELO DE LA TABLA PIVOTE PELÍCULA-ETIQUETA
use App\Models\PeliculaEtiquetaModel;

// CONTROLADOR CRUD PARA GESTIONAR PELÍCULAS
class Pelicula extends BaseController
{
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO DE PELÍCULAS
    protected $peliculaModel;
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO DE CATEGORÍAS
    protected $categoriaModel;
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO DE ETIQUETAS
    protected $etiquetaModel;
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO PIVOTE
    protected $peliculaEtiquetaModel;

    // CONSTRUCTOR: SE EJECUTA AL CREAR UNA INSTANCIA DEL CONTROLADOR
    public function __construct()
    {
        // CREAMOS UNA INSTANCIA DEL MODELO PELICULA
        $this->peliculaModel = new PeliculaModel();
        // CREAMOS UNA INSTANCIA DEL MODELO CATEGORIA
        $this->categoriaModel = new CategoriaModel();
        // CREAMOS UNA INSTANCIA DEL MODELO ETIQUETA
        $this->etiquetaModel = new EtiquetaModel();
        // CREAMOS UNA INSTANCIA DEL MODELO PIVOTE
        $this->peliculaEtiquetaModel = new PeliculaEtiquetaModel();
        // CARGAMOS EL HELPER TEXT PARA USAR character_limiter() EN LAS VISTAS
        helper('text');
    }

    // =============================================
    // SECCIÓN 18: MÉTODO INDEX CON PAGINACIÓN Y FILTROS
    // =============================================
    // MUESTRA EL LISTADO DE PELÍCULAS PAGINADO Y FILTRADO
    // LOS FILTROS SE RECIBEN POR GET (QUERY STRING): ?busqueda=matrix&categoria_id=5&etiqueta_id=1
    public function index()
    {
        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Listado de Películas';

        // RECOGEMOS LOS FILTROS DE LA URL (QUERY STRING) USANDO getGet()
        // getGet() LEE LOS PARÁMETROS DE LA URL (?busqueda=matrix)
        $filtros = [
            // TEXTO DE BÚSQUEDA: SE BUSCARÁ CON LIKE EN TÍTULO Y DESCRIPCIÓN
            'busqueda'     => $this->request->getGet('busqueda'),
            // ID DE LA CATEGORÍA SELECCIONADA EN EL FILTRO
            'categoria_id' => $this->request->getGet('categoria_id'),
            // ID DE LA ETIQUETA SELECCIONADA EN EL FILTRO
            'etiqueta_id'  => $this->request->getGet('etiqueta_id'),
        ];

        // LLAMAMOS AL MÉTODO DEL MODELO QUE APLICA LOS FILTROS Y PAGINA
        // 5 = NÚMERO DE PELÍCULAS POR PÁGINA
        $datos['peliculas'] = $this->peliculaModel->getPeliculasFiltradas($filtros, 5);

        // OBTENEMOS EL OBJETO PAGER DEL MODELO PARA GENERAR LOS ENLACES DE PAGINACIÓN
        // EL PAGER SABE EN QUÉ PÁGINA ESTAMOS, CUÁNTAS PÁGINAS HAY, ETC.
        $datos['pager'] = $this->peliculaModel->pager;

        // PASAMOS TODAS LAS CATEGORÍAS PARA EL SELECT DE FILTRO
        $datos['categorias'] = $this->categoriaModel->orderBy('titulo', 'ASC')->findAll();

        // PASAMOS TODAS LAS ETIQUETAS PARA EL SELECT DE FILTRO
        $datos['etiquetas'] = $this->etiquetaModel->orderBy('nombre', 'ASC')->findAll();

        // PASAMOS LOS FILTROS ACTUALES PARA QUE SE MANTENGAN SELECCIONADOS EN EL FORMULARIO
        $datos['filtros'] = $filtros;

        // CARGAMOS LA VISTA DEL LISTADO Y LE PASAMOS LOS DATOS
        return view('peliculas/index', $datos);
    }

    // MÉTODO CREATE: MUESTRA EL FORMULARIO PARA CREAR UNA PELÍCULA
    public function create()
    {
        // PREPARAMOS EL TÍTULO PARA LA VISTA
        $datos['titulo'] = 'Crear Película';
        // OBTENEMOS TODAS LAS CATEGORÍAS PARA EL SELECT DESPLEGABLE DEL FORMULARIO
        $datos['categorias'] = $this->categoriaModel->orderBy('titulo', 'ASC')->findAll();
        // OBTENEMOS TODAS LAS ETIQUETAS PARA LOS CHECKBOXES DEL FORMULARIO
        $datos['etiquetas'] = $this->etiquetaModel->orderBy('nombre', 'ASC')->findAll();

        // CARGAMOS LA VISTA DEL FORMULARIO DE CREACIÓN
        return view('peliculas/create', $datos);
    }

    // MÉTODO STORE: PROCESA EL FORMULARIO Y GUARDA LA PELÍCULA EN LA BD
    public function store()
    {
        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DEL POST
            'titulo'       => $this->request->getPost('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DEL POST
            'descripcion'  => $this->request->getPost('descripcion'),
            // OBTENEMOS EL CAMPO 'categoria_id' DEL POST (RELACIÓN 1:N)
            'categoria_id' => $this->request->getPost('categoria_id') ?: null,
        ];

        // =============================================
        // SECCIÓN 16: CARGA DE ARCHIVOS (IMAGEN)
        // =============================================

        // OBTENEMOS EL ARCHIVO SUBIDO DESDE EL CAMPO 'imagen' DEL FORMULARIO
        $imagen = $this->request->getFile('imagen');

        // VERIFICAMOS QUE SE HAYA SUBIDO UNA IMAGEN VÁLIDA Y QUE NO HAYA ERRORES
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            // VALIDAMOS QUE EL ARCHIVO SEA UNA IMAGEN (jpg, jpeg, png, gif) Y NO SUPERE 2MB
            $reglas = [
                'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/gif]',
            ];

            // SI LA VALIDACIÓN DE LA IMAGEN FALLA, REDIRIGIMOS CON ERRORES
            if (!$this->validate($reglas)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // GENERAMOS UN NOMBRE ALEATORIO PARA EVITAR COLISIONES DE NOMBRES
            $nuevoNombre = $imagen->getRandomName();

            // MOVEMOS LA IMAGEN A LA CARPETA public/uploads/peliculas/
            $imagen->move(FCPATH . 'uploads/peliculas', $nuevoNombre);

            // GUARDAMOS EL NOMBRE DEL ARCHIVO EN EL ARRAY DE DATOS
            $datos['imagen'] = $nuevoNombre;
        }

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN INTERNA, DEVUELVE FALSE
        if (!$this->peliculaModel->save($datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES DE VALIDACIÓN
            return redirect()->back()->withInput()->with('errors', $this->peliculaModel->errors());
        }

        // =============================================
        // SECCIÓN 15: ASIGNAR ETIQUETAS A LA PELÍCULA
        // =============================================

        // OBTENEMOS EL ID DE LA PELÍCULA RECIÉN CREADA
        $peliculaId = $this->peliculaModel->getInsertID();

        // OBTENEMOS LAS ETIQUETAS SELECCIONADAS DEL FORMULARIO (ARRAY DE IDs)
        $etiquetas = $this->request->getPost('etiquetas') ?? [];

        // SI SE SELECCIONARON ETIQUETAS, LAS SINCRONIZAMOS EN LA TABLA PIVOTE
        if (!empty($etiquetas)) {
            $this->peliculaEtiquetaModel->sincronizar($peliculaId, $etiquetas);
        }

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/peliculas'))->with('mensaje', 'Película creada correctamente');
    }

    // MÉTODO EDIT: MUESTRA EL FORMULARIO PARA EDITAR UNA PELÍCULA EXISTENTE
    public function edit($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID
        $pelicula = $this->peliculaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($pelicula === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la película');
        }

        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Editar Película';
        $datos['pelicula'] = $pelicula;
        // OBTENEMOS TODAS LAS CATEGORÍAS PARA EL SELECT DESPLEGABLE
        $datos['categorias'] = $this->categoriaModel->orderBy('titulo', 'ASC')->findAll();
        // OBTENEMOS TODAS LAS ETIQUETAS PARA LOS CHECKBOXES
        $datos['etiquetas'] = $this->etiquetaModel->orderBy('nombre', 'ASC')->findAll();
        // OBTENEMOS LAS ETIQUETAS YA ASIGNADAS A ESTA PELÍCULA (ARRAY DE IDs)
        $datos['etiquetasSeleccionadas'] = $this->peliculaEtiquetaModel->getEtiquetasDePelicula($id);

        // CARGAMOS LA VISTA DEL FORMULARIO DE EDICIÓN
        return view('peliculas/edit', $datos);
    }

    // MÉTODO UPDATE: PROCESA EL FORMULARIO Y ACTUALIZA LA PELÍCULA EN LA BD
    public function update($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID
        $pelicula = $this->peliculaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($pelicula === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la película');
        }

        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            'titulo'       => $this->request->getPost('titulo'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'categoria_id' => $this->request->getPost('categoria_id') ?: null,
        ];

        // SECCIÓN 16: CARGA DE ARCHIVOS (IMAGEN) AL EDITAR
        $imagen = $this->request->getFile('imagen');

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $reglas = [
                'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/gif]',
            ];

            if (!$this->validate($reglas)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // SI YA TENÍA IMAGEN, LA ELIMINAMOS DEL SERVIDOR
            if (!empty($pelicula['imagen']) && file_exists(FCPATH . 'uploads/peliculas/' . $pelicula['imagen'])) {
                unlink(FCPATH . 'uploads/peliculas/' . $pelicula['imagen']);
            }

            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(FCPATH . 'uploads/peliculas', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        }

        // INTENTAMOS ACTUALIZAR
        if (!$this->peliculaModel->update($id, $datos)) {
            return redirect()->back()->withInput()->with('errors', $this->peliculaModel->errors());
        }

        // SINCRONIZAMOS LAS ETIQUETAS
        $etiquetas = $this->request->getPost('etiquetas') ?? [];
        $this->peliculaEtiquetaModel->sincronizar($id, $etiquetas);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/peliculas'))->with('mensaje', 'Película actualizada correctamente');
    }

    // MÉTODO DELETE: ELIMINA UNA PELÍCULA DE LA BASE DE DATOS
    public function delete($id = null)
    {
        // BUSCAMOS LA PELÍCULA POR SU ID
        $pelicula = $this->peliculaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($pelicula === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la película');
        }

        // SI TIENE IMAGEN, LA ELIMINAMOS DEL SERVIDOR
        if (!empty($pelicula['imagen']) && file_exists(FCPATH . 'uploads/peliculas/' . $pelicula['imagen'])) {
            unlink(FCPATH . 'uploads/peliculas/' . $pelicula['imagen']);
        }

        // ELIMINAMOS LAS ETIQUETAS ASOCIADAS EN LA TABLA PIVOTE
        $this->peliculaEtiquetaModel->where('pelicula_id', $id)->delete();

        // ELIMINAMOS LA PELÍCULA DE LA BASE DE DATOS
        $this->peliculaModel->delete($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/peliculas'))->with('mensaje', 'Película eliminada correctamente');
    }
}
