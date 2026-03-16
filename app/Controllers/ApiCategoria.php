<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL CONTROLADOR BASE RESOURCECONTROLLER DE CODEIGNITER
// RESOURCECONTROLLER FACILITA LA CREACIÓN DE APIs REST CON MÉTODOS PREDEFINIDOS
use CodeIgniter\RESTful\ResourceController;

// IMPORTAMOS EL MODELO DE CATEGORÍAS
use App\Models\CategoriaModel;

// CONTROLADOR API REST PARA GESTIONAR CATEGORÍAS
// EXTIENDE DE RESOURCECONTROLLER QUE PROPORCIONA RESPUESTAS JSON AUTOMÁTICAS
class ApiCategoria extends ResourceController
{
    // INDICAMOS QUE EL MODELO ASOCIADO A ESTE CONTROLADOR ES CategoriaModel
    protected $modelName = 'App\Models\CategoriaModel';

    // INDICAMOS QUE EL FORMATO DE RESPUESTA ES JSON
    protected $format    = 'json';

    // =============================================
    // MÉTODO INDEX: OBTENER TODAS LAS CATEGORÍAS (GET /api/categorias)
    // =============================================
    public function index()
    {
        // OBTENEMOS TODAS LAS CATEGORÍAS ORDENADAS POR ID DESCENDENTE
        $categorias = $this->model->orderBy('id', 'DESC')->findAll();

        // DEVOLVEMOS LA RESPUESTA EN FORMATO JSON CON CÓDIGO 200 (OK)
        // respond() ES UN MÉTODO DE RESOURCECONTROLLER QUE FORMATEA LA RESPUESTA
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DESCRIPTIVO
            'mensaje' => 'LISTADO DE CATEGORÍAS',
            // INCLUIMOS LOS DATOS DE LAS CATEGORÍAS
            'datos'   => $categorias,
        ]);
    }

    // =============================================
    // MÉTODO SHOW: OBTENER UNA CATEGORÍA POR SU ID (GET /api/categorias/5)
    // =============================================
    public function show($id = null)
    {
        // BUSCAMOS LA CATEGORÍA POR SU ID EN LA BASE DE DATOS
        $categoria = $this->model->find($id);

        // SI NO EXISTE LA CATEGORÍA, DEVOLVEMOS ERROR 404
        if ($categoria === null) {
            // failNotFound() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 404
            return $this->failNotFound('NO SE ENCONTRÓ LA CATEGORÍA CON ID ' . $id);
        }

        // DEVOLVEMOS LA CATEGORÍA ENCONTRADA EN FORMATO JSON CON CÓDIGO 200
        return $this->respond([
            // INDICAMOS QUE LA PETICIÓN FUE EXITOSA
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DESCRIPTIVO
            'mensaje' => 'CATEGORÍA ENCONTRADA',
            // INCLUIMOS LOS DATOS DE LA CATEGORÍA
            'datos'   => $categoria,
        ]);
    }

    // =============================================
    // MÉTODO CREATE: CREAR UNA NUEVA CATEGORÍA (POST /api/categorias)
    // =============================================
    public function create()
    {
        // RECOGEMOS LOS DATOS ENVIADOS EN LA PETICIÓN (JSON O FORM-DATA)
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DE LA PETICIÓN
            'titulo' => $this->request->getVar('titulo'),
        ];

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->model->save($datos)) {
            // failValidationErrors() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 400 Y LOS ERRORES
            return $this->failValidationErrors($this->model->errors());
        }

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 201 (CREATED)
        // respondCreated() ES ESPECÍFICO PARA RECURSOS RECIÉN CREADOS
        return $this->respondCreated([
            // INDICAMOS QUE EL RECURSO FUE CREADO EXITOSAMENTE
            'status'  => 201,
            // INCLUIMOS UN MENSAJE DE ÉXITO
            'mensaje' => 'CATEGORÍA CREADA CORRECTAMENTE',
            // INCLUIMOS EL ID DE LA NUEVA CATEGORÍA
            'id'      => $this->model->getInsertID(),
        ]);
    }

    // =============================================
    // MÉTODO UPDATE: ACTUALIZAR UNA CATEGORÍA EXISTENTE (PUT /api/categorias/5)
    // =============================================
    public function update($id = null)
    {
        // BUSCAMOS LA CATEGORÍA POR SU ID
        $categoria = $this->model->find($id);

        // SI NO EXISTE LA CATEGORÍA, DEVOLVEMOS ERROR 404
        if ($categoria === null) {
            // failNotFound() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 404
            return $this->failNotFound('NO SE ENCONTRÓ LA CATEGORÍA CON ID ' . $id);
        }

        // RECOGEMOS LOS DATOS ENVIADOS EN LA PETICIÓN (JSON O FORM-DATA)
        $datos = [
            // OBTENEMOS EL CAMPO 'titulo' DE LA PETICIÓN
            'titulo' => $this->request->getVar('titulo'),
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
            'mensaje' => 'CATEGORÍA ACTUALIZADA CORRECTAMENTE',
        ]);
    }

    // =============================================
    // MÉTODO DELETE: ELIMINAR UNA CATEGORÍA (DELETE /api/categorias/5)
    // =============================================
    public function delete($id = null)
    {
        // BUSCAMOS LA CATEGORÍA POR SU ID
        $categoria = $this->model->find($id);

        // SI NO EXISTE LA CATEGORÍA, DEVOLVEMOS ERROR 404
        if ($categoria === null) {
            // failNotFound() DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 404
            return $this->failNotFound('NO SE ENCONTRÓ LA CATEGORÍA CON ID ' . $id);
        }

        // ELIMINAMOS LA CATEGORÍA DE LA BASE DE DATOS
        $this->model->delete($id);

        // DEVOLVEMOS UNA RESPUESTA JSON CON CÓDIGO 200 (OK)
        // respondDeleted() ES ESPECÍFICO PARA RECURSOS ELIMINADOS
        return $this->respondDeleted([
            // INDICAMOS QUE EL RECURSO FUE ELIMINADO EXITOSAMENTE
            'status'  => 200,
            // INCLUIMOS UN MENSAJE DE ÉXITO
            'mensaje' => 'CATEGORÍA ELIMINADA CORRECTAMENTE',
        ]);
    }
}
