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

    // =============================================
    // SECCIÓN 18: MÉTODO INDEX CON PAGINACIÓN Y BÚSQUEDA
    // =============================================
    // MUESTRA EL LISTADO DE ETIQUETAS PAGINADO Y CON BÚSQUEDA POR TEXTO
    public function index()
    {
        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Listado de Etiquetas';

        // RECOGEMOS EL FILTRO DE BÚSQUEDA DE LA URL (?busqueda=clasico)
        $busqueda = $this->request->getGet('busqueda');

        // CONSTRUIMOS LA CONSULTA BASE ORDENADA POR ID DESCENDENTE
        $builder = $this->etiquetaModel->orderBy('id', 'DESC');

        // SI EL USUARIO ESCRIBIÓ ALGO EN EL CAMPO DE BÚSQUEDA
        if (!empty($busqueda)) {
            // like() BUSCA COINCIDENCIAS PARCIALES EN EL NOMBRE
            // 'both' BUSCA %texto% (COINCIDENCIAS EN CUALQUIER POSICIÓN)
            $builder->like('nombre', $busqueda, 'both');
        }

        // paginate(10) DEVUELVE SOLO 10 RESULTADOS POR PÁGINA
        $datos['etiquetas'] = $builder->paginate(10);

        // OBTENEMOS EL OBJETO PAGER PARA GENERAR ENLACES DE PAGINACIÓN EN LA VISTA
        $datos['pager'] = $this->etiquetaModel->pager;

        // PASAMOS EL FILTRO DE BÚSQUEDA PARA QUE SE MANTENGA EN EL INPUT
        $datos['busqueda'] = $busqueda;

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
            'nombre' => $this->request->getPost('nombre'),
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO
        if (!$this->etiquetaModel->save($datos)) {
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

        // RECOGEMOS LOS DATOS DEL FORMULARIO
        $datos = [
            'nombre' => $this->request->getPost('nombre'),
        ];

        // INTENTAMOS ACTUALIZAR
        if (!$this->etiquetaModel->update($id, $datos)) {
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
        $pivote = new \App\Models\PeliculaEtiquetaModel();
        $pivote->where('etiqueta_id', $id)->delete();

        // ELIMINAMOS LA ETIQUETA DE LA BASE DE DATOS
        $this->etiquetaModel->delete($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/etiquetas'))->with('mensaje', 'Etiqueta eliminada correctamente');
    }
}
