<?php

// IMPORTAMOS LA CLASE ROUTECOLLECTION DE CODEIGNITER
use CodeIgniter\Router\RouteCollection;

// VARIABLE QUE NOS PERMITE DEFINIR TODAS LAS RUTAS DE LA APP
/** @var RouteCollection $routes */

// =============================================
// SECCIÓN 25: FUNCIÓN HELPER PARA REGISTRAR RUTAS CRUD AUTOMÁTICAMENTE
// =============================================
// EN VEZ DE ESCRIBIR 6 LÍNEAS POR CADA ENTIDAD CRUD, ESTA FUNCIÓN LAS GENERA TODAS
// USO: registrarCrud($routes, 'categorias', 'Categoria');
// GENERA: GET /categorias, GET /categorias/create, POST /categorias/store,
//         GET /categorias/edit/(:num), POST /categorias/update/(:num), POST /categorias/delete/(:num)
function registrarCrud($routes, string $prefijo, string $controlador)
{
    // RUTA GET PARA EL LISTADO (INDEX)
    $routes->get("/{$prefijo}", "{$controlador}::index");
    // RUTA GET PARA EL FORMULARIO DE CREACIÓN
    $routes->get("/{$prefijo}/create", "{$controlador}::create");
    // RUTA POST PARA GUARDAR UN NUEVO REGISTRO
    $routes->post("/{$prefijo}/store", "{$controlador}::store");
    // RUTA GET PARA EL FORMULARIO DE EDICIÓN (RECIBE ID NUMÉRICO)
    $routes->get("/{$prefijo}/edit/(:num)", "{$controlador}::edit/$1");
    // RUTA POST PARA ACTUALIZAR UN REGISTRO (RECIBE ID NUMÉRICO)
    $routes->post("/{$prefijo}/update/(:num)", "{$controlador}::update/$1");
    // RUTA POST PARA ELIMINAR UN REGISTRO (RECIBE ID NUMÉRICO)
    $routes->post("/{$prefijo}/delete/(:num)", "{$controlador}::delete/$1");
}

// RUTA PRINCIPAL: AL ENTRAR A LA WEB CARGA EL CONTROLADOR HOME
$routes->get('/', 'Home::index');

// =============================================
// RUTAS DE AUTENTICACIÓN (LOGIN, REGISTRO, LOGOUT)
// ESTAS RUTAS SON PÚBLICAS (NO REQUIEREN ESTAR LOGUEADO)
// =============================================

// GET /auth/login -> MUESTRA EL FORMULARIO DE INICIO DE SESIÓN
$routes->get('/auth/login', 'Auth::login');
// POST /auth/loginPost -> PROCESA EL FORMULARIO DE LOGIN (VERIFICA CREDENCIALES)
$routes->post('/auth/loginPost', 'Auth::loginPost');
// GET /auth/registro -> MUESTRA EL FORMULARIO DE REGISTRO DE NUEVO USUARIO
$routes->get('/auth/registro', 'Auth::registro');
// POST /auth/registroPost -> PROCESA EL FORMULARIO DE REGISTRO (CREA EL USUARIO)
$routes->post('/auth/registroPost', 'Auth::registroPost');
// GET /auth/logout -> CIERRA LA SESIÓN DEL USUARIO Y REDIRIGE AL LOGIN
$routes->get('/auth/logout', 'Auth::logout');

// =============================================
// RUTAS CRUD PARA PELÍCULAS, CATEGORÍAS Y ETIQUETAS
// PROTEGIDAS POR FILTRO AUTH EN Config/Filters.php
// SECCIÓN 25: AHORA USAMOS LA FUNCIÓN registrarCrud() PARA GENERAR LAS 6 RUTAS AUTOMÁTICAMENTE
// =============================================

