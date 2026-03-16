<?php

// ESPACIO DE NOMBRES PARA LOS FILTROS DE LA APP
namespace App\Filters;

// IMPORTAMOS LAS INTERFACES NECESARIAS DE CODEIGNITER
use CodeIgniter\Filters\FilterInterface;
// IMPORTAMOS LA INTERFAZ DE LA PETICIÓN HTTP
use CodeIgniter\HTTP\RequestInterface;
// IMPORTAMOS LA INTERFAZ DE LA RESPUESTA HTTP
use CodeIgniter\HTTP\ResponseInterface;

// FILTRO DE ADMINISTRADOR: VERIFICA QUE EL USUARIO SEA ADMIN
// SE EJECUTA DESPUÉS DEL FILTRO AUTH, ASÍ QUE YA SABEMOS QUE ESTÁ LOGUEADO
class AdminFilter implements FilterInterface
{
    // MÉTODO BEFORE: SE EJECUTA ANTES DE LLEGAR AL CONTROLADOR
    // SI EL USUARIO NO TIENE ROL 'admin', LO REDIRIGE CON ERROR
    public function before(RequestInterface $request, $arguments = null)
    {
        // VERIFICAMOS SI EL ROL DEL USUARIO EN LA SESIÓN ES DIFERENTE DE 'admin'
        if (session()->get('usuario_rol') !== 'admin') {
            // REDIRIGIMOS AL LISTADO DE PELÍCULAS CON UN MENSAJE DE ERROR
            return redirect()->to(base_url('/peliculas'))->with('error', 'NO TIENES PERMISOS DE ADMINISTRADOR PARA ACCEDER A ESTA PÁGINA.');
        }
    }

    // MÉTODO AFTER: SE EJECUTA DESPUÉS DE QUE EL CONTROLADOR PROCESE LA PETICIÓN
    // EN ESTE CASO NO NECESITAMOS HACER NADA DESPUÉS, PERO ES OBLIGATORIO IMPLEMENTARLO
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // NO HACEMOS NADA DESPUÉS DE LA RESPUESTA
    }
}
