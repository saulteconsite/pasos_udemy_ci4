<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL MODELO DE PELÍCULAS
use App\Models\PeliculaModel;

// CONTROLADOR CRUD PARA GESTIONAR PELÍCULAS
class Pelicula extends BaseController
{
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO
    protected $peliculaModel;

    // CONSTRUCTOR: SE EJECUTA AL CREAR UNA INSTANCIA DEL CONTROLADOR
    public function __construct()
    {
        // CREAMOS UNA INSTANCIA DEL MODELO PELICULA
        $this->peliculaModel = new PeliculaModel();
        // CARGAMOS EL HELPER TEXT PARA USAR character_limiter() EN LAS VISTAS
        helper('text');
    }

    // MÉTODO INDEX: MUESTRA EL LISTADO DE TODAS LAS PELÍCULAS
    public function index()
    {
        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Listado de Películas';
        // OBTENEMOS TODAS LAS PELÍCULAS ORDENADAS POR ID DESCENDENTE (MÁS RECIENTES PRIMERO)
        $datos['peliculas'] = $this->peliculaModel->orderBy('id', 'DESC')->findAll();

        // CARGAMOS LA VISTA DEL LISTADO Y LE PASAMOS LOS DATOS
        return view('peliculas/index', $datos);
    }

    // MÉTODO CREATE: MUESTRA EL FORMULARIO PARA CREAR UNA PELÍCULA
    public function create()
    {
        // PREPARAMOS EL TÍTULO PARA LA VISTA
        $datos['titulo'] = 'Crear Película';

        // CARGAMOS LA VISTA DEL FORMULARIO DE CREACIÓN
        return view('peliculas/create', $datos);
    }

    // MÉTODO STORE: PROCESA EL FORMULARIO Y GUARDA LA PELÍCULA EN LA BD
    public function store()
    {
        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DEL POST
            'titulo'      => $this->request->getPost('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DEL POST
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN INTERNA, DEVUELVE FALSE
        if (!$this->peliculaModel->save($datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES DE VALIDACIÓN DEL MODELO
            return redirect()->back()->withInput()->with('errors', $this->peliculaModel->errors());
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
            // OBTENEMOS EL CAMPO 'titulo' DEL POST
            'titulo'      => $this->request->getPost('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DEL POST
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        // INTENTAMOS ACTUALIZAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN INTERNA, DEVUELVE FALSE
        if (!$this->peliculaModel->update($id, $datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES DE VALIDACIÓN DEL MODELO
            return redirect()->back()->withInput()->with('errors', $this->peliculaModel->errors());
        }

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

        // ELIMINAMOS LA PELÍCULA DE LA BASE DE DATOS
        $this->peliculaModel->delete($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/peliculas'))->with('mensaje', 'Película eliminada correctamente');
    }
}
