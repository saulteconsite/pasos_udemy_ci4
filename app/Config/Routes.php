<?php

// IMPORTAMOS LA CLASE ROUTECOLLECTION DE CODEIGNITER
use CodeIgniter\Router\RouteCollection;

// VARIABLE QUE NOS PERMITE DEFINIR TODAS LAS RUTAS DE LA APP
/** @var RouteCollection $routes */

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
// RUTAS CRUD PARA PELÍCULAS (PROTEGIDAS POR FILTRO AUTH EN Config/Filters.php)
// EL USUARIO DEBE ESTAR LOGUEADO PARA ACCEDER A ESTAS RUTAS
// =============================================

// GET /peliculas -> MUESTRA EL LISTADO DE PELÍCULAS
$routes->get('/peliculas', 'Pelicula::index');
// GET /peliculas/create -> MUESTRA EL FORMULARIO PARA CREAR
$routes->get('/peliculas/create', 'Pelicula::create');
// POST /peliculas/store -> PROCESA Y GUARDA UNA NUEVA PELÍCULA
$routes->post('/peliculas/store', 'Pelicula::store');
// GET /peliculas/edit/5 -> MUESTRA EL FORMULARIO PARA EDITAR (RECIBE ID NUMÉRICO)
$routes->get('/peliculas/edit/(:num)', 'Pelicula::edit/$1');
// POST /peliculas/update/5 -> PROCESA Y ACTUALIZA UNA PELÍCULA (RECIBE ID NUMÉRICO)
$routes->post('/peliculas/update/(:num)', 'Pelicula::update/$1');
// POST /peliculas/delete/5 -> ELIMINA UNA PELÍCULA (RECIBE ID NUMÉRICO)
$routes->post('/peliculas/delete/(:num)', 'Pelicula::delete/$1');

// =============================================
// RUTAS CRUD PARA CATEGORÍAS (PROTEGIDAS POR FILTRO AUTH EN Config/Filters.php)
// EL USUARIO DEBE ESTAR LOGUEADO PARA ACCEDER A ESTAS RUTAS
// =============================================

// GET /categorias -> MUESTRA EL LISTADO DE CATEGORÍAS
$routes->get('/categorias', 'Categoria::index');
// GET /categorias/create -> MUESTRA EL FORMULARIO PARA CREAR
$routes->get('/categorias/create', 'Categoria::create');
// POST /categorias/store -> PROCESA Y GUARDA UNA NUEVA CATEGORÍA
$routes->post('/categorias/store', 'Categoria::store');
// GET /categorias/edit/5 -> MUESTRA EL FORMULARIO PARA EDITAR (RECIBE ID NUMÉRICO)
$routes->get('/categorias/edit/(:num)', 'Categoria::edit/$1');
// POST /categorias/update/5 -> PROCESA Y ACTUALIZA UNA CATEGORÍA (RECIBE ID NUMÉRICO)
$routes->post('/categorias/update/(:num)', 'Categoria::update/$1');
// POST /categorias/delete/5 -> ELIMINA UNA CATEGORÍA (RECIBE ID NUMÉRICO)
$routes->post('/categorias/delete/(:num)', 'Categoria::delete/$1');

// =============================================
// RUTAS DE LA API REST (SECCIÓN 12)
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

    // GET /api/peliculas -> OBTENER TODAS LAS PELÍCULAS EN JSON
    $routes->get('peliculas', 'ApiPelicula::index');
    // GET /api/peliculas/5 -> OBTENER UNA PELÍCULA POR SU ID EN JSON
    $routes->get('peliculas/(:num)', 'ApiPelicula::show/$1');
    // POST /api/peliculas -> CREAR UNA NUEVA PELÍCULA (ENVIAR DATOS EN JSON O FORM)
    $routes->post('peliculas', 'ApiPelicula::create');
    // PUT /api/peliculas/5 -> ACTUALIZAR UNA PELÍCULA EXISTENTE POR SU ID
    $routes->put('peliculas/(:num)', 'ApiPelicula::update/$1');
    // DELETE /api/peliculas/5 -> ELIMINAR UNA PELÍCULA POR SU ID
    $routes->delete('peliculas/(:num)', 'ApiPelicula::delete/$1');
});
