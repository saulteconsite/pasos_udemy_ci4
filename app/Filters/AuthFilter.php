<?php

// ESPACIO DE NOMBRES PARA LOS FILTROS DE LA APP
namespace App\Filters;

// IMPORTAMOS LAS INTERFACES NECESARIAS DE CODEIGNITER
use CodeIgniter\Filters\FilterInterface;
// IMPORTAMOS LA INTERFAZ DE LA PETICIÓN HTTP
use CodeIgniter\HTTP\RequestInterface;
// IMPORTAMOS LA INTERFAZ DE LA RESPUESTA HTTP
use CodeIgniter\HTTP\ResponseInterface;

// FILTRO DE AUTENTICACIÓN: VERIFICA QUE EL USUARIO HAYA INICIADO SESIÓN
// SE EJECUTA ANTES DE QUE EL CONTROLADOR PROCESE LA PETICIÓN
class AuthFilter implements FilterInterface
{
    // MÉTODO BEFORE: SE EJECUTA ANTES DE LLEGAR AL CONTROLADOR
    // SI EL USUARIO NO ESTÁ LOGUEADO, LO REDIRIGE AL LOGIN
    public function before(RequestInterface $request, $arguments = null)
    {
        // VERIFICAMOS SI EXISTE LA VARIABLE 'logueado' EN LA SESIÓN
        // SI NO EXISTE O ES FALSE, EL USUARIO NO HA INICIADO SESIÓN
        if (!session()->get('logueado')) {
            // REDIRIGIMOS AL FORMULARIO DE LOGIN CON UN MENSAJE DE ADVERTENCIA
            return redirect()->to(base_url('/auth/login'))->with('error', 'DEBES INICIAR SESIÓN PARA ACCEDER A ESTA PÁGINA.');
        }
    }

    // MÉTODO AFTER: SE EJECUTA DESPUÉS DE QUE EL CONTROLADOR PROCESE LA PETICIÓN
    // EN ESTE CASO NO NECESITAMOS HACER NADA DESPUÉS, PERO ES OBLIGATORIO IMPLEMENTARLO
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // NO HACEMOS NADA DESPUÉS DE LA RESPUESTA
    }
}
