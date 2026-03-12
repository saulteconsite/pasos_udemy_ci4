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
        // DEFINIMOS LAS REGLAS DE VALIDACIÓN PARA LOS CAMPOS
        $reglas = [
            'titulo'      => 'required|min_length[3]|max_length[150]',
            'descripcion' => 'permit_empty|max_length[5000]',
        ];

        // SI LA VALIDACIÓN FALLA, REDIRIGIMOS AL FORMULARIO CON LOS ERRORES
        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // GUARDAMOS LA NUEVA PELÍCULA EN LA BASE DE DATOS
        $this->peliculaModel->save([
            'titulo'      => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

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

        // DEFINIMOS LAS REGLAS DE VALIDACIÓN
        $reglas = [
            'titulo'      => 'required|min_length[3]|max_length[150]',
            'descripcion' => 'permit_empty|max_length[5000]',
        ];

        // SI LA VALIDACIÓN FALLA, REDIRIGIMOS CON LOS ERRORES
        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // ACTUALIZAMOS LA PELÍCULA EN LA BASE DE DATOS
        $this->peliculaModel->update($id, [
            'titulo'      => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

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
