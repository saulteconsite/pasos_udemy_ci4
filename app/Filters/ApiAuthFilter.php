<?php

// ESPACIO DE NOMBRES PARA LOS FILTROS DE LA APP
namespace App\Filters;

// IMPORTAMOS LAS INTERFACES NECESARIAS DE CODEIGNITER
use CodeIgniter\Filters\FilterInterface;
// IMPORTAMOS LA INTERFAZ DE LA PETICIÓN HTTP
use CodeIgniter\HTTP\RequestInterface;
// IMPORTAMOS LA INTERFAZ DE LA RESPUESTA HTTP
use CodeIgniter\HTTP\ResponseInterface;

// FILTRO DE AUTENTICACIÓN ESPECÍFICO PARA LA API REST
// A DIFERENCIA DEL AUTHFILTER QUE REDIRIGE AL LOGIN (HTML),
// ESTE FILTRO DEVUELVE UNA RESPUESTA JSON CON CÓDIGO 401
// PORQUE LAS APIs NO TIENEN PÁGINAS HTML, SOLO DEVUELVEN DATOS
class ApiAuthFilter implements FilterInterface
{
    // MÉTODO BEFORE: SE EJECUTA ANTES DE LLEGAR AL CONTROLADOR DE LA API
    // VERIFICA QUE LA PETICIÓN INCLUYA UN TOKEN DE AUTENTICACIÓN EN EL HEADER
    public function before(RequestInterface $request, $arguments = null)
    {
        // LEEMOS EL HEADER "Authorization" DE LA PETICIÓN HTTP
        // EN UNA API, EL CLIENTE ENVÍA SU TOKEN EN ESTE HEADER:
        // Authorization: Bearer abc123def456...
        $tokenHeader = $request->getHeaderLine('Authorization');

        // SI NO HAY HEADER AUTHORIZATION, DEVOLVEMOS ERROR 401 EN JSON
        // 401 = UNAUTHORIZED (NO AUTENTICADO)
        if (empty($tokenHeader)) {
            // USAMOS service('response') PARA CONSTRUIR UNA RESPUESTA HTTP PERSONALIZADA
            return service('response')
                // ESTABLECEMOS EL CUERPO DE LA RESPUESTA COMO JSON
                ->setJSON([
                    // CÓDIGO DE ESTADO HTTP
                    'status'  => 401,
                    // MENSAJE DESCRIPTIVO DEL ERROR
                    'mensaje' => 'TOKEN DE AUTENTICACIÓN REQUERIDO. ENVÍA EL HEADER: Authorization: Bearer tu_token',
                ])
                // ESTABLECEMOS EL CÓDIGO DE ESTADO HTTP A 401
                ->setStatusCode(401);
        }

        // SI HAY TOKEN, VERIFICAMOS QUE TENGA EL FORMATO CORRECTO "Bearer token"
        // str_starts_with() VERIFICA QUE EL STRING COMIENCE CON "Bearer "
        if (!str_starts_with($tokenHeader, 'Bearer ')) {
            // SI EL FORMATO ES INCORRECTO, DEVOLVEMOS ERROR 401
            return service('response')
                ->setJSON([
                    'status'  => 401,
                    'mensaje' => 'FORMATO DE TOKEN INVÁLIDO. USA: Authorization: Bearer tu_token',
                ])
                ->setStatusCode(401);
        }

        // EXTRAEMOS EL TOKEN QUITANDO EL PREFIJO "Bearer "
        // substr() CORTA EL STRING DESDE LA POSICIÓN 7 (LONGITUD DE "Bearer ")
        $token = substr($tokenHeader, 7);

        // AQUÍ SE VERIFICARÍA QUE EL TOKEN SEA VÁLIDO
        // EN UN PROYECTO REAL SE BUSCARÍA EN LA BD O SE VERIFICARÍA UN JWT
        // POR AHORA, ACEPTAMOS CUALQUIER TOKEN NO VACÍO COMO DEMOSTRACIÓN
        if (empty($token)) {
            return service('response')
                ->setJSON([
                    'status'  => 401,
                    'mensaje' => 'TOKEN VACÍO O INVÁLIDO.',
                ])
                ->setStatusCode(401);
        }
    }

    // MÉTODO AFTER: SE EJECUTA DESPUÉS DE QUE EL CONTROLADOR PROCESE LA PETICIÓN
    // EN ESTE CASO NO NECESITAMOS HACER NADA DESPUÉS
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // NO HACEMOS NADA DESPUÉS DE LA RESPUESTA
    }
}