// REGISTRAMOS LAS RUTAS CRUD PARA PELÍCULAS (6 RUTAS EN 1 LÍNEA)
registrarCrud($routes, 'peliculas', 'Pelicula');
// REGISTRAMOS LAS RUTAS CRUD PARA CATEGORÍAS (6 RUTAS EN 1 LÍNEA)
registrarCrud($routes, 'categorias', 'Categoria');
// REGISTRAMOS LAS RUTAS CRUD PARA ETIQUETAS (6 RUTAS EN 1 LÍNEA)
registrarCrud($routes, 'etiquetas', 'Etiqueta');

// =============================================
// SECCIÓN 23: RUTA PARA EXPORTAR PDF DE UNA PELÍCULA
// =============================================
// GET /peliculas/pdf/5 -> GENERA Y DESCARGA UN PDF CON LA FICHA DE LA PELÍCULA
$routes->get('/peliculas/pdf/(:num)', 'Pelicula::pdf/$1');

// =============================================
// RUTAS DE LA API REST (SECCIÓN 12 + SECCIÓN 19)
// ESTAS RUTAS DEVUELVEN JSON EN VEZ DE HTML
// SE USAN DESDE POSTMAN, APLICACIONES MÓVILES U OTROS FRONTENDS
// =============================================

// AGRUPAMOS TODAS LAS RUTAS DE LA API BAJO EL PREFIJO /api
$routes->group('api', static function ($routes) {

    // -----------------------------------------
    // API REST CRUD PARA CATEGORÍAS
    // -----------------------------------------

    // GET /api/categorias -> OBTENER TODAS LAS CATEGORÍAS EN JSON
    $routes->get('categorias', 'ApiCategoria::index');
    // GET /api/categorias/5 -> OBTENER UNA CATEGORÍA POR SU ID EN JSON
    $routes->get('categorias/(:num)', 'ApiCategoria::show/$1');
    // POST /api/categorias -> CREAR UNA NUEVA CATEGORÍA (ENVIAR DATOS EN JSON O FORM)
    $routes->post('categorias', 'ApiCategoria::create');
    // PUT /api/categorias/5 -> ACTUALIZAR UNA CATEGORÍA EXISTENTE POR SU ID
    $routes->put('categorias/(:num)', 'ApiCategoria::update/$1');
    // DELETE /api/categorias/5 -> ELIMINAR UNA CATEGORÍA POR SU ID
    $routes->delete('categorias/(:num)', 'ApiCategoria::delete/$1');

    // -----------------------------------------
    // API REST CRUD PARA PELÍCULAS
    // -----------------------------------------

    // GET /api/peliculas -> OBTENER TODAS LAS PELÍCULAS (CON PAGINACIÓN Y FILTROS)
    $routes->get('peliculas', 'ApiPelicula::index');
    // GET /api/peliculas/5 -> OBTENER UNA PELÍCULA POR SU ID (CON ETIQUETAS)
    $routes->get('peliculas/(:num)', 'ApiPelicula::show/$1');
    // POST /api/peliculas -> CREAR UNA NUEVA PELÍCULA
    $routes->post('peliculas', 'ApiPelicula::create');
    // PUT /api/peliculas/5 -> ACTUALIZAR UNA PELÍCULA EXISTENTE
    $routes->put('peliculas/(:num)', 'ApiPelicula::update/$1');
    // DELETE /api/peliculas/5 -> ELIMINAR UNA PELÍCULA (CASCADA: IMAGEN + PIVOTE + PELÍCULA)
    $routes->delete('peliculas/(:num)', 'ApiPelicula::delete/$1');

    // -----------------------------------------
    // SECCIÓN 19: ENDPOINTS AVANZADOS DE LA API
    // -----------------------------------------

    // POST /api/peliculas/upload/5 -> SUBIR IMAGEN A UNA PELÍCULA
    $routes->post('peliculas/upload/(:num)', 'ApiPelicula::upload/$1');
    // POST /api/peliculas/5/etiquetas -> ASIGNAR ETIQUETAS A UNA PELÍCULA
    $routes->post('peliculas/(:num)/etiquetas', 'ApiPelicula::asignarEtiquetas/$1');
});
