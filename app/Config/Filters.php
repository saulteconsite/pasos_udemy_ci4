<?php

// ESPACIO DE NOMBRES PARA LA CONFIGURACIÓN DE LA APP
namespace Config;

// IMPORTAMOS LA CLASE BASE DE FILTROS DE CODEIGNITER
use CodeIgniter\Config\Filters as BaseFilters;
// IMPORTAMOS LOS FILTROS PROPIOS DE CODEIGNITER
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
// IMPORTAMOS NUESTROS FILTROS PERSONALIZADOS
use App\Filters\AuthFilter;
use App\Filters\AdminFilter;

// CLASE DE CONFIGURACIÓN DE FILTROS DE LA APLICACIÓN
class Filters extends BaseFilters
{
    // ALIASES: NOMBRES CORTOS PARA REFERENCIAR LOS FILTROS EN LAS RUTAS
    // EN VEZ DE ESCRIBIR App\Filters\AuthFilter, ESCRIBIMOS 'auth'
    public array $aliases = [
        // FILTRO CSRF: PROTEGE CONTRA ATAQUES DE FALSIFICACIÓN DE PETICIONES
        'csrf'          => CSRF::class,
        // FILTRO TOOLBAR: BARRA DE DEPURACIÓN DE CODEIGNITER
        'toolbar'       => DebugToolbar::class,
        // FILTRO HONEYPOT: TRAMPA PARA BOTS QUE RELLENAN FORMULARIOS OCULTOS
        'honeypot'      => Honeypot::class,
        // FILTRO INVALIDCHARS: BLOQUEA CARACTERES NO VÁLIDOS EN LA PETICIÓN
        'invalidchars'  => InvalidChars::class,
        // FILTRO SECUREHEADERS: AÑADE CABECERAS DE SEGURIDAD A LA RESPUESTA
        'secureheaders' => SecureHeaders::class,
        // FILTRO CORS: GESTIONA LOS PERMISOS DE CROSS-ORIGIN RESOURCE SHARING
        'cors'          => Cors::class,
        // FILTRO FORCEHTTPS: FUERZA QUE TODAS LAS PETICIONES USEN HTTPS
        'forcehttps'    => ForceHTTPS::class,
        // FILTRO PAGECACHE: ALMACENA EN CACHÉ LAS PÁGINAS PARA MEJORAR RENDIMIENTO
        'pagecache'     => PageCache::class,
        // FILTRO PERFORMANCE: MÉTRICAS DE RENDIMIENTO DE LA APLICACIÓN
        'performance'   => PerformanceMetrics::class,
        // FILTRO AUTH: NUESTRO FILTRO PERSONALIZADO QUE VERIFICA SI EL USUARIO ESTÁ LOGUEADO
        'auth'          => AuthFilter::class,
        // FILTRO ADMIN: NUESTRO FILTRO PERSONALIZADO QUE VERIFICA SI EL USUARIO ES ADMINISTRADOR
        'admin'         => AdminFilter::class,
    ];

    // FILTROS REQUERIDOS: SE EJECUTAN SIEMPRE, INCLUSO SI LA RUTA NO EXISTE
    // SON ESENCIALES PARA EL FUNCIONAMIENTO DEL FRAMEWORK
    public array $required = [
        'before' => [
            // FORZAR HTTPS EN TODAS LAS PETICIONES
            'forcehttps',
            // CACHÉ DE PÁGINAS WEB
            'pagecache',
        ],
        'after' => [
            // CACHÉ DE PÁGINAS WEB
            'pagecache',
            // MÉTRICAS DE RENDIMIENTO
            'performance',
            // BARRA DE DEPURACIÓN
            'toolbar',
        ],
    ];

    // FILTROS GLOBALES: SE APLICAN A TODAS LAS PETICIONES ANTES Y DESPUÉS
    public array $globals = [
        'before' => [
            // DESCOMENTAR PARA ACTIVAR GLOBALMENTE:
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // DESCOMENTAR PARA ACTIVAR GLOBALMENTE:
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    // FILTROS POR MÉTODO HTTP: SE APLICAN SEGÚN EL TIPO DE PETICIÓN (GET, POST, ETC.)
    public array $methods = [];

    // FILTROS POR PATRÓN DE URI: SE APLICAN A RUTAS QUE COINCIDAN CON EL PATRÓN
    // AQUÍ DEFINIMOS QUÉ RUTAS REQUIEREN AUTENTICACIÓN
    public array $filters = [
        // EL FILTRO 'auth' SE EJECUTA ANTES DE ACCEDER A ESTAS RUTAS
        // SI EL USUARIO NO ESTÁ LOGUEADO, SERÁ REDIRIGIDO AL LOGIN
        'auth' => ['before' => [
            // PROTEGEMOS TODAS LAS RUTAS DE PELÍCULAS (LISTADO, CREAR, EDITAR, ELIMINAR)
            'peliculas',
            'peliculas/*',
            // PROTEGEMOS TODAS LAS RUTAS DE CATEGORÍAS (LISTADO, CREAR, EDITAR, ELIMINAR)
            'categorias',
            'categorias/*',
            // PROTEGEMOS TODAS LAS RUTAS DE ETIQUETAS (LISTADO, CREAR, EDITAR, ELIMINAR)
            'etiquetas',
            'etiquetas/*',
        ]],
    ];
}
