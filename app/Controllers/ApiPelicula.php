<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL CONTROLADOR BASE RESOURCECONTROLLER DE CODEIGNITER
// RESOURCECONTROLLER FACILITA LA CREACIÓN DE APIs REST CON MÉTODOS PREDEFINIDOS
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
    // =============================================
    public function index()
    {
        // OBTENEMOS TODAS LAS PELÍCULAS ORDENADAS POR ID DESCENDENTE
        $peliculas = $this->model->orderBy('id', 'DESC')->findAll();

        // DEVOLVEMOS LA RESPUESTA EN FORMATO JSON CON CÓDIGO 200 (OK)
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DESCRIPTIVO
            'mensaje' => 'LISTADO DE PELÍCULAS',
            // INCLUIMOS LOS DATOS DE LAS PELÍCULAS
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
            // failNotFound() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 404
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // DEVOLVEMOS LA PELÍCULA ENCONTRADA EN FORMATO JSON CON CÓDIGO 200
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DESCRIPTIVO
            'mensaje' => 'PELÍCULA ENCONTRADA',
            // INCLUIMOS LOS DATOS DE LA PELÍCULA
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
            'titulo'      => $this->request->getVar('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DE LA PETICIÓN
            'descripcion' => $this->request->getVar('descripcion'),
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->model->save($datos)) {
            // failValidationErrors() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 400 Y LOS ERRORES
            return $this->failValidationErrors($this->model->errors());
        }

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 201 (CREATED)
        return $this->respondCreated([
            // INDICAMOS QUE EL RECURSO FUE CREADO EXITOSAMENTE
            'status'  => 201,
            // INCLUIMOS UN MENSAJE DE ÉXITO
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

        // SI NO EXISTE LA PELÍCULA, DEVOLVEMOS ERROR 404
        if ($pelicula === null) {
            // failNotFound() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 404
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // RECOGEMOS LOS DATOS ENVIADOS EN LA PETICIÓN (JSON O FORM-DATA)
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DE LA PETICIÓN
            'titulo'      => $this->request->getVar('titulo'),
            // OBTENEMOS EL CAMPO 'descripcion' DE LA PETICIÓN
            'descripcion' => $this->request->getVar('descripcion'),
        ];

        // INTENTAMOS ACTUALIZAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->model->update($id, $datos)) {
            // failValidationErrors() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 400 Y LOS ERRORES
            return $this->failValidationErrors($this->model->errors());
        }

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 200 (OK)
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DE ÉXITO
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

        // SI NO EXISTE LA PELÍCULA, DEVOLVEMOS ERROR 404
        if ($pelicula === null) {
            // failNotFound() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 404
            return $this->failNotFound('NO SE ENCONTRÓ LA PELÍCULA CON ID ' . $id);
        }

        // ELIMINAMOS LA PELÍCULA DE LA BASE DE DATOS
        $this->model->delete($id);

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 200 (OK)
        return $this->respondDeleted([
            // INDICAMOS QUE EL RECURSO FUE ELIMINADO EXITOSAMENTE
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DE ÉXITO
            'mensaje' => 'PELÍCULA ELIMINADA CORRECTAMENTE',
        ]);
    }
}
