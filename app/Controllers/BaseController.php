<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS LA CLASE CONTROLLER BASE DE CODEIGNITER
use CodeIgniter\Controller;
// IMPORTAMOS LA INTERFAZ DE LA PETICIÓN HTTP
use CodeIgniter\HTTP\RequestInterface;
// IMPORTAMOS LA INTERFAZ DE LA RESPUESTA HTTP
use CodeIgniter\HTTP\ResponseInterface;
// IMPORTAMOS LA INTERFAZ DEL LOGGER (REGISTRO DE ERRORES Y EVENTOS)
use Psr\Log\LoggerInterface;

// CONTROLADOR BASE DEL QUE HEREDAN TODOS LOS DEMÁS CONTROLADORES
// AQUÍ SE CARGAN HELPERS, MODELOS Y LIBRERÍAS QUE NECESITAN TODOS LOS CONTROLADORES
abstract class BaseController extends Controller
{
    // =============================================
    // SECCIÓN 24: HELPERS QUE SE CARGAN AUTOMÁTICAMENTE EN TODOS LOS CONTROLADORES
    // =============================================
    // AL DEFINIR HELPERS AQUÍ, SE CARGAN AUTOMÁTICAMENTE EN CADA CONTROLADOR
    // QUE HEREDE DE BASECONTROLLER (ES DECIR, TODOS)
    // 'proyecto' CARGA app/Helpers/proyecto_helper.php CON NUESTRAS FUNCIONES PERSONALIZADAS
    protected $helpers = ['url', 'form', 'proyecto'];

    // MÉTODO initController: SE EJECUTA AL INICIALIZAR CUALQUIER CONTROLADOR
    // AQUÍ SE CARGAN COMPONENTES COMPARTIDOS (HELPERS, MODELOS, LIBRERÍAS)
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // LLAMAMOS AL MÉTODO PADRE PARA INICIALIZAR EL CONTROLADOR BASE DE CODEIGNITER
        // ES OBLIGATORIO LLAMAR A parent::initController() ANTES DE CUALQUIER OTRA COSA
        parent::initController($request, $response, $logger);
    }
}
