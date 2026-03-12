# `PROYECTO UDEMY - CODEIGNITER 4 🔷`

![img](https://i.pinimg.com/originals/a1/f8/be/a1f8be54a08a324c83e747a8fa5ed660.gif)

> [!NOTE]
> ***ESTE PROYECTO ES EL RESULTADO DE LAS SECCIONES 3 Y 4 DEL CURSO DE UDEMY "CODEIGNITER 4 DESDE CERO + INTEGRACIÓN CON BOOTSTRAP 4 O 5". INCLUYE LOS CRUDS COMPLETOS DE PELÍCULAS Y CATEGORÍAS CON BOOTSTRAP 5, DESPLEGADO CON DDEV EN WSL***

---

## `ESTRUCTURA DEL PROYECTO 📁`

```
app/
├── Config/
│   └── Routes.php                    # RUTAS CRUD DE PELÍCULAS Y CATEGORÍAS
├── Controllers/
│   ├── Pelicula.php                  # CONTROLADOR CRUD PELÍCULAS
│   └── Categoria.php                 # CONTROLADOR CRUD CATEGORÍAS
├── Database/
│   ├── Migrations/
│   │   ├── 2026-03-12-113339_Peliculas.php   # MIGRACIÓN TABLA PELICULAS
│   │   └── 2026-03-12-114415_Categorias.php  # MIGRACIÓN TABLA CATEGORIAS
│   └── Seeds/
│       ├── PeliculaSeeder.php        # DATOS DE PRUEBA: 5 PELÍCULAS
│       └── CategoriaSeeder.php       # DATOS DE PRUEBA: 10 CATEGORÍAS
├── Models/
│   ├── PeliculaModel.php             # MODELO PELÍCULAS
│   └── CategoriaModel.php            # MODELO CATEGORÍAS
└── Views/
    ├── layout/
    │   └── main.php                  # LAYOUT PRINCIPAL CON BOOTSTRAP 5
    ├── peliculas/
    │   ├── index.php                 # LISTADO DE PELÍCULAS
    │   ├── create.php                # FORMULARIO CREAR PELÍCULA
    │   └── edit.php                  # FORMULARIO EDITAR PELÍCULA
    └── categorias/
        ├── index.php                 # LISTADO DE CATEGORÍAS
        ├── create.php                # FORMULARIO CREAR CATEGORÍA
        └── edit.php                  # FORMULARIO EDITAR CATEGORÍA
```

---

## `TECNOLOGÍAS UTILIZADAS 🛠️`

| TECNOLOGÍA | VERSIÓN | USO |
|---|---|---|
| ***CodeIgniter*** | ***4.7.0*** | ***Framework PHP*** |
| ***PHP*** | ***8.4*** | ***Lenguaje del servidor*** |
| ***MariaDB*** | ***11.8*** | ***Base de datos*** |
| ***Bootstrap*** | ***5.3.3*** | ***Framework CSS para la interfaz*** |
| ***Font Awesome*** | ***6.5.1*** | ***Íconos*** |
| ***DDEV*** | ***v1.25.1*** | ***Entorno de desarrollo local*** |
| ***WSL2*** | ***-*** | ***Subsistema Windows para Linux*** |
| ***Apache*** | ***apache-fpm*** | ***Servidor web*** |

---

## `CÓMO ARRANCAR EL PROYECTO 🚀`

> [!CAUTION]
> ***ES NECESARIO TENER WSL2, DDEV Y DOCKER INSTALADOS EN EL SISTEMA ANTES DE EMPEZAR***

### `PASO 1: CLONAR EL REPOSITORIO EN WSL`

```bash
> cd /home/ddev/www
> git clone https://github.com/saulteconsite/pasos_udemy_ci4.git udemy
> cd udemy
```

### `PASO 2: CONFIGURAR DDEV`

```bash
# INICIALIZAR DDEV INDICANDO QUE ES UN PROYECTO PHP CON DOCROOT EN PUBLIC
> ddev config --project-type=php --docroot=public

# ARRANCAR LOS CONTENEDORES (WEB, BASE DE DATOS, ROUTER)
> ddev start
```

### `PASO 3: INSTALAR DEPENDENCIAS CON COMPOSER`

```bash
> ddev composer install
```

### `PASO 4: CONFIGURAR EL ARCHIVO .env`

> [!IMPORTANT]
> ***EL ARCHIVO `.env` NO SE SUBE A GITHUB POR SEGURIDAD. HAY QUE CREARLO COPIANDO EL ARCHIVO `env` DE EJEMPLO Y CONFIGURÁNDOLO PARA DDEV***

```bash
> cp env .env
```

***EDITAR EL ARCHIVO `.env` CON LOS SIGUIENTES VALORES:***

```env
CI_ENVIRONMENT = development

app.baseURL = 'https://udemy.ddev.site'

database.default.hostname = db
database.default.database = db
database.default.username = db
database.default.password = db
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

### `PASO 5: EJECUTAR LAS MIGRACIONES Y SEEDERS`

```bash
# CREAR LAS TABLAS EN LA BASE DE DATOS
> ddev exec php spark migrate

# INSERTAR LOS DATOS DE PRUEBA
> ddev exec php spark db:seed PeliculaSeeder
> ddev exec php spark db:seed CategoriaSeeder
```

### `PASO 6: ABRIR EN EL NAVEGADOR`

```bash
> ddev launch
```

> [!TIP]
> ***TAMBIÉN SE PUEDE ACCEDER DIRECTAMENTE A `https://udemy.ddev.site/peliculas` O `https://udemy.ddev.site/categorias`***

---

## `SECCIÓN 3: CRUD PELÍCULAS 🎬`

> [!NOTE]
> ***EN ESTA SECCIÓN SE CREA EL PRIMER CRUD COMPLETO DEL CURSO. SE TRABAJA CON MIGRACIONES, MODELO, CONTROLADOR, VISTAS Y RUTAS PARA GESTIONAR UNA TABLA DE PELÍCULAS***

### `MIGRACIÓN DE LA TABLA PELÍCULAS`

```bash
# CREAR EL ARCHIVO DE MIGRACIÓN
> ddev exec php spark make:migration Peliculas
```

***SE EDITA EL ARCHIVO CREADO EN `app/Database/Migrations/` DEFINIENDO LAS COLUMNAS:***

```php
// COLUMNAS DE LA TABLA PELICULAS
$this->forge->addField([
    'id' => [
        'type'           => 'INT',
        'constraint'     => 11,
        'unsigned'       => true,
        'auto_increment' => true,   // EL ID SE PONE SOLO
    ],
    'titulo' => [
        'type'       => 'VARCHAR',
        'constraint' => '150',      // MÁXIMO 150 CARACTERES
    ],
    'descripcion' => [
        'type' => 'TEXT',
        'null' => true,             // PUEDE ESTAR VACÍO
    ],
    'created_at' => [
        'type' => 'DATETIME',
        'null' => true,             // FECHA DE CREACIÓN AUTOMÁTICA
    ],
    'updated_at' => [
        'type' => 'DATETIME',
        'null' => true,             // FECHA DE ACTUALIZACIÓN AUTOMÁTICA
    ],
]);
```

```bash
# EJECUTAR LA MIGRACIÓN PARA CREAR LA TABLA REAL EN LA BD
> ddev exec php spark migrate
```

### `MODELO DE PELÍCULAS`

> [!NOTE]
> ***EL MODELO ES EL ÚNICO QUE TIENE PERMISO PARA HABLAR CON LA BASE DE DATOS. AQUÍ SE INDICA A QUÉ TABLA ESTÁ CONECTADO, QUÉ CAMPOS SE PUEDEN MODIFICAR Y SI SE GESTIONAN LAS FECHAS AUTOMÁTICAMENTE***

```php
class PeliculaModel extends Model
{
    // NOMBRE DE LA TABLA EN LA BASE DE DATOS
    protected $table      = 'peliculas';

    // CAMPO QUE ACTÚA COMO CLAVE PRIMARIA
    protected $primaryKey = 'id';

    // CAMPOS QUE SE PUEDEN INSERTAR/ACTUALIZAR DESDE FORMULARIOS
    protected $allowedFields = ['titulo', 'descripcion'];

    // ACTIVAR GESTIÓN AUTOMÁTICA DE CREATED_AT Y UPDATED_AT
    protected $useTimestamps = true;
}
```

### `CONTROLADOR DE PELÍCULAS`

> [!NOTE]
> ***EL CONTROLADOR TIENE 6 MÉTODOS QUE FORMAN EL CRUD COMPLETO: INDEX (LISTAR), CREATE (MOSTRAR FORMULARIO), STORE (GUARDAR), EDIT (MOSTRAR FORMULARIO EDICIÓN), UPDATE (ACTUALIZAR), DELETE (ELIMINAR)***

| MÉTODO | QUÉ HACE |
|---|---|
| ***`index()`*** | ***OBTIENE TODAS LAS PELÍCULAS DEL MODELO Y LAS ENVÍA A LA VISTA DEL LISTADO*** |
| ***`create()`*** | ***CARGA LA VISTA CON EL FORMULARIO VACÍO PARA CREAR UNA PELÍCULA*** |
| ***`store()`*** | ***RECIBE LOS DATOS DEL FORMULARIO, LOS VALIDA Y LOS GUARDA EN LA BD*** |
| ***`edit($id)`*** | ***BUSCA LA PELÍCULA POR ID Y CARGA LA VISTA CON EL FORMULARIO PRECARGADO*** |
| ***`update($id)`*** | ***RECIBE LOS DATOS EDITADOS, LOS VALIDA Y ACTUALIZA EL REGISTRO EN LA BD*** |
| ***`delete($id)`*** | ***BUSCA LA PELÍCULA POR ID Y LA ELIMINA DE LA BD*** |

***EJEMPLO DE VALIDACIÓN EN EL MÉTODO STORE:***

```php
// DEFINIMOS LAS REGLAS DE VALIDACIÓN PARA LOS CAMPOS
$reglas = [
    'titulo'      => 'required|min_length[3]|max_length[150]',
    'descripcion' => 'permit_empty|max_length[5000]',
];

// SI LA VALIDACIÓN FALLA, REDIRIGIMOS AL FORMULARIO CON LOS ERRORES
if (!$this->validate($reglas)) {
    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
}
```

### `RUTAS DE PELÍCULAS`

```php
// GET /peliculas -> MUESTRA EL LISTADO DE PELÍCULAS
$routes->get('/peliculas', 'Pelicula::index');

// GET /peliculas/create -> MUESTRA EL FORMULARIO PARA CREAR
$routes->get('/peliculas/create', 'Pelicula::create');

// POST /peliculas/store -> PROCESA Y GUARDA UNA NUEVA PELÍCULA
$routes->post('/peliculas/store', 'Pelicula::store');

// GET /peliculas/edit/5 -> MUESTRA EL FORMULARIO PARA EDITAR (RECIBE ID NUMÉRICO)
$routes->get('/peliculas/edit/(:num)', 'Pelicula::edit/$1');

// POST /peliculas/update/5 -> PROCESA Y ACTUALIZA UNA PELÍCULA
$routes->post('/peliculas/update/(:num)', 'Pelicula::update/$1');

// POST /peliculas/delete/5 -> ELIMINA UNA PELÍCULA
$routes->post('/peliculas/delete/(:num)', 'Pelicula::delete/$1');
```

### `VISTAS DE PELÍCULAS`

> [!TIP]
> ***TODAS LAS VISTAS EXTIENDEN EL LAYOUT PRINCIPAL CON `$this->extend('layout/main')` Y DEFINEN SU CONTENIDO DENTRO DE `$this->section('contenido')`. EL LAYOUT CONTIENE LA NAVBAR, BOOTSTRAP 5 Y EL SISTEMA DE MENSAJES FLASH***

- ***`index.php` → TABLA CON LISTADO DE TODAS LAS PELÍCULAS, BOTONES DE EDITAR (AMARILLO) Y ELIMINAR (ROJO) CON CONFIRMACIÓN***
- ***`create.php` → FORMULARIO CON CAMPOS TÍTULO Y DESCRIPCIÓN, TOKEN CSRF, FUNCIÓN `old()` PARA MANTENER DATOS SI HAY ERROR***
- ***`edit.php` → FORMULARIO PRECARGADO CON LOS DATOS ACTUALES DE LA PELÍCULA***

### `SEEDER DE PELÍCULAS`

```bash
# CREAR EL ARCHIVO SEEDER
> ddev exec php spark make:seeder PeliculaSeeder

# EJECUTAR EL SEEDER (INSERTA 5 PELÍCULAS DE PRUEBA)
> ddev exec php spark db:seed PeliculaSeeder
```

***PELÍCULAS INSERTADAS: El Padrino, Pulp Fiction, Interestelar, Matrix, Coco***

---

## `SECCIÓN 4: CRUD CATEGORÍAS (RETO) 🏷️`

> [!NOTE]
> ***LA SECCIÓN 4 ES UN RETO DEL CURSO. SE PIDE REPLICAR TODO LO APRENDIDO CON PELÍCULAS PERO PARA UNA TABLA DE CATEGORÍAS. ES EXACTAMENTE EL MISMO PATRÓN CRUD PERO CON UN SOLO CAMPO (TITULO)***

### `MIGRACIÓN DE LA TABLA CATEGORÍAS`

```bash
# CREAR EL ARCHIVO DE MIGRACIÓN
> ddev exec php spark make:migration Categorias
```

***SE EDITA EL ARCHIVO DEFINIENDO LAS COLUMNAS: `id`, `titulo` (VARCHAR 100), `created_at`, `updated_at`***

```bash
# EJECUTAR LA MIGRACIÓN
> ddev exec php spark migrate
```

### `MODELO DE CATEGORÍAS`

```php
class CategoriaModel extends Model
{
    protected $table      = 'categorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo'];    // SOLO UN CAMPO EDITABLE
    protected $useTimestamps = true;
}
```

### `CONTROLADOR DE CATEGORÍAS`

***MISMA ESTRUCTURA QUE EL DE PELÍCULAS: 6 MÉTODOS CRUD (INDEX, CREATE, STORE, EDIT, UPDATE, DELETE)***

### `RUTAS DE CATEGORÍAS`

```php
$routes->get('/categorias', 'Categoria::index');
$routes->get('/categorias/create', 'Categoria::create');
$routes->post('/categorias/store', 'Categoria::store');
$routes->get('/categorias/edit/(:num)', 'Categoria::edit/$1');
$routes->post('/categorias/update/(:num)', 'Categoria::update/$1');
$routes->post('/categorias/delete/(:num)', 'Categoria::delete/$1');
```

### `SEEDER DE CATEGORÍAS`

```bash
# CREAR Y EJECUTAR EL SEEDER (INSERTA 10 CATEGORÍAS)
> ddev exec php spark make:seeder CategoriaSeeder
> ddev exec php spark db:seed CategoriaSeeder
```

***CATEGORÍAS INSERTADAS: Acción, Comedia, Drama, Terror, Ciencia Ficción, Romance, Animación, Suspenso, Aventura, Documental***

---

## `LAYOUT PRINCIPAL CON BOOTSTRAP 5 🎨`

> [!NOTE]
> ***EL LAYOUT (`app/Views/layout/main.php`) ES LA PLANTILLA MAESTRA QUE HEREDAN TODAS LAS VISTAS. CONTIENE LA ESTRUCTURA HTML COMPLETA, LA NAVBAR Y EL SISTEMA DE MENSAJES FLASH***

- ***BOOTSTRAP 5.3.3 → CARGADO DESDE CDN PARA LOS ESTILOS (TABLAS, BOTONES, ALERTAS, FORMULARIOS, NAVBAR)***
- ***FONT AWESOME 6.5.1 → CARGADO DESDE CDN PARA LOS ÍCONOS (EDITAR, ELIMINAR, GUARDAR, VOLVER)***
- ***NAVBAR → BARRA DE NAVEGACIÓN OSCURA CON ENLACES A PELÍCULAS Y CATEGORÍAS***
- ***MENSAJES FLASH → SI EL CONTROLADOR ENVÍA UN MENSAJE POR SESIÓN, SE MUESTRA UNA ALERTA VERDE DESCARTABLE***
- ***`renderSection('contenido')` → PUNTO DONDE SE INYECTA EL CONTENIDO DE CADA VISTA HIJA***

---

## `COMANDOS DE REFERENCIA RÁPIDA 🥣`

### `DDEV`

```bash
> ddev start          # ARRANCAR EL PROYECTO
> ddev stop           # PARAR EL PROYECTO
> ddev poweroff       # APAGAR TODO DDEV (TODOS LOS PROYECTOS)
> ddev ssh            # ENTRAR AL CONTENEDOR WEB POR SSH
> ddev launch         # ABRIR EL PROYECTO EN EL NAVEGADOR
> ddev mysql          # ACCEDER A MYSQL DIRECTAMENTE
> ddev logs           # VER LOGS DEL PROYECTO
> ddev restart        # REINICIAR LOS CONTENEDORES
```

### `CODEIGNITER 4 - SPARK`

```bash
> ddev exec php spark migrate              # EJECUTAR MIGRACIONES
> ddev exec php spark migrate:status       # VER ESTADO DE LAS MIGRACIONES
> ddev exec php spark migrate:rollback     # DESHACER LA ÚLTIMA MIGRACIÓN
> ddev exec php spark migrate:rollback -a  # DESHACER TODAS LAS MIGRACIONES
> ddev exec php spark db:seed NombreSeeder # EJECUTAR UN SEEDER
> ddev exec php spark routes               # VER TODAS LAS RUTAS REGISTRADAS
> ddev exec php spark make:migration Nombre    # CREAR MIGRACIÓN
> ddev exec php spark make:controller Nombre   # CREAR CONTROLADOR
> ddev exec php spark make:model NombreModel   # CREAR MODELO
> ddev exec php spark make:seeder NombreSeeder # CREAR SEEDER
```

### `WSL (DESDE POWERSHELL)`

```powershell
> wsl --shutdown           # APAGAR WSL COMPLETAMENTE
> wsl --list --verbose     # VER ESTADO DE LAS DISTRIBUCIONES
> wsl -d DDEV              # ENTRAR A LA DISTRIBUCIÓN DDEV
```

---

## `URLS DE ACCESO 🌐`

| URL | DESCRIPCIÓN |
|---|---|
| ***https://udemy.ddev.site*** | ***PÁGINA PRINCIPAL*** |
| ***https://udemy.ddev.site/peliculas*** | ***CRUD DE PELÍCULAS*** |
| ***https://udemy.ddev.site/categorias*** | ***CRUD DE CATEGORÍAS*** |

---

> [!TIP]
> ***TODO EL CÓDIGO DEL PROYECTO ESTÁ COMENTADO LÍNEA POR LÍNEA EN MAYÚSCULAS PARA FACILITAR EL APRENDIZAJE***
