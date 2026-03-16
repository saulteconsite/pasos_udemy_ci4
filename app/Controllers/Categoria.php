<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL MODELO DE CATEGORÍAS
use App\Models\CategoriaModel;

// CONTROLADOR CRUD PARA GESTIONAR CATEGORÍAS
class Categoria extends BaseController
{
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO
    protected $categoriaModel;

    // CONSTRUCTOR: SE EJECUTA AL CREAR UNA INSTANCIA DEL CONTROLADOR
    public function __construct()
    {
        // CREAMOS UNA INSTANCIA DEL MODELO CATEGORIA
        $this->categoriaModel = new CategoriaModel();
    }

    // =============================================
    // SECCIÓN 18: MÉTODO INDEX CON PAGINACIÓN Y BÚSQUEDA
    // =============================================
    // MUESTRA EL LISTADO DE CATEGORÍAS PAGINADO Y CON BÚSQUEDA POR TEXTO
    public function index()
    {
        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Listado de Categorías';

        // RECOGEMOS EL FILTRO DE BÚSQUEDA DE LA URL (?busqueda=accion)
        $busqueda = $this->request->getGet('busqueda');

        // CONSTRUIMOS LA CONSULTA BASE ORDENADA POR ID DESCENDENTE
        $builder = $this->categoriaModel->orderBy('id', 'DESC');

        // SI EL USUARIO ESCRIBIÓ ALGO EN EL CAMPO DE BÚSQUEDA
        if (!empty($busqueda)) {
            // like() BUSCA COINCIDENCIAS PARCIALES EN EL TÍTULO
            // 'both' BUSCA %texto% (COINCIDENCIAS EN CUALQUIER POSICIÓN)
            $builder->like('titulo', $busqueda, 'both');
        }

        // paginate(10) DEVUELVE SOLO 10 RESULTADOS POR PÁGINA
        // CODEIGNITER CALCULA AUTOMÁTICAMENTE EL OFFSET SEGÚN ?page=X
        $datos['categorias'] = $builder->paginate(10);

        // OBTENEMOS EL OBJETO PAGER PARA GENERAR ENLACES DE PAGINACIÓN EN LA VISTA
        $datos['pager'] = $this->categoriaModel->pager;

        // PASAMOS EL FILTRO DE BÚSQUEDA PARA QUE SE MANTENGA EN EL INPUT
        $datos['busqueda'] = $busqueda;

        // CARGAMOS LA VISTA DEL LISTADO Y LE PASAMOS LOS DATOS
        return view('categorias/index', $datos);
    }

    // MÉTODO CREATE: MUESTRA EL FORMULARIO PARA CREAR UNA CATEGORÍA
    public function create()
    {
        // PREPARAMOS EL TÍTULO PARA LA VISTA
        $datos['titulo'] = 'Crear Categoría';

        // CARGAMOS LA VISTA DEL FORMULARIO DE CREACIÓN
        return view('categorias/create', $datos);
    }

    // MÉTODO STORE: PROCESA EL FORMULARIO Y GUARDA LA CATEGORÍA EN LA BD
    public function store()
    {
        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DEL POST
            'titulo' => $this->request->getPost('titulo'),
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN INTERNA, DEVUELVE FALSE
        if (!$this->categoriaModel->save($datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES DE VALIDACIÓN DEL MODELO
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/categorias'))->with('mensaje', 'Categoría creada correctamente');
    }

    // MÉTODO EDIT: MUESTRA EL FORMULARIO PARA EDITAR UNA CATEGORÍA EXISTENTE
    public function edit($id = null)
    {
        // BUSCAMOS LA CATEGORÍA POR SU ID
        $categoria = $this->categoriaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($categoria === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la categoría');
        }

        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Editar Categoría';
        $datos['categoria'] = $categoria;

        // CARGAMOS LA VISTA DEL FORMULARIO DE EDICIÓN
        return view('categorias/edit', $datos);
    }

    // MÉTODO UPDATE: PROCESA EL FORMULARIO Y ACTUALIZA LA CATEGORÍA EN LA BD
    public function update($id = null)
    {
        // BUSCAMOS LA CATEGORÍA POR SU ID
        $categoria = $this->categoriaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($categoria === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la categoría');
        }

        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            'titulo' => $this->request->getPost('titulo'),
        ];

        // INTENTAMOS ACTUALIZAR
        if (!$this->categoriaModel->update($id, $datos)) {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/categorias'))->with('mensaje', 'Categoría actualizada correctamente');
    }

    // MÉTODO DELETE: ELIMINA UNA CATEGORÍA DE LA BASE DE DATOS
    public function delete($id = null)
    {
        // BUSCAMOS LA CATEGORÍA POR SU ID
        $categoria = $this->categoriaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($categoria === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la categoría');
        }

        // ELIMINAMOS LA CATEGORÍA DE LA BASE DE DATOS
        $this->categoriaModel->delete($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/categorias'))->with('mensaje', 'Categoría eliminada correctamente');
    }
}
