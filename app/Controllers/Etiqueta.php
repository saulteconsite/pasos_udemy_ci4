<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL MODELO DE ETIQUETAS
use App\Models\EtiquetaModel;

// CONTROLADOR CRUD PARA GESTIONAR ETIQUETAS (TAGS)
// LAS ETIQUETAS SE PUEDEN ASIGNAR A LAS PELÍCULAS (RELACIÓN N:M)
class Etiqueta extends BaseController
{
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO
    protected $etiquetaModel;

    // CONSTRUCTOR: SE EJECUTA AL CREAR UNA INSTANCIA DEL CONTROLADOR
    public function __construct()
    {
        // CREAMOS UNA INSTANCIA DEL MODELO ETIQUETA
        $this->etiquetaModel = new EtiquetaModel();
    }

    // MÉTODO INDEX: MUESTRA EL LISTADO DE TODAS LAS ETIQUETAS
    public function index()
    {
        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Listado de Etiquetas';
        // OBTENEMOS TODAS LAS ETIQUETAS ORDENADAS POR ID DESCENDENTE
        $datos['etiquetas'] = $this->etiquetaModel->orderBy('id', 'DESC')->findAll();

        // CARGAMOS LA VISTA DEL LISTADO Y LE PASAMOS LOS DATOS
        return view('etiquetas/index', $datos);
    }

    // MÉTODO CREATE: MUESTRA EL FORMULARIO PARA CREAR UNA ETIQUETA
    public function create()
    {
        // PREPARAMOS EL TÍTULO PARA LA VISTA
        $datos['titulo'] = 'Crear Etiqueta';

        // CARGAMOS LA VISTA DEL FORMULARIO DE CREACIÓN
        return view('etiquetas/create', $datos);
    }

    // MÉTODO STORE: PROCESA EL FORMULARIO Y GUARDA LA ETIQUETA EN LA BD
    public function store()
    {
        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            // OBTENEMOS EL CAMPO 'nombre' DEL POST
            'nombre' => $this->request->getPost('nombre'),
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN INTERNA, DEVUELVE FALSE
        if (!$this->etiquetaModel->save($datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES DE VALIDACIÓN
            return redirect()->back()->withInput()->with('errors', $this->etiquetaModel->errors());
        }

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/etiquetas'))->with('mensaje', 'Etiqueta creada correctamente');
    }

    // MÉTODO EDIT: MUESTRA EL FORMULARIO PARA EDITAR UNA ETIQUETA EXISTENTE
    public function edit($id = null)
    {
        // BUSCAMOS LA ETIQUETA POR SU ID
        $etiqueta = $this->etiquetaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($etiqueta === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la etiqueta');
        }

        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Editar Etiqueta';
        $datos['etiqueta'] = $etiqueta;

        // CARGAMOS LA VISTA DEL FORMULARIO DE EDICIÓN
        return view('etiquetas/edit', $datos);
    }

    // MÉTODO UPDATE: PROCESA EL FORMULARIO Y ACTUALIZA LA ETIQUETA EN LA BD
    public function update($id = null)
    {
        // BUSCAMOS LA ETIQUETA POR SU ID
        $etiqueta = $this->etiquetaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($etiqueta === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la etiqueta');
        }

        // RECOGEMOS LOS DATOS DEL FORMULARIO EN UN ARRAY
        $datos = [
            // OBTENEMOS EL CAMPO 'nombre' DEL POST
            'nombre' => $this->request->getPost('nombre'),
        ];

        // INTENTAMOS ACTUALIZAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->etiquetaModel->update($id, $datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS ERRORES
            return redirect()->back()->withInput()->with('errors', $this->etiquetaModel->errors());
        }

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/etiquetas'))->with('mensaje', 'Etiqueta actualizada correctamente');
    }

    // MÉTODO DELETE: ELIMINA UNA ETIQUETA DE LA BASE DE DATOS
    public function delete($id = null)
    {
        // BUSCAMOS LA ETIQUETA POR SU ID
        $etiqueta = $this->etiquetaModel->find($id);

        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($etiqueta === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('No se encontró la etiqueta');
        }

        // ELIMINAMOS LOS REGISTROS DE LA TABLA PIVOTE QUE REFERENCIEN A ESTA ETIQUETA
        // SI NO LO HACEMOS, QUEDARÍAN REGISTROS HUÉRFANOS EN pelicula_etiqueta
        $pivote = new \App\Models\PeliculaEtiquetaModel();
        $pivote->where('etiqueta_id', $id)->delete();

        // ELIMINAMOS LA ETIQUETA DE LA BASE DE DATOS
        $this->etiquetaModel->delete($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/etiquetas'))->with('mensaje', 'Etiqueta eliminada correctamente');
    }
}
