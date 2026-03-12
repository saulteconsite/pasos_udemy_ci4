<?php

// IMPORTAMOS LA CLASE ROUTECOLLECTION DE CODEIGNITER
use CodeIgniter\Router\RouteCollection;

// VARIABLE QUE NOS PERMITE DEFINIR TODAS LAS RUTAS DE LA APP
/** @var RouteCollection $routes */

// RUTA PRINCIPAL: AL ENTRAR A LA WEB CARGA EL CONTROLADOR HOME
$routes->get('/', 'Home::index');

// =============================================
// RUTAS CRUD PARA PELÍCULAS
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
// RUTAS CRUD PARA CATEGORÍAS
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
