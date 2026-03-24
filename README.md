# `PROYECTO UDEMY - CODEIGNITER 4 🔷`

![img](https://i.pinimg.com/originals/a1/f8/be/a1f8be54a08a324c83e747a8fa5ed660.gif)

> [!NOTE]
> ***ESTE PROYECTO ES EL RESULTADO DE LAS SECCIONES 3 A 25 DEL CURSO DE UDEMY "CODEIGNITER 4 DESDE CERO + INTEGRACIÓN CON BOOTSTRAP 4 O 5". INCLUYE LOS CRUDS COMPLETOS DE PELÍCULAS, CATEGORÍAS Y ETIQUETAS, RELACIONES UNO A MUCHOS (1:N) Y MUCHOS A MUCHOS (N:M), CARGA DE ARCHIVOS (IMÁGENES), VALIDACIONES AVANZADAS, SISTEMA DE AUTENTICACIÓN CON LOGIN/REGISTRO, FILTROS DE SEGURIDAD, CONTRASEÑAS HASHEADAS CON BCRYPT, ROLES DE USUARIO (ADMIN/USUARIO), API REST COMPLETA Y LISTADOS PAGINADOS CON FILTROS AVANZADOS (BÚSQUEDA, CATEGORÍA, ETIQUETA Y LIKE AGRUPADO). ADEMÁS INCLUYE API REST AVANZADA CON PAGINACIÓN/FILTROS/UPLOAD (SECCIÓN 19), DOCUMENTACIÓN DE CODEIGNITER SHIELD (SECCIONES 20-21), COMPONENTES AVANZADOS DEL FRAMEWORK (SECCIÓN 22), LIBRERÍA PERSONALIZADA PDFGENERATOR (SECCIÓN 23), HELPER PERSONALIZADO CON FUNCIONES UTILITARIAS (SECCIÓN 24) Y SISTEMA CRUD AUTOMATIZADO CON CONTROLADOR BASE Y COMANDO SPARK (SECCIÓN 25). TODO DESPLEGADO CON DDEV EN WSL***

---

## `ESTRUCTURA DEL PROYECTO 📁`

```
app/
├── Config/
│   ├── Routes.php                    # RUTAS CRUD, AUTH, ETIQUETAS Y API REST (app/Config/Routes.php)
│   ├── Filters.php                   # CONFIGURACIÓN DE FILTROS AUTH Y ADMIN (app/Config/Filters.php)
│   └── Pager.php                     # CONFIGURACIÓN DE PAGINACIÓN (PLANTILLAS BOOTSTRAP)
├── Controllers/
│   ├── Pelicula.php                  # CONTROLADOR CRUD PELÍCULAS (CON CATEGORÍA, ETIQUETAS E IMAGEN)
│   ├── Categoria.php                 # CONTROLADOR CRUD CATEGORÍAS (WEB)
│   ├── Etiqueta.php                  # CONTROLADOR CRUD ETIQUETAS/TAGS (WEB)
│   ├── Auth.php                      # CONTROLADOR AUTENTICACIÓN (LOGIN, REGISTRO, LOGOUT)
│   ├── ApiPelicula.php               # CONTROLADOR API REST PELÍCULAS (JSON) + UPLOAD/ETIQUETAS (SECCIÓN 19)
│   ├── ApiCategoria.php              # CONTROLADOR API REST CATEGORÍAS (JSON)
│   └── CrudController.php            # CONTROLADOR BASE ABSTRACTO: CRUD AUTOMATIZADO (SECCIÓN 25)
├── Database/
│   ├── Migrations/
│   │   ├── 2026-03-12-113339_Peliculas.php               # MIGRACIÓN TABLA PELICULAS
│   │   ├── 2026-03-12-114415_Categorias.php              # MIGRACIÓN TABLA CATEGORIAS
│   │   ├── 2026-03-16-100000_Usuarios.php                # MIGRACIÓN TABLA USUARIOS (CON HASH)
│   │   ├── 2026-03-16-140000_AddCategoriaIdToPeliculas.php  # AÑADIR FK categoria_id (1:N)
│   │   ├── 2026-03-16-150000_Etiquetas.php               # MIGRACIÓN TABLA ETIQUETAS
│   │   ├── 2026-03-16-160000_PeliculaEtiqueta.php        # TABLA PIVOTE (N:M)
│   │   └── 2026-03-16-170000_AddImagenToPeliculas.php    # AÑADIR CAMPO imagen
│   └── Seeds/
│       ├── PeliculaSeeder.php        # DATOS DE PRUEBA: 5 PELÍCULAS
│       ├── CategoriaSeeder.php       # DATOS DE PRUEBA: 10 CATEGORÍAS
│       ├── UsuarioSeeder.php         # DATOS DE PRUEBA: 3 USUARIOS (ADMIN + NORMALES)
│       └── EtiquetaSeeder.php        # DATOS DE PRUEBA: 8 ETIQUETAS
├── Commands/
│   └── GenerarCrud.php              # COMANDO SPARK: php spark crud:generar (SECCIÓN 25)
├── Filters/
│   ├── AuthFilter.php                # FILTRO: VERIFICA QUE EL USUARIO ESTÉ LOGUEADO
│   ├── AdminFilter.php               # FILTRO: VERIFICA QUE EL USUARIO SEA ADMIN
│   └── ApiAuthFilter.php             # FILTRO: VERIFICA TOKEN EN API REST (SECCIÓN 19)
├── Helpers/
│   └── proyecto_helper.php           # HELPER PERSONALIZADO: FUNCIONES UTILITARIAS (SECCIÓN 24)
├── Libraries/
│   └── PdfGenerator.php              # LIBRERÍA PERSONALIZADA: GENERACIÓN DE PDFs (SECCIÓN 23)
├── Models/
│   ├── PeliculaModel.php             # MODELO PELÍCULAS (JOIN CATEGORÍA + FILTROS PAGINADOS)
│   ├── CategoriaModel.php            # MODELO CATEGORÍAS (CON VALIDACIÓN, UNIQUE Y MENSAJES)
│   ├── EtiquetaModel.php             # MODELO ETIQUETAS (CON VALIDACIÓN Y UNIQUE)
│   ├── PeliculaEtiquetaModel.php     # MODELO TABLA PIVOTE (SINCRONIZAR RELACIÓN N:M)
│   └── UsuarioModel.php              # MODELO USUARIOS (CON HASH BCRYPT AUTOMÁTICO)
└── Views/
    ├── layout/
    │   └── main.php                  # LAYOUT PRINCIPAL CON NAVBAR DINÁMICA (LOGIN/LOGOUT)
    ├── peliculas/
    │   ├── index.php                 # LISTADO PAGINADO CON FILTROS (BÚSQUEDA, CATEGORÍA, ETIQUETA)
    │   ├── create.php                # FORMULARIO CREAR (SELECT CATEGORÍA + CHECKBOXES ETIQUETAS + IMAGEN)
    │   └── edit.php                  # FORMULARIO EDITAR (PRECARGADO CON RELACIONES E IMAGEN)
    ├── etiquetas/
    │   ├── index.php                 # LISTADO PAGINADO CON BÚSQUEDA
    │   ├── create.php                # FORMULARIO CREAR ETIQUETA
    │   └── edit.php                  # FORMULARIO EDITAR ETIQUETA
    ├── categorias/
    │   ├── index.php                 # LISTADO PAGINADO CON BÚSQUEDA
    │   ├── create.php                # FORMULARIO CREAR CATEGORÍA
    │   └── edit.php                  # FORMULARIO EDITAR CATEGORÍA
    └── auth/
        ├── login.php                 # FORMULARIO DE INICIO DE SESIÓN
        └── registro.php              # FORMULARIO DE REGISTRO DE USUARIO
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

> [!CAUTION]
> ***ESTE PASO ES OBLIGATORIO. SI NO SE EJECUTAN LAS MIGRACIONES, LAS TABLAS NO EXISTIRÁN EN LA BASE DE DATOS Y LA APLICACIÓN DARÁ ERROR. SI NO SE EJECUTAN LOS SEEDERS, NO HABRÁ DATOS DE PRUEBA NI USUARIOS PARA HACER LOGIN***

```bash
# CREAR LAS TABLAS EN LA BASE DE DATOS (PELICULAS, CATEGORIAS Y USUARIOS)
# ESTE COMANDO LEE TODOS LOS ARCHIVOS DE app/Database/Migrations/ Y CREA LAS TABLAS
> ddev exec php spark migrate

# VERIFICAR QUE LAS 3 MIGRACIONES SE HAN EJECUTADO CORRECTAMENTE
> ddev exec php spark migrate:status

# INSERTAR LOS DATOS DE PRUEBA EN LAS TABLAS
> ddev exec php spark db:seed PeliculaSeeder
> ddev exec php spark db:seed CategoriaSeeder
> ddev exec php spark db:seed UsuarioSeeder
> ddev exec php spark db:seed EtiquetaSeeder
```

> [!IMPORTANT]
> ***SI AL INTENTAR HACER LOGIN APARECE UN ERROR DE "TABLE NOT FOUND" O SIMILAR, ES PORQUE NO SE HA EJECUTADO `php spark migrate`. EJECUTA ESE COMANDO Y LUEGO EL SEEDER DE USUARIOS***

### `PASO 6: ABRIR EN EL NAVEGADOR`

```bash
> ddev launch
```

> [!TIP]
> ***TAMBIÉN SE PUEDE ACCEDER DIRECTAMENTE A `https://udemy.ddev.site/auth/login` PARA INICIAR SESIÓN***

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

### `RUTAS DE PELÍCULAS`

```php
$routes->get('/peliculas', 'Pelicula::index');
$routes->get('/peliculas/create', 'Pelicula::create');
$routes->post('/peliculas/store', 'Pelicula::store');
$routes->get('/peliculas/edit/(:num)', 'Pelicula::edit/$1');
$routes->post('/peliculas/update/(:num)', 'Pelicula::update/$1');
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

## `SECCIÓN 9: VALIDACIONES AVANZADAS ✅`

> [!NOTE]
> ***EN ESTA SECCIÓN SE MEJORAN LAS VALIDACIONES MOVIENDO LAS REGLAS AL MODELO EN VEZ DE TENERLAS EN EL CONTROLADOR. ADEMÁS SE AÑADEN MENSAJES DE ERROR PERSONALIZADOS EN ESPAÑOL Y SE INCLUYE LA REGLA `is_unique` PARA EVITAR DUPLICADOS***

### `VALIDACIÓN EN EL MODELO`

***EN VEZ DE DEFINIR LAS REGLAS EN CADA MÉTODO DEL CONTROLADOR, SE DEFINEN UNA SOLA VEZ EN EL MODELO. CUANDO USAMOS `$model->save()` O `$model->update()`, LA VALIDACIÓN SE EJECUTA AUTOMÁTICAMENTE:***

```php
// EN EL MODELO:
protected $validationRules = [
    'titulo' => 'required|min_length[3]|max_length[100]|is_unique[categorias.titulo,id,{id}]',
];

// MENSAJES PERSONALIZADOS EN ESPAÑOL:
protected $validationMessages = [
    'titulo' => [
        'required'   => 'EL TÍTULO DE LA CATEGORÍA ES OBLIGATORIO.',
        'is_unique'  => 'YA EXISTE UNA CATEGORÍA CON ESE TÍTULO.',
    ],
];
```

### `VALIDACIÓN EN EL CONTROLADOR (AHORA MÁS LIMPIO)`

```php
// ANTES (SECCIÓN 3): REGLAS EN EL CONTROLADOR
$reglas = ['titulo' => 'required|min_length[3]|max_length[150]'];
if (!$this->validate($reglas)) { ... }

// AHORA (SECCIÓN 9): EL MODELO VALIDA AUTOMÁTICAMENTE
if (!$this->peliculaModel->save($datos)) {
    return redirect()->back()->withInput()->with('errors', $this->peliculaModel->errors());
}
```

### `REGLAS DE VALIDACIÓN DISPONIBLES`

| REGLA | QUÉ HACE |
|---|---|
| ***`required`*** | ***EL CAMPO ES OBLIGATORIO, NO PUEDE ESTAR VACÍO*** |
| ***`min_length[3]`*** | ***EL CAMPO DEBE TENER AL MENOS 3 CARACTERES*** |
| ***`max_length[150]`*** | ***EL CAMPO NO PUEDE SUPERAR LOS 150 CARACTERES*** |
| ***`permit_empty`*** | ***EL CAMPO ES OPCIONAL (PUEDE ESTAR VACÍO)*** |
| ***`is_unique[tabla.campo,id,{id}]`*** | ***EL VALOR DEBE SER ÚNICO EN LA TABLA (EXCLUYE SU PROPIO ID AL EDITAR)*** |
| ***`valid_email`*** | ***EL CAMPO DEBE TENER FORMATO DE EMAIL VÁLIDO*** |
| ***`matches[campo]`*** | ***EL CAMPO DEBE COINCIDIR CON OTRO CAMPO (CONFIRMAR CONTRASEÑA)*** |

---

## `SECCIÓN 10: FILTROS DE SEGURIDAD 🛡️`

> [!NOTE]
> ***LOS FILTROS SON COMO PORTEROS DE DISCOTECA. SE EJECUTAN ANTES (O DESPUÉS) DE QUE UNA PETICIÓN LLEGUE AL CONTROLADOR. PERMITEN VERIFICAR CONDICIONES COMO "¿ESTÁ LOGUEADO?" O "¿ES ADMIN?" SIN REPETIR CÓDIGO EN CADA CONTROLADOR***

### `TIPOS DE FILTROS`

| TIPO | CUÁNDO SE EJECUTA | EJEMPLO |
|---|---|---|
| ***`before`*** | ***ANTES DE LLEGAR AL CONTROLADOR*** | ***VERIFICAR SI ESTÁ LOGUEADO*** |
| ***`after`*** | ***DESPUÉS DE QUE EL CONTROLADOR RESPONDA*** | ***AÑADIR CABECERAS DE SEGURIDAD*** |
| ***`required`*** | ***SIEMPRE, INCLUSO EN RUTAS QUE NO EXISTEN*** | ***FORZAR HTTPS, TOOLBAR*** |
| ***`globals`*** | ***EN TODAS LAS PETICIONES*** | ***CSRF, HONEYPOT*** |
| ***`filters`*** | ***EN RUTAS ESPECÍFICAS POR PATRÓN*** | ***AUTH SOLO EN /peliculas/**** |

### `AUTHFILTER: FILTRO DE AUTENTICACIÓN`

```php
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // SI NO HAY SESIÓN ACTIVA, REDIRIGIR AL LOGIN
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('/auth/login'));
        }
    }
}
```

### `ADMINFILTER: FILTRO DE ADMINISTRADOR`

```php
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // SI EL ROL NO ES 'admin', REDIRIGIR CON ERROR
        if (session()->get('usuario_rol') !== 'admin') {
            return redirect()->to(base_url('/peliculas'));
        }
    }
}
```

### `REGISTRO DE FILTROS EN Config/Filters.php`

```php
// ALIASES: NOMBRES CORTOS PARA REFERENCIAR LOS FILTROS
public array $aliases = [
    'auth'  => AuthFilter::class,     // VERIFICAR SI ESTÁ LOGUEADO
    'admin' => AdminFilter::class,    // VERIFICAR SI ES ADMIN
];

// FILTROS POR PATRÓN DE URI: PROTEGER RUTAS ESPECÍFICAS
public array $filters = [
    'auth' => ['before' => [
        'peliculas', 'peliculas/*',     // PROTEGER CRUD PELÍCULAS
        'categorias', 'categorias/*',   // PROTEGER CRUD CATEGORÍAS
    ]],
];
```

---

## `SECCIÓN 11: AUTENTICACIÓN Y USUARIOS 🔐`

> [!NOTE]
> ***EN ESTA SECCIÓN SE CREA TODO EL SISTEMA DE AUTENTICACIÓN: TABLA DE USUARIOS CON CONTRASEÑAS HASHEADAS (BCRYPT), FORMULARIOS DE LOGIN Y REGISTRO, CONTROL DE SESIONES Y DISTINTOS ROLES (ADMIN/USUARIO)***

### `MIGRACIÓN DE LA TABLA USUARIOS`

```bash
# CREAR EL ARCHIVO DE MIGRACIÓN
> ddev exec php spark make:migration Usuarios

# EJECUTAR LA MIGRACIÓN
> ddev exec php spark migrate
```

***COLUMNAS DE LA TABLA USUARIOS:***

| COLUMNA | TIPO | DESCRIPCIÓN |
|---|---|---|
| ***`id`*** | ***INT AUTO_INCREMENT*** | ***CLAVE PRIMARIA*** |
| ***`nombre`*** | ***VARCHAR(100)*** | ***NOMBRE COMPLETO DEL USUARIO*** |
| ***`email`*** | ***VARCHAR(100) UNIQUE*** | ***EMAIL ÚNICO (NO SE PUEDE REPETIR)*** |
| ***`password`*** | ***VARCHAR(255)*** | ***CONTRASEÑA HASHEADA CON BCRYPT*** |
| ***`rol`*** | ***VARCHAR(20) DEFAULT 'usuario'*** | ***ROL: 'admin' O 'usuario'*** |
| ***`created_at`*** | ***DATETIME*** | ***FECHA DE CREACIÓN*** |
| ***`updated_at`*** | ***DATETIME*** | ***FECHA DE ACTUALIZACIÓN*** |

### `MODELO DE USUARIOS (CON HASH AUTOMÁTICO)`

***EL MODELO USA CALLBACKS (beforeInsert Y beforeUpdate) PARA HASHEAR LA CONTRASEÑA AUTOMÁTICAMENTE ANTES DE GUARDARLA EN LA BD:***

```php
// CALLBACKS QUE SE EJECUTAN ANTES DE INSERTAR/ACTUALIZAR
protected $beforeInsert = ['hashPassword'];
protected $beforeUpdate = ['hashPassword'];

// MÉTODO QUE HASHEA LA CONTRASEÑA CON BCRYPT
protected function hashPassword(array $data)
{
    if (isset($data['data']['password'])) {
        // password_hash() CON PASSWORD_DEFAULT USA BCRYPT
        // GENERA UN HASH SEGURO CON SAL ALEATORIA INCLUIDA
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    }
    return $data;
}
```

### `CONTRASEÑAS CON HASH BCRYPT`

> [!IMPORTANT]
> ***NUNCA SE GUARDA UNA CONTRASEÑA EN TEXTO PLANO. SE USA `password_hash()` PARA GENERAR UN HASH SEGURO Y `password_verify()` PARA VERIFICARLA AL HACER LOGIN***

```php
// AL REGISTRAR: SE HASHEA AUTOMÁTICAMENTE (CALLBACK DEL MODELO)
// LA CONTRASEÑA '123456' SE CONVIERTE EN ALGO COMO:
// $2y$10$Xj7kH2QFMN... (60 CARACTERES)

// AL HACER LOGIN: SE COMPARA CON password_verify()
if (password_verify($passwordIngresada, $hashGuardado)) {
    // CONTRASEÑA CORRECTA -> INICIAR SESIÓN
}
```

### `CONTROLADOR AUTH (LOGIN, REGISTRO, LOGOUT)`

| MÉTODO | RUTA | QUÉ HACE |
|---|---|---|
| ***`login()`*** | ***GET /auth/login*** | ***MUESTRA EL FORMULARIO DE LOGIN*** |
| ***`loginPost()`*** | ***POST /auth/loginPost*** | ***VERIFICA CREDENCIALES Y CREA LA SESIÓN*** |
| ***`registro()`*** | ***GET /auth/registro*** | ***MUESTRA EL FORMULARIO DE REGISTRO*** |
| ***`registroPost()`*** | ***POST /auth/registroPost*** | ***VALIDA DATOS, CREA EL USUARIO Y REDIRIGE AL LOGIN*** |
| ***`logout()`*** | ***GET /auth/logout*** | ***DESTRUYE LA SESIÓN Y REDIRIGE AL LOGIN*** |

### `DATOS DE LA SESIÓN`

***AL HACER LOGIN EXITOSO, SE GUARDAN ESTOS DATOS EN LA SESIÓN:***

```php
session()->set([
    'usuario_id'     => 1,              // ID DEL USUARIO
    'usuario_nombre' => 'Admin',        // NOMBRE DEL USUARIO
    'usuario_email'  => 'admin@admin.com', // EMAIL DEL USUARIO
    'usuario_rol'    => 'admin',        // ROL (admin O usuario)
    'logueado'       => true,           // MARCA DE AUTENTICACIÓN
]);
```

### `SEEDER DE USUARIOS`

```bash
# EJECUTAR EL SEEDER (INSERTA 3 USUARIOS DE PRUEBA)
> ddev exec php spark db:seed UsuarioSeeder
```

***USUARIOS DE PRUEBA:***

| NOMBRE | EMAIL | CONTRASEÑA | ROL |
|---|---|---|---|
| ***Admin*** | ***admin@admin.com*** | ***123456*** | ***admin*** |
| ***Usuario Demo*** | ***usuario@usuario.com*** | ***123456*** | ***usuario*** |
| ***María García*** | ***maria@test.com*** | ***123456*** | ***usuario*** |

### `NAVBAR DINÁMICA`

***LA BARRA DE NAVEGACIÓN CAMBIA SEGÚN EL ESTADO DE LA SESIÓN:***

- ***SIN LOGUEARSE → SE MUESTRAN BOTONES "ENTRAR" Y "REGISTRARSE"***
- ***LOGUEADO → SE MUESTRA EL NOMBRE DEL USUARIO, SU ROL (BADGE VERDE=ADMIN, AZUL=USUARIO) Y BOTÓN "SALIR"***
- ***LOGUEADO → SE MUESTRAN LOS ENLACES A PELÍCULAS Y CATEGORÍAS EN EL MENÚ***

---

## `SECCIÓN 12: API REST CRUD 🔌`

> [!NOTE]
> ***EN ESTA SECCIÓN SE CREA UNA API REST COMPLETA PARA CATEGORÍAS Y PELÍCULAS. LAS RUTAS DEVUELVEN RESPUESTAS EN FORMATO JSON Y SE PUEDEN CONSUMIR DESDE POSTMAN, APLICACIONES MÓVILES U OTROS FRONTENDS***

### `¿QUÉ ES UNA API REST?`

***UNA API REST ES UNA INTERFAZ QUE PERMITE A OTRAS APLICACIONES COMUNICARSE CON NUESTRO SERVIDOR. EN VEZ DE DEVOLVER PÁGINAS HTML, DEVUELVE DATOS EN FORMATO JSON:***

```json
{
    "status": 200,
    "mensaje": "LISTADO DE CATEGORÍAS",
    "datos": [
        {"id": 1, "titulo": "Acción", "created_at": "2026-03-12 12:00:00"},
        {"id": 2, "titulo": "Comedia", "created_at": "2026-03-12 12:00:00"}
    ]
}
```

### `RESOURCECONTROLLER`

***LOS CONTROLADORES API EXTIENDEN DE `ResourceController` EN VEZ DE `BaseController`. ESTO NOS DA MÉTODOS HELPER PARA RESPUESTAS JSON:***

| MÉTODO | CÓDIGO HTTP | USO |
|---|---|---|
| ***`respond()`*** | ***200*** | ***RESPUESTA EXITOSA*** |
| ***`respondCreated()`*** | ***201*** | ***RECURSO CREADO*** |
| ***`respondDeleted()`*** | ***200*** | ***RECURSO ELIMINADO*** |
| ***`failNotFound()`*** | ***404*** | ***RECURSO NO ENCONTRADO*** |
| ***`failValidationErrors()`*** | ***400*** | ***ERRORES DE VALIDACIÓN*** |

### `ENDPOINTS API CATEGORÍAS`

| MÉTODO HTTP | ENDPOINT | ACCIÓN |
|---|---|---|
| ***GET*** | ***`/api/categorias`*** | ***OBTENER TODAS LAS CATEGORÍAS*** |
| ***GET*** | ***`/api/categorias/5`*** | ***OBTENER UNA CATEGORÍA POR ID*** |
| ***POST*** | ***`/api/categorias`*** | ***CREAR UNA NUEVA CATEGORÍA*** |
| ***PUT*** | ***`/api/categorias/5`*** | ***ACTUALIZAR UNA CATEGORÍA*** |
| ***DELETE*** | ***`/api/categorias/5`*** | ***ELIMINAR UNA CATEGORÍA*** |

### `ENDPOINTS API PELÍCULAS`

| MÉTODO HTTP | ENDPOINT | ACCIÓN |
|---|---|---|
| ***GET*** | ***`/api/peliculas`*** | ***OBTENER TODAS LAS PELÍCULAS*** |
| ***GET*** | ***`/api/peliculas/5`*** | ***OBTENER UNA PELÍCULA POR ID*** |
| ***POST*** | ***`/api/peliculas`*** | ***CREAR UNA NUEVA PELÍCULA*** |
| ***PUT*** | ***`/api/peliculas/5`*** | ***ACTUALIZAR UNA PELÍCULA*** |
| ***DELETE*** | ***`/api/peliculas/5`*** | ***ELIMINAR UNA PELÍCULA*** |

### `EJEMPLOS CON CURL/POSTMAN`

```bash
# OBTENER TODAS LAS CATEGORÍAS
> curl https://udemy.ddev.site/api/categorias

# OBTENER UNA CATEGORÍA POR ID
> curl https://udemy.ddev.site/api/categorias/1

# CREAR UNA NUEVA CATEGORÍA (POST CON JSON)
> curl -X POST https://udemy.ddev.site/api/categorias \
    -H "Content-Type: application/json" \
    -d '{"titulo": "Musical"}'

# ACTUALIZAR UNA CATEGORÍA (PUT CON JSON)
> curl -X PUT https://udemy.ddev.site/api/categorias/1 \
    -H "Content-Type: application/json" \
    -d '{"titulo": "Acción y Aventura"}'

# ELIMINAR UNA CATEGORÍA
> curl -X DELETE https://udemy.ddev.site/api/categorias/1

# OBTENER TODAS LAS PELÍCULAS
> curl https://udemy.ddev.site/api/peliculas

# CREAR UNA NUEVA PELÍCULA (POST CON JSON)
> curl -X POST https://udemy.ddev.site/api/peliculas \
    -H "Content-Type: application/json" \
    -d '{"titulo": "Inception", "descripcion": "Un ladrón de sueños"}'
```

---

## `LAYOUT PRINCIPAL CON BOOTSTRAP 5 🎨`

> [!NOTE]
> ***EL LAYOUT (`app/Views/layout/main.php`) ES LA PLANTILLA MAESTRA QUE HEREDAN TODAS LAS VISTAS. CONTIENE LA ESTRUCTURA HTML COMPLETA, LA NAVBAR DINÁMICA Y EL SISTEMA DE MENSAJES FLASH***

- ***BOOTSTRAP 5.3.3 → CARGADO DESDE CDN PARA LOS ESTILOS (TABLAS, BOTONES, ALERTAS, FORMULARIOS, NAVBAR, CARDS)***
- ***FONT AWESOME 6.5.1 → CARGADO DESDE CDN PARA LOS ÍCONOS (USUARIO, FILM, TAGS, LOGIN, LOGOUT)***
- ***NAVBAR DINÁMICA → CAMBIA SEGÚN SI EL USUARIO ESTÁ LOGUEADO O NO***
- ***MENSAJES FLASH → ALERTAS VERDES (ÉXITO) Y ROJAS (ERROR) DESCARTABLES***
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
> ddev exec php spark crud:generar Producto # GENERAR CRUD COMPLETO (SECCIÓN 25)
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
> ddev exec php spark make:filter NombreFiltro # CREAR FILTRO
```

### `WSL (DESDE POWERSHELL)`

```powershell
> wsl --shutdown           # APAGAR WSL COMPLETAMENTE
> wsl --list --verbose     # VER ESTADO DE LAS DISTRIBUCIONES
> wsl -d DDEV              # ENTRAR A LA DISTRIBUCIÓN DDEV
```

---

## `SECCIÓN 14: RELACIÓN UNO A MUCHOS (1:N) 🔗`

> [!NOTE]
> ***EN ESTA SECCIÓN SE CREA LA RELACIÓN ENTRE PELÍCULAS Y CATEGORÍAS. UNA CATEGORÍA PUEDE TENER MUCHAS PELÍCULAS, PERO CADA PELÍCULA SOLO PERTENECE A UNA CATEGORÍA. ESTO SE IMPLEMENTA AÑADIENDO UNA CLAVE FORÁNEA `categoria_id` A LA TABLA PELICULAS***

### `MIGRACIÓN: AÑADIR categoria_id A PELICULAS`

```bash
# CREAR LA MIGRACIÓN QUE AÑADE LA COLUMNA
> ddev exec php spark make:migration AddCategoriaIdToPeliculas

# EJECUTAR LA MIGRACIÓN
> ddev exec php spark migrate
```

***LA MIGRACIÓN AÑADE:***

```php
// COLUMNA categoria_id: REFERENCIA A LA TABLA CATEGORIAS
'categoria_id' => [
    'type'       => 'INT',
    'constraint' => 11,
    'unsigned'   => true,
    'null'       => true,        // PUEDE SER NULO (PELÍCULA SIN CATEGORÍA)
    'after'      => 'descripcion', // SE AÑADE DESPUÉS DE descripcion
],
```

### `JOIN EN EL MODELO`

***PARA TRAER EL NOMBRE DE LA CATEGORÍA JUNTO CON CADA PELÍCULA, USAMOS UN LEFT JOIN:***

```php
public function getPeliculasConCategoria()
{
    return $this->select('peliculas.*, categorias.titulo AS categoria_nombre')
                 ->join('categorias', 'categorias.id = peliculas.categoria_id', 'left')
                 ->orderBy('peliculas.id', 'DESC')
                 ->findAll();
}
```

### `SELECT EN EL FORMULARIO`

***EN LAS VISTAS DE CREAR/EDITAR PELÍCULA SE AÑADE UN SELECT DESPLEGABLE CON TODAS LAS CATEGORÍAS:***

```php
<select class="form-select" name="categoria_id">
    <option value="">-- Seleccionar categoría --</option>
    <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria['id'] ?>"><?= esc($categoria['titulo']) ?></option>
    <?php endforeach; ?>
</select>
```

---

## `SECCIÓN 15: RELACIÓN MUCHOS A MUCHOS (N:M) - ETIQUETAS 🏷️`

> [!NOTE]
> ***EN ESTA SECCIÓN SE CREAN LAS ETIQUETAS (TAGS) Y LA RELACIÓN MUCHOS A MUCHOS CON PELÍCULAS. UNA PELÍCULA PUEDE TENER MUCHAS ETIQUETAS Y UNA ETIQUETA PUEDE ESTAR EN MUCHAS PELÍCULAS. ESTO REQUIERE UNA TABLA PIVOTE INTERMEDIA***

### `DIAGRAMA DE LA RELACIÓN N:M`

```
PELÍCULAS ──────── pelicula_etiqueta ──────── ETIQUETAS
(id, titulo)       (pelicula_id, etiqueta_id)  (id, nombre)

Ej: "Matrix"  ─── pelicula_id=1, etiqueta_id=1 ─── "Clásico"
    "Matrix"  ─── pelicula_id=1, etiqueta_id=3 ─── "Taquillera"
    "Coco"    ─── pelicula_id=5, etiqueta_id=6 ─── "Infantil"
```

### `MIGRACIONES`

```bash
# CREAR LA TABLA ETIQUETAS
> ddev exec php spark make:migration Etiquetas

# CREAR LA TABLA PIVOTE pelicula_etiqueta
> ddev exec php spark make:migration PeliculaEtiqueta

# EJECUTAR LAS MIGRACIONES
> ddev exec php spark migrate
```

### `MODELO PeliculaEtiquetaModel (TABLA PIVOTE)`

***EL MODELO DE LA TABLA PIVOTE TIENE DOS MÉTODOS CLAVE:***

```php
// OBTENER LAS ETIQUETAS ASIGNADAS A UNA PELÍCULA (DEVUELVE ARRAY DE IDs)
public function getEtiquetasDePelicula($peliculaId)
{
    return $this->where('pelicula_id', $peliculaId)
                 ->findColumn('etiqueta_id') ?? [];
}

// SINCRONIZAR: BORRAR LAS ANTERIORES Y ASIGNAR LAS NUEVAS
public function sincronizar($peliculaId, array $etiquetaIds)
{
    $this->where('pelicula_id', $peliculaId)->delete();
    foreach ($etiquetaIds as $etiquetaId) {
        $this->insert(['pelicula_id' => $peliculaId, 'etiqueta_id' => $etiquetaId]);
    }
}
```

### `CHECKBOXES EN EL FORMULARIO`

***EN LAS VISTAS DE CREAR/EDITAR PELÍCULA SE AÑADEN CHECKBOXES PARA SELECCIONAR ETIQUETAS:***

```php
<?php foreach ($etiquetas as $etiqueta): ?>
    <input type="checkbox" name="etiquetas[]" value="<?= $etiqueta['id'] ?>"
        <?= in_array($etiqueta['id'], $etiquetasSeleccionadas ?? []) ? 'checked' : '' ?>>
    <?= esc($etiqueta['nombre']) ?>
<?php endforeach; ?>
```

### `CRUD DE ETIQUETAS`

***SE CREA UN CRUD COMPLETO PARA GESTIONAR ETIQUETAS (CREAR, EDITAR, ELIMINAR) CON SU PROPIO CONTROLADOR, MODELO Y VISTAS***

### `SEEDER DE ETIQUETAS`

```bash
# EJECUTAR EL SEEDER (INSERTA 8 ETIQUETAS DE PRUEBA)
> ddev exec php spark db:seed EtiquetaSeeder
```

***ETIQUETAS INSERTADAS: Clásico, Premiada, Taquillera, Independiente, Recomendada, Infantil, Estreno, Saga***

---

## `SECCIÓN 16: CARGA DE ARCHIVOS (IMÁGENES) 📁`

> [!NOTE]
> ***EN ESTA SECCIÓN SE IMPLEMENTA LA SUBIDA DE IMÁGENES PARA LAS PELÍCULAS. EL USUARIO PUEDE SUBIR UNA IMAGEN (JPG, PNG, GIF) QUE SE GUARDA EN EL SERVIDOR Y SE MUESTRA EN EL LISTADO Y EN EL FORMULARIO DE EDICIÓN***

### `MIGRACIÓN: AÑADIR CAMPO imagen`

```bash
# CREAR LA MIGRACIÓN QUE AÑADE LA COLUMNA imagen A PELICULAS
> ddev exec php spark make:migration AddImagenToPeliculas

# EJECUTAR LA MIGRACIÓN
> ddev exec php spark migrate
```

### `CÓMO FUNCIONA LA CARGA DE ARCHIVOS`

```php
// 1. EL FORMULARIO DEBE TENER enctype="multipart/form-data"
<form method="POST" enctype="multipart/form-data">

// 2. CAMPO INPUT DE TIPO FILE
<input type="file" name="imagen" accept="image/*">

// 3. EN EL CONTROLADOR, OBTENEMOS EL ARCHIVO
$imagen = $this->request->getFile('imagen');

// 4. VALIDAMOS QUE SEA UNA IMAGEN VÁLIDA Y NO SUPERE 2MB
$reglas = ['imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]'];

// 5. GENERAMOS UN NOMBRE ALEATORIO PARA EVITAR COLISIONES
$nuevoNombre = $imagen->getRandomName();

// 6. MOVEMOS LA IMAGEN A public/uploads/peliculas/
$imagen->move(FCPATH . 'uploads/peliculas', $nuevoNombre);

// 7. GUARDAMOS EL NOMBRE EN LA BD
$datos['imagen'] = $nuevoNombre;
```

### `VALIDACIONES DE IMAGEN`

| REGLA | QUÉ HACE |
|---|---|
| ***`uploaded[imagen]`*** | ***VERIFICA QUE SE HAYA SUBIDO UN ARCHIVO*** |
| ***`max_size[imagen,2048]`*** | ***EL ARCHIVO NO PUEDE SUPERAR 2MB (2048 KB)*** |
| ***`is_image[imagen]`*** | ***VERIFICA QUE SEA UNA IMAGEN REAL*** |
| ***`mime_in[imagen,image/jpg,image/jpeg,image/png,image/gif]`*** | ***SOLO PERMITE ESTOS FORMATOS*** |

### `ELIMINACIÓN DE IMÁGENES`

***AL EDITAR O ELIMINAR UNA PELÍCULA, LA IMAGEN ANTERIOR SE BORRA DEL SERVIDOR:***

```php
if (!empty($pelicula['imagen']) && file_exists(FCPATH . 'uploads/peliculas/' . $pelicula['imagen'])) {
    unlink(FCPATH . 'uploads/peliculas/' . $pelicula['imagen']);
}
```

### `CARPETA DE UPLOADS`

***LAS IMÁGENES SE GUARDAN EN `public/uploads/peliculas/`. ESTA CARPETA NO SE SUBE A GIT (SOLO EL `.gitkeep`)***

---

## `SECCIÓN 17: INTEGRACIÓN COMPLETA 🔄`

> [!NOTE]
> ***EN ESTA SECCIÓN SE INTEGRA TODO LO ANTERIOR: LA API REST AHORA INCLUYE LA CATEGORÍA Y LAS ETIQUETAS EN LAS RESPUESTAS JSON, LA NAVBAR MUESTRA EL ENLACE A ETIQUETAS, Y EL FILTRO AUTH PROTEGE TAMBIÉN LAS RUTAS DE ETIQUETAS***

### `API REST ACTUALIZADA`

***EL ENDPOINT GET /api/peliculas/5 AHORA DEVUELVE LA PELÍCULA CON SUS ETIQUETAS:***

```json
{
    "status": 200,
    "mensaje": "PELÍCULA ENCONTRADA",
    "datos": {
        "id": 1,
        "titulo": "Matrix",
        "descripcion": "Un hacker descubre la verdad...",
        "categoria_id": 5,
        "imagen": "abc123.jpg",
        "etiquetas": [
            {"id": 1, "nombre": "Clásico"},
            {"id": 3, "nombre": "Taquillera"}
        ]
    }
}
```

### `NAVBAR ACTUALIZADA`

***SE AÑADE EL ENLACE A ETIQUETAS EN LA BARRA DE NAVEGACIÓN (SOLO VISIBLE PARA USUARIOS LOGUEADOS):***

- ***PELÍCULAS → CRUD CON CATEGORÍA, ETIQUETAS E IMAGEN***
- ***CATEGORÍAS → CRUD INDEPENDIENTE***
- ***ETIQUETAS → CRUD INDEPENDIENTE (NUEVO)***

### `FILTRO AUTH AMPLIADO`

***EL FILTRO DE AUTENTICACIÓN AHORA PROTEGE TAMBIÉN LAS RUTAS DE ETIQUETAS:***

```php
'auth' => ['before' => [
    'peliculas', 'peliculas/*',
    'categorias', 'categorias/*',
    'etiquetas', 'etiquetas/*',     // NUEVO
]],
```

---

## `SECCIÓN 18: LISTADO PAGINADO Y FILTROS AVANZADOS 🔍`

> [!NOTE]
> ***EN ESTA SECCIÓN SE IMPLEMENTA LA PAGINACIÓN EN TODOS LOS LISTADOS (PELÍCULAS, CATEGORÍAS Y ETIQUETAS) Y SE AÑADE UN SISTEMA DE FILTROS AVANZADO PARA PELÍCULAS QUE PERMITE BUSCAR POR TEXTO, FILTRAR POR CATEGORÍA, FILTRAR POR ETIQUETA Y AGRUPAR CONDICIONES LIKE CON groupStart()/groupEnd()***

### `¿QUÉ ES LA PAGINACIÓN?`

***LA PAGINACIÓN DIVIDE LOS RESULTADOS EN PÁGINAS PARA NO CARGAR TODOS LOS REGISTROS DE GOLPE. CODEIGNITER 4 LO HACE AUTOMÁTICAMENTE CON EL MÉTODO `paginate()` DEL MODELO:***

```php
// SIN PAGINACIÓN: TRAE TODOS LOS REGISTROS (LENTO SI HAY MILES)
$peliculas = $this->peliculaModel->findAll();

// CON PAGINACIÓN: TRAE SOLO 5 REGISTROS POR PÁGINA (RÁPIDO SIEMPRE)
$peliculas = $this->peliculaModel->paginate(5);
$pager = $this->peliculaModel->pager;  // OBJETO PARA GENERAR ENLACES DE PÁGINA
```

### `MÉTODO getPeliculasFiltradas() EN EL MODELO`

***ARCHIVO: `app/Models/PeliculaModel.php`***

***ESTE MÉTODO CONSTRUYE UNA CONSULTA SQL DINÁMICA SEGÚN LOS FILTROS RECIBIDOS:***

```php
public function getPeliculasFiltradas($filtros = [], $porPagina = 5)
{
    // 1. SELECT CON JOIN A CATEGORÍAS (IGUAL QUE getPeliculasConCategoria)
    $builder = $this->select('peliculas.*, categorias.titulo AS categoria_nombre')
                    ->join('categorias', 'categorias.id = peliculas.categoria_id', 'left');

    // 2. FILTRO BÚSQUEDA: LIKE AGRUPADO CON groupStart()/groupEnd()
    if (!empty($filtros['busqueda'])) {
        $builder->groupStart()
                    ->like('peliculas.titulo', $filtros['busqueda'], 'both')
                    ->orLike('peliculas.descripcion', $filtros['busqueda'], 'both')
                ->groupEnd();
    }

    // 3. FILTRO POR CATEGORÍA: WHERE exacto
    if (!empty($filtros['categoria_id'])) {
        $builder->where('peliculas.categoria_id', $filtros['categoria_id']);
    }

    // 4. FILTRO POR ETIQUETA: JOIN con tabla pivote
    if (!empty($filtros['etiqueta_id'])) {
        $builder->join('pelicula_etiqueta', 'pelicula_etiqueta.pelicula_id = peliculas.id', 'inner')
                ->where('pelicula_etiqueta.etiqueta_id', $filtros['etiqueta_id']);
    }

    // 5. PAGINAR RESULTADOS
    return $builder->orderBy('peliculas.id', 'DESC')->paginate($porPagina);
}
```

### `¿QUÉ ES EL LIKE AGRUPADO (groupStart/groupEnd)?`

***CUANDO COMBINAMOS LIKE CON OTROS FILTROS, DEBEMOS AGRUPAR LOS LIKE DENTRO DE PARÉNTESIS PARA QUE LA LÓGICA SQL SEA CORRECTA:***

```sql
-- SIN AGRUPAR (INCORRECTO): EL OR AFECTA A TODO
WHERE titulo LIKE '%matrix%' OR descripcion LIKE '%matrix%' AND categoria_id = 5
-- ESTO SE INTERPRETA COMO: titulo LIKE '%matrix%' OR (descripcion LIKE '%matrix%' AND categoria_id = 5)

-- CON AGRUPAR (CORRECTO): EL OR SOLO AFECTA AL GRUPO
WHERE (titulo LIKE '%matrix%' OR descripcion LIKE '%matrix%') AND categoria_id = 5
-- ESTO SE INTERPRETA COMO: (coincide en titulo O descripcion) Y además la categoría es 5
```

***EN CODEIGNITER 4:***

```php
// groupStart() = ABRE PARÉNTESIS → (
// groupEnd() = CIERRA PARÉNTESIS → )
$builder->groupStart()
            ->like('peliculas.titulo', $filtros['busqueda'], 'both')
            ->orLike('peliculas.descripcion', $filtros['busqueda'], 'both')
        ->groupEnd();
```

### `CONTROLADOR PELICULA::INDEX() CON FILTROS`

***ARCHIVO: `app/Controllers/Pelicula.php`***

```php
public function index()
{
    // RECOGEMOS LOS FILTROS DEL QUERY STRING (?busqueda=matrix&categoria_id=5)
    $filtros = [
        'busqueda'     => $this->request->getGet('busqueda'),
        'categoria_id' => $this->request->getGet('categoria_id'),
        'etiqueta_id'  => $this->request->getGet('etiqueta_id'),
    ];

    // OBTENEMOS PELÍCULAS FILTRADAS Y PAGINADAS (5 POR PÁGINA)
    $datos['peliculas'] = $this->peliculaModel->getPeliculasFiltradas($filtros, 5);

    // OBJETO PAGER PARA LOS ENLACES DE PAGINACIÓN
    $datos['pager'] = $this->peliculaModel->pager;

    // CATEGORÍAS Y ETIQUETAS PARA LOS SELECTS DE FILTRO
    $datos['categorias'] = $this->categoriaModel->orderBy('titulo', 'ASC')->findAll();
    $datos['etiquetas'] = $this->etiquetaModel->orderBy('nombre', 'ASC')->findAll();

    // PASAMOS LOS FILTROS PARA MANTENERLOS EN EL FORMULARIO
    $datos['filtros'] = $filtros;

    return view('peliculas/index', $datos);
}
```

### `VISTA DE PELÍCULAS CON BARRA DE FILTROS`

***ARCHIVO: `app/Views/peliculas/index.php`***

***EL FORMULARIO DE FILTROS USA `method="GET"` PARA QUE LOS FILTROS APAREZCAN EN LA URL Y SE PUEDAN COMPARTIR:***

| CAMPO | TIPO | QUÉ FILTRA |
|---|---|---|
| ***`busqueda`*** | ***INPUT TEXT*** | ***BÚSQUEDA POR TÍTULO Y DESCRIPCIÓN (LIKE %texto%)*** |
| ***`categoria_id`*** | ***SELECT*** | ***FILTRAR POR CATEGORÍA (WHERE categoria_id = X)*** |
| ***`etiqueta_id`*** | ***SELECT*** | ***FILTRAR POR ETIQUETA (JOIN CON TABLA PIVOTE)*** |
| ***BOTÓN FILTRAR*** | ***SUBMIT*** | ***APLICA LOS FILTROS Y MUESTRA LOS RESULTADOS*** |
| ***BOTÓN LIMPIAR*** | ***ENLACE*** | ***VUELVE A LA URL SIN PARÁMETROS (QUITA TODOS LOS FILTROS)*** |

### `PAGINACIÓN EN LA VISTA`

***SE AÑADEN LOS ENLACES DE PAGINACIÓN DEBAJO DE LA TABLA:***

```php
<!-- GENERA LOS BOTONES DE PAGINACIÓN (1, 2, 3, SIGUIENTE, ANTERIOR) -->
<?= $pager->links('default', 'default_full') ?>
```

***`default_full` USA LA PLANTILLA DE BOOTSTRAP QUE INCLUYE CODEIGNITER, GENERANDO BOTONES ESTILIZADOS***

### `PAGINACIÓN Y BÚSQUEDA EN CATEGORÍAS Y ETIQUETAS`

***LOS CONTROLADORES DE CATEGORÍAS (`app/Controllers/Categoria.php`) Y ETIQUETAS (`app/Controllers/Etiqueta.php`) TAMBIÉN TIENEN PAGINACIÓN Y BÚSQUEDA:***

```php
// EJEMPLO: CONTROLADOR DE CATEGORÍAS
public function index()
{
    $busqueda = $this->request->getGet('busqueda');
    $builder = $this->categoriaModel->orderBy('id', 'DESC');

    if (!empty($busqueda)) {
        $builder->like('titulo', $busqueda, 'both');
    }

    $datos['categorias'] = $builder->paginate(10);  // 10 POR PÁGINA
    $datos['pager'] = $this->categoriaModel->pager;
    $datos['busqueda'] = $busqueda;

    return view('categorias/index', $datos);
}
```

### `RESULTADOS POR PÁGINA`

| LISTADO | RESULTADOS POR PÁGINA | FILTROS DISPONIBLES |
|---|---|---|
| ***PELÍCULAS*** | ***5*** | ***BÚSQUEDA TEXTO + CATEGORÍA + ETIQUETA*** |
| ***CATEGORÍAS*** | ***10*** | ***BÚSQUEDA POR TÍTULO*** |
| ***ETIQUETAS*** | ***10*** | ***BÚSQUEDA POR NOMBRE*** |

### `EJEMPLO DE URL CON FILTROS`

```
# BUSCAR "matrix" EN PELÍCULAS
https://udemy.ddev.site/peliculas?busqueda=matrix

# FILTRAR POR CATEGORÍA ID 5 (CIENCIA FICCIÓN)
https://udemy.ddev.site/peliculas?categoria_id=5

# FILTRAR POR ETIQUETA ID 1 (CLÁSICO)
https://udemy.ddev.site/peliculas?etiqueta_id=1

# COMBINAR BÚSQUEDA + CATEGORÍA + ETIQUETA
https://udemy.ddev.site/peliculas?busqueda=matrix&categoria_id=5&etiqueta_id=1

# PÁGINA 2 DE RESULTADOS CON FILTROS
https://udemy.ddev.site/peliculas?busqueda=matrix&page=2

# BUSCAR "acción" EN CATEGORÍAS
https://udemy.ddev.site/categorias?busqueda=accion

# BUSCAR "clásico" EN ETIQUETAS
https://udemy.ddev.site/etiquetas?busqueda=clasico
```

---


## `SECCIÓN 19: REST API - RELACIONES Y MÉTODOS AVANZADOS 🔌`

> [!NOTE]
> ***EN ESTA SECCIÓN SE AMPLÍA LA API REST DE LA SECCIÓN 12 CON FUNCIONALIDADES AVANZADAS: PAGINACIÓN DE RESULTADOS, FILTROS/BÚSQUEDA DESDE LA API, SUBIDA DE IMÁGENES POR API, ASIGNACIÓN DE ETIQUETAS POR API Y PROTECCIÓN CON FILTRO DE TOKENS. LA API PASA DE SER BÁSICA A ESTAR LISTA PARA SER CONSUMIDA POR UN FRONTEND REAL (VUE, REACT, MÓVIL, ETC.)***

### `ARCHIVOS QUE ENTRAN EN JUEGO`

| ARCHIVO | QUÉ SE HACE |
|---|---|
| ***`app/Controllers/ApiPelicula.php`*** | ***SE MODIFICA: SE AÑADEN LOS MÉTODOS `upload()` Y `asignarEtiquetas()`. EL MÉTODO `index()` AHORA USA `getPeliculasFiltradas()` CON PAGINACIÓN Y DEVUELVE INFORMACIÓN DE PAGINACIÓN EN LA RESPUESTA JSON*** |
| ***`app/Filters/ApiAuthFilter.php`*** | ***SE CREA: NUEVO FILTRO QUE VERIFICA EL HEADER `Authorization: Bearer <token>` EN LAS PETICIONES API. SI NO HAY TOKEN, DEVUELVE ERROR 401 EN JSON (NO REDIRIGE AL LOGIN COMO EL AUTHFILTER)*** |
| ***`app/Config/Routes.php`*** | ***SE MODIFICA: SE AÑADEN LAS RUTAS `POST /api/peliculas/upload/(:num)` Y `POST /api/peliculas/(:num)/etiquetas`*** |
| ***`app/Config/Filters.php`*** | ***SE MODIFICA: SE REGISTRA EL ALIAS `apiauth` PARA EL NUEVO FILTRO `ApiAuthFilter`*** |
| ***`app/Models/PeliculaModel.php`*** | ***YA EXISTÍA: SE REUTILIZA EL MÉTODO `getPeliculasFiltradas()` DE LA SECCIÓN 18 PARA LA API*** |
| ***`app/Models/PeliculaEtiquetaModel.php`*** | ***YA EXISTÍA: SE REUTILIZA EL MÉTODO `sincronizar()` PARA EL ENDPOINT DE ETIQUETAS*** |

### `NUEVOS ENDPOINTS DE LA API`

| MÉTODO HTTP | ENDPOINT | ACCIÓN |
|---|---|---|
| ***GET*** | ***`/api/peliculas?busqueda=matrix&page=2`*** | ***LISTADO CON PAGINACIÓN Y FILTROS*** |
| ***GET*** | ***`/api/peliculas?categoria_id=5&per_page=20`*** | ***FILTRAR POR CATEGORÍA, 20 POR PÁGINA*** |
| ***POST*** | ***`/api/peliculas/upload/5`*** | ***SUBIR IMAGEN A UNA PELÍCULA (FORM-DATA)*** |
| ***POST*** | ***`/api/peliculas/5/etiquetas`*** | ***ASIGNAR ETIQUETAS `{"etiquetas": [1,3,7]}`*** |

### `PAGINACIÓN EN LA API`

***EL ENDPOINT `GET /api/peliculas` AHORA DEVUELVE INFORMACIÓN DE PAGINACIÓN JUNTO CON LOS DATOS:***

```json
{
    "status": 200,
    "mensaje": "LISTADO DE PELÍCULAS",
    "datos": [...],
    "paginacion": {
        "pagina_actual": 1,
        "por_pagina": 10,
        "total_registros": 47,
        "total_paginas": 5
    }
}
```

***EL CLIENTE PUEDE CONTROLAR LA PAGINACIÓN CON LOS PARÁMETROS `page` Y `per_page`:***

```bash
# PÁGINA 1, 10 POR PÁGINA (POR DEFECTO)
> curl https://udemy.ddev.site/api/peliculas

# PÁGINA 2, 20 POR PÁGINA
> curl "https://udemy.ddev.site/api/peliculas?page=2&per_page=20"

# BUSCAR "matrix" EN PÁGINA 1
> curl "https://udemy.ddev.site/api/peliculas?busqueda=matrix"
```

### `SUBIDA DE IMÁGENES POR API`

```bash
# SUBIR IMAGEN A LA PELÍCULA CON ID 5
> curl -X POST https://udemy.ddev.site/api/peliculas/upload/5 \
    -F "imagen=@/ruta/a/mi-foto.jpg"
```

### `ASIGNAR ETIQUETAS POR API`

```bash
# ASIGNAR LAS ETIQUETAS 1, 3 Y 7 A LA PELÍCULA CON ID 5
> curl -X POST https://udemy.ddev.site/api/peliculas/5/etiquetas \
    -H "Content-Type: application/json" \
    -d '{"etiquetas": [1, 3, 7]}'
```

### `FILTRO ApiAuthFilter (PROTECCIÓN DE LA API)`

***SE CREA UN FILTRO ESPECÍFICO PARA LA API (`app/Filters/ApiAuthFilter.php`) QUE VERIFICA EL TOKEN EN EL HEADER `Authorization`. A DIFERENCIA DEL AUTHFILTER QUE REDIRIGE AL LOGIN (HTML), ESTE DEVUELVE ERROR 401 EN JSON:***

```json
{
    "status": 401,
    "mensaje": "TOKEN DE AUTENTICACIÓN REQUERIDO. ENVÍA EL HEADER: Authorization: Bearer tu_token"
}
```

***EL FILTRO SE REGISTRA EN `app/Config/Filters.php` CON EL ALIAS `apiauth`. PARA ACTIVARLO EN LAS RUTAS DE LA API, SE AÑADIRÍA:***

```php
'apiauth' => ['before' => ['api/*']],
```

---

## `SECCIONES 20-21: CODEIGNITER SHIELD - AUTENTICACIÓN, GRUPOS Y PERMISOS 🛡️`

> [!NOTE]
> ***ESTAS SECCIONES SON TEÓRICAS. EXPLICAN CODEIGNITER SHIELD, EL PAQUETE OFICIAL DE AUTENTICACIÓN DEL FRAMEWORK. EN NUESTRO PROYECTO MANTENEMOS EL SISTEMA DE LOGIN MANUAL (AuthFilter, AdminFilter, UsuarioModel) PARA FINES EDUCATIVOS, PERO SE DOCUMENTA CÓMO SHIELD PODRÍA REEMPLAZARLO CON FUNCIONALIDADES MÁS AVANZADAS***

### `¿QUÉ ES CODEIGNITER SHIELD?`

***SHIELD ES EL PAQUETE OFICIAL DE AUTENTICACIÓN Y AUTORIZACIÓN PARA CODEIGNITER 4, MANTENIDO POR EL EQUIPO DEL FRAMEWORK. INCLUYE:***

| FUNCIONALIDAD | MANUAL (NUESTRO PROYECTO) | CON SHIELD |
|---|---|---|
| ***LOGIN/REGISTRO*** | ***LO HICIMOS MANUALMENTE*** | ***YA VIENE HECHO*** |
| ***HASH DE CONTRASEÑAS*** | ***CALLBACK beforeInsert*** | ***AUTOMÁTICO (ARGON2ID)*** |
| ***RECORDAR SESIÓN*** | ***NO TENEMOS*** | ***"REMEMBER ME" INCLUIDO*** |
| ***RECUPERAR CONTRASEÑA*** | ***NO TENEMOS*** | ***EMAIL + TOKEN INCLUIDO*** |
| ***AUTH POR TOKENS (API)*** | ***NO TENEMOS*** | ***PERSONAL ACCESS TOKENS*** |
| ***GRUPOS DE USUARIOS*** | ***SOLO "ADMIN/USUARIO"*** | ***SISTEMA COMPLETO DE GRUPOS*** |
| ***PERMISOS GRANULARES*** | ***NO TENEMOS*** | ***SISTEMA COMPLETO DE PERMISOS*** |
| ***BLOQUEO POR INTENTOS*** | ***NO TENEMOS*** | ***THROTTLING AUTOMÁTICO*** |

### `INSTALACIÓN Y CONFIGURACIÓN`

```bash
# INSTALAR SHIELD CON COMPOSER
> ddev composer require codeigniter4/shield

# EJECUTAR EL SETUP AUTOMÁTICO (CREA TABLAS, CONFIGURACIÓN, FILTROS)
> ddev exec php spark shield:setup

# EJECUTAR LAS MIGRACIONES DE SHIELD
> ddev exec php spark migrate
```

### `GRUPOS Y PERMISOS`

***SHIELD PERMITE DEFINIR GRUPOS (ROLES) Y PERMISOS (ACCIONES ESPECÍFICAS) EN `app/Config/AuthGroups.php`:***

```php
// GRUPOS (EQUIVALENTE A NUESTROS ROLES)
public array $groups = [
    'superadmin' => ['title' => 'Super Admin', 'description' => 'Control total'],
    'admin'      => ['title' => 'Admin', 'description' => 'Administración del día a día'],
    'editor'     => ['title' => 'Editor', 'description' => 'Editar contenido existente'],
    'usuario'    => ['title' => 'Usuario', 'description' => 'Acceso básico'],
];

// PERMISOS (ACCIONES GRANULARES)
public array $permissions = [
    'peliculas.crear'    => 'Puede crear películas',
    'peliculas.editar'   => 'Puede editar películas',
    'peliculas.eliminar' => 'Puede eliminar películas',
    'categorias.gestionar' => 'Puede gestionar categorías',
];
```

### `FUNCIONES HELPER DE SHIELD`

```php
// ¿ESTÁ LOGUEADO?
if (auth()->loggedIn()) { ... }

// OBTENER DATOS DEL USUARIO
$nombre = auth()->user()->username;
$email  = auth()->user()->email;

// VERIFICAR GRUPO
if (auth()->user()->inGroup('admin')) { ... }

// VERIFICAR PERMISO
if (auth()->user()->can('peliculas.eliminar')) { ... }
```

---

## `SECCIÓN 22: COMPONENTES AVANZADOS DE CODEIGNITER 4 ⚙️`

> [!NOTE]
> ***ESTA SECCIÓN ES MAYORMENTE TEÓRICA. EXPLICA COMPONENTES AVANZADOS DEL FRAMEWORK QUE VAN MÁS ALLÁ DEL MVC BÁSICO: ARCHIVO .env, SPARK (CLI), EVENTOS, CACHÉ, ENVÍO DE EMAILS, ENCRIPTACIÓN, ENTORNOS DE EJECUCIÓN Y LOGGING***

### `ARCHIVOS DE REFERENCIA`

| ARCHIVO | QUÉ CONTIENE |
|---|---|
| ***`.env`*** | ***VARIABLES DE CONFIGURACIÓN POR ENTORNO (BD, BASE_URL, SESIÓN, ENCRIPTACIÓN). NUNCA SE SUBE A GIT*** |
| ***`app/Config/Boot/development.php`*** | ***CONFIGURACIÓN PARA DESARROLLO: ERRORES DETALLADOS, DEBUG TOOLBAR*** |
| ***`app/Config/Boot/production.php`*** | ***CONFIGURACIÓN PARA PRODUCCIÓN: ERRORES GENÉRICOS, SIN DEBUG*** |
| ***`app/Config/Cache.php`*** | ***CONFIGURACIÓN DEL SISTEMA DE CACHÉ (FILE, REDIS, MEMCACHED)*** |
| ***`app/Config/Email.php`*** | ***CONFIGURACIÓN SMTP PARA ENVÍO DE EMAILS*** |
| ***`app/Config/Logger.php`*** | ***CONFIGURACIÓN DEL SISTEMA DE LOGGING (NIVEL, FORMATO, DESTINO)*** |

### `EL ARCHIVO .env`

***EL ARCHIVO `.env` CONTIENE VARIABLES QUE CAMBIAN SEGÚN EL ENTORNO. CODEIGNITER LAS LEE AL ARRANCAR Y SOBREESCRIBE LOS VALORES POR DEFECTO DE `Config/*.php`:***

```env
# ENTORNO: development (ERRORES DETALLADOS) O production (ERRORES GENÉRICOS)
CI_ENVIRONMENT = development

# URL BASE DE LA APLICACIÓN
app.baseURL = 'https://udemy.ddev.site'

# CONEXIÓN A LA BASE DE DATOS
database.default.hostname = db
database.default.database = db
database.default.username = db
database.default.password = db
```

### `SPARK: LA LÍNEA DE COMANDOS DE CODEIGNITER`

```bash
> php spark                          # VER TODOS LOS COMANDOS DISPONIBLES
> php spark env                      # VER EL ENTORNO ACTUAL (development/production)
> php spark routes                   # LISTAR TODAS LAS RUTAS REGISTRADAS
> php spark migrate                  # EJECUTAR MIGRACIONES PENDIENTES
> php spark cache:clear              # LIMPIAR TODA LA CACHÉ
> php spark key:generate             # GENERAR CLAVE DE ENCRIPTACIÓN
> php spark db:table peliculas       # VER ESTRUCTURA DE UNA TABLA
```

### `SISTEMA DE CACHÉ`

```php
// INTENTAR LEER DE CACHÉ; SI NO EXISTE, CONSULTAR LA BD Y GUARDAR
$peliculas = cache('peliculas_listado');
if ($peliculas === null) {
    $peliculas = $this->peliculaModel->getPeliculasConCategoria();
    cache()->save('peliculas_listado', $peliculas, 300); // 300 SEGUNDOS = 5 MINUTOS
}

// INVALIDAR LA CACHÉ CUANDO SE MODIFICA UN DATO
cache()->delete('peliculas_listado');
```

### `ENVÍO DE EMAILS`

```php
$email = service('email');
$email->setFrom('tu@email.com', 'CI4 Udemy');
$email->setTo('destino@email.com');
$email->setSubject('Nueva película creada');
$email->setMessage('<h1>Se ha creado una nueva película</h1>');
$email->send();
```

### `ENCRIPTACIÓN DE DATOS`

```php
$encrypter = service('encrypter');
$datoEncriptado = $encrypter->encrypt('4242-4242-4242-4242');
$datoOriginal   = $encrypter->decrypt($datoEncriptado);
```

### `LOGGING (REGISTRO DE EVENTOS)`

```php
log_message('info', 'Película eliminada: Matrix por usuario: Admin');
log_message('error', 'Error al conectar con la base de datos');
log_message('warning', 'Intento de acceso no autorizado desde IP: 192.168.1.100');
```

---

## `SECCIÓN 23: TRABAJANDO CON LIBRERÍAS 📚`

> [!NOTE]
> ***EN ESTA SECCIÓN SE EXPLICA QUÉ SON LAS LIBRERÍAS EN CODEIGNITER 4 (TANTO LAS INTEGRADAS COMO LAS PERSONALIZADAS), SE CREA UNA LIBRERÍA PROPIA `PdfGenerator` PARA GENERAR DOCUMENTOS PDF, SE REGISTRA COMO SERVICIO Y SE AÑADE UN ENDPOINT PARA EXPORTAR LA FICHA DE UNA PELÍCULA***

### `ARCHIVOS QUE ENTRAN EN JUEGO`

| ARCHIVO | QUÉ SE HACE |
|---|---|
| ***`app/Libraries/PdfGenerator.php`*** | ***SE CREA: LIBRERÍA PERSONALIZADA CON MÉTODOS `setTitulo()`, `setContenido()`, `generar()`, `peliculaPdf()` Y `listadoPeliculasPdf()`. USA METHOD CHAINING (ENCADENAMIENTO DE MÉTODOS). GENERA HTML FORMATEADO QUE PUEDE SER CONVERTIDO A PDF*** |
| ***`app/Config/Services.php`*** | ***SE MODIFICA: SE REGISTRA LA LIBRERÍA COMO SERVICIO PARA ACCEDER CON `service('pdfGenerator')` EN VEZ DE `new PdfGenerator()`*** |
| ***`app/Controllers/Pelicula.php`*** | ***SE MODIFICA: SE AÑADE EL MÉTODO `pdf($id)` QUE USA LA LIBRERÍA PARA GENERAR LA FICHA DE UNA PELÍCULA*** |
| ***`app/Config/Routes.php`*** | ***SE MODIFICA: SE AÑADE LA RUTA `GET /peliculas/pdf/(:num)`*** |

### `LIBRERÍAS INTEGRADAS QUE YA USAMOS`

| LIBRERÍA | DÓNDE SE USA | QUÉ HACE |
|---|---|---|
| ***SESSION*** | ***`Auth.php`, `AuthFilter.php`, `layout/main.php`*** | ***GESTIÓN DE SESIONES: `session()->set()`, `session()->get()`, `session()->destroy()`*** |
| ***VALIDATION*** | ***`TODOS LOS MODELOS`, `Auth.php`, `Pelicula.php`*** | ***VALIDACIÓN DE DATOS: REGLAS EN EL MODELO, `$this->validate()` EN EL CONTROLADOR*** |
| ***UPLOAD*** | ***`Pelicula.php`*** | ***CARGA DE ARCHIVOS: `$this->request->getFile()`, `$imagen->move()`*** |
| ***PAGINATION*** | ***`PeliculaModel.php`, `Pelicula.php`*** | ***PAGINACIÓN: `->paginate(5)`, `$pager->links()`*** |

### `LIBRERÍA PdfGenerator`

***ARCHIVO: `app/Libraries/PdfGenerator.php`***

***SE CREA UNA LIBRERÍA PERSONALIZADA QUE ENCAPSULA LA GENERACIÓN DE PDFs. TIENE ESTOS MÉTODOS:***

| MÉTODO | QUÉ HACE |
|---|---|
| ***`setTitulo($titulo)`*** | ***ESTABLECE EL TÍTULO DEL DOCUMENTO. RETORNA `$this` PARA ENCADENAR*** |
| ***`setContenido($html)`*** | ***ESTABLECE EL CONTENIDO HTML. RETORNA `$this` PARA ENCADENAR*** |
| ***`setOrientacion($orientacion)`*** | ***'portrait' O 'landscape'. RETORNA `$this` PARA ENCADENAR*** |
| ***`generar()`*** | ***GENERA EL HTML COMPLETO DEL DOCUMENTO CON ESTILOS CSS*** |
| ***`peliculaPdf($pelicula)`*** | ***GENERA LA FICHA DE UNA PELÍCULA EN FORMATO TABLA HTML*** |
| ***`listadoPeliculasPdf($peliculas)`*** | ***GENERA UNA TABLA CON EL LISTADO COMPLETO DE PELÍCULAS*** |

### `USO EN EL CONTROLADOR`

```php
// ACCEDER MEDIANTE SERVICIO
$pdf = service('pdfGenerator');
$html = $pdf->peliculaPdf($pelicula);

// O CON METHOD CHAINING
$html = service('pdfGenerator')
    ->setTitulo('Mi reporte')
    ->setContenido('<p>Contenido aquí</p>')
    ->generar();
```

### `RUTA DE ACCESO`

```
https://udemy.ddev.site/peliculas/pdf/5
```

### `LIBRERÍAS DE TERCEROS (VÍA COMPOSER)`

```bash
# INSTALAR DOMPDF PARA GENERAR PDFs BINARIOS REALES
> ddev composer require dompdf/dompdf

# INSTALAR PHPSPREADSHEET PARA GENERAR ARCHIVOS EXCEL
> ddev composer require phpoffice/phpspreadsheet

# INSTALAR FAKER PARA GENERAR DATOS DE PRUEBA AVANZADOS
> ddev composer require fakerphp/faker
```

---

## `SECCIÓN 24: TRABAJANDO CON HELPERS 🔧`

> [!NOTE]
> ***EN ESTA SECCIÓN SE EXPLICA LA DIFERENCIA ENTRE LIBRERÍAS (CLASES) Y HELPERS (FUNCIONES SUELTAS), SE REPASAN LOS HELPERS QUE YA USAMOS EN EL PROYECTO (URL, FORM, TEXT, SECURITY) Y SE CREA UN HELPER PERSONALIZADO `proyecto_helper.php` CON FUNCIONES UTILITARIAS: `fecha_es()`, `generar_slug()`, `badge_rol()`, `tiempo_relativo()`, `texto_preview()` Y `tamano_archivo()`***

### `ARCHIVOS QUE ENTRAN EN JUEGO`

| ARCHIVO | QUÉ SE HACE |
|---|---|
| ***`app/Helpers/proyecto_helper.php`*** | ***SE CREA: HELPER PERSONALIZADO CON 6 FUNCIONES UTILITARIAS. CADA FUNCIÓN VA ENVUELTA EN `if (!function_exists())` PARA PREVENIR ERRORES DE REDECLARACIÓN*** |
| ***`app/Controllers/BaseController.php`*** | ***SE MODIFICA: SE AÑADE `'proyecto'` AL ARRAY `$helpers` PARA QUE SE CARGUE AUTOMÁTICAMENTE EN TODOS LOS CONTROLADORES*** |

### `DIFERENCIA ENTRE LIBRERÍA Y HELPER`

| CARACTERÍSTICA | LIBRERÍA | HELPER |
|---|---|---|
| ***ESTRUCTURA*** | ***CLASE CON MÉTODOS*** | ***FUNCIONES SUELTAS*** |
| ***ESTADO*** | ***TIENE PROPIEDADES*** | ***SIN ESTADO (STATELESS)*** |
| ***ACCESO*** | ***`$objeto->metodo()`*** | ***`funcion()`*** |
| ***EJEMPLO*** | ***`$email->send()`*** | ***`base_url('/ruta')`*** |
| ***UBICACIÓN*** | ***`app/Libraries/`*** | ***`app/Helpers/`*** |
| ***CARGA*** | ***`new` / `service()`*** | ***`helper('nombre')`*** |

### `HELPERS QUE YA USAMOS EN EL PROYECTO`

| HELPER | FUNCIONES QUE USAMOS | DÓNDE |
|---|---|---|
| ***URL*** | ***`base_url()`, `redirect()`*** | ***TODAS LAS VISTAS Y CONTROLADORES*** |
| ***FORM*** | ***`csrf_field()`, `old()`*** | ***TODOS LOS FORMULARIOS*** |
| ***TEXT*** | ***`character_limiter()`*** | ***`peliculas/index.php` (RECORTAR DESCRIPCIÓN)*** |
| ***SECURITY*** | ***`esc()`*** | ***TODAS LAS VISTAS (PREVENIR XSS)*** |

### `FUNCIONES DEL HELPER PERSONALIZADO`

***ARCHIVO: `app/Helpers/proyecto_helper.php`***

| FUNCIÓN | QUÉ HACE | EJEMPLO |
|---|---|---|
| ***`fecha_es($fecha)`*** | ***FORMATEA FECHA EN ESPAÑOL*** | ***`fecha_es('2026-03-16 12:00:00')` → `'16 de Marzo de 2026'`*** |
| ***`generar_slug($texto)`*** | ***GENERA URL AMIGABLE*** | ***`generar_slug('El Padrino - Parte II')` → `'el-padrino-parte-ii'`*** |
| ***`badge_rol($rol)`*** | ***GENERA BADGE HTML BOOTSTRAP*** | ***`badge_rol('admin')` → `'<span class="badge bg-success">ADMIN</span>'`*** |
| ***`tiempo_relativo($fecha)`*** | ***MUESTRA "HACE X TIEMPO"*** | ***`tiempo_relativo('2026-03-24 10:00:00')` → `'Hace 3 horas'`*** |
| ***`texto_preview($texto, 80)`*** | ***RECORTA TEXTO SIN CORTAR PALABRAS*** | ***`texto_preview('Un niño mexicano...', 30)` → `'Un niño mexicano...'`*** |
| ***`tamano_archivo(2097152)`*** | ***FORMATEA BYTES A KB/MB/GB*** | ***`tamano_archivo(2097152)` → `'2 MB'`*** |

### `CÓMO SE CARGAN LOS HELPERS`

```php
// OPCIÓN A: EN EL BASECONTROLLER (PARA TODOS LOS CONTROLADORES)
// ARCHIVO: app/Controllers/BaseController.php
protected $helpers = ['url', 'form', 'proyecto'];

// OPCIÓN B: EN UN CONTROLADOR ESPECÍFICO
helper('proyecto');

// OPCIÓN C: EN Config/Autoload.php (EN TODA LA APLICACIÓN)
public $helpers = ['url', 'form', 'proyecto'];
```

---

## `SECCIÓN 25: SISTEMA CRUD AUTOMATIZADO 🤖`

> [!NOTE]
> ***EN ESTA SECCIÓN SE ANALIZA EL PATRÓN REPETITIVO QUE SIGUEN LOS 3 CRUDS DEL PROYECTO (PELÍCULAS, CATEGORÍAS, ETIQUETAS) Y SE CREA UN SISTEMA PARA AUTOMATIZAR LA CREACIÓN DE NUEVOS CRUDS. SE IMPLEMENTA UN CONTROLADOR BASE ABSTRACTO (`CrudController`) CON TODA LA LÓGICA CRUD, UNA FUNCIÓN HELPER PARA REGISTRAR RUTAS AUTOMÁTICAMENTE Y UN COMANDO SPARK PERSONALIZADO PARA GENERAR LOS ARCHIVOS DEL ESQUELETO***

### `ARCHIVOS QUE ENTRAN EN JUEGO`

| ARCHIVO | QUÉ SE HACE |
|---|---|
| ***`app/Controllers/CrudController.php`*** | ***SE CREA: CONTROLADOR BASE ABSTRACTO CON LOS 6 MÉTODOS CRUD (INDEX, CREATE, STORE, EDIT, UPDATE, DELETE) Y 6 MÉTODOS HOOK (datosExtraFormulario, antesDeGuardar, despuesDeGuardar, antesDeActualizar, despuesDeActualizar, antesDeEliminar) QUE LOS HIJOS SOBREESCRIBEN PARA PERSONALIZAR*** |
| ***`app/Commands/GenerarCrud.php`*** | ***SE CREA: COMANDO SPARK PERSONALIZADO (`php spark crud:generar NombreEntidad`) QUE GENERA AUTOMÁTICAMENTE EL CONTROLADOR Y LAS 3 VISTAS (INDEX, CREATE, EDIT) CON BOOTSTRAP*** |
| ***`app/Config/Routes.php`*** | ***SE MODIFICA: SE AÑADE LA FUNCIÓN `registrarCrud()` QUE GENERA LAS 6 RUTAS CRUD EN 1 LÍNEA. LAS 18 RUTAS MANUALES SE REEMPLAZAN POR 3 LÍNEAS*** |

### `EL PROBLEMA: CÓDIGO REPETITIVO`

***LOS 3 CONTROLADORES CRUD (Pelicula, Categoria, Etiqueta) SIGUEN EXACTAMENTE EL MISMO PATRÓN:***

```
ANTES: ~100 LÍNEAS POR CONTROLADOR × 3 ENTIDADES = ~300 LÍNEAS REPETITIVAS
AHORA: ~15 LÍNEAS POR CONTROLADOR × 3 ENTIDADES = ~45 LÍNEAS
```

### `LA SOLUCIÓN: CrudController ABSTRACTO`

***EL CONTROLADOR BASE CONTIENE TODA LA LÓGICA. LOS HIJOS SOLO DEFINEN CONFIGURACIÓN:***

```php
// EJEMPLO: CRUD DE CATEGORÍAS EN SOLO 12 LÍNEAS
class Categoria extends CrudController
{
    protected string $modelClass     = 'App\Models\CategoriaModel';
    protected string $vistasPrefijo  = 'categorias';
    protected string $rutaBase       = '/categorias';
    protected string $tituloSingular = 'Categoría';
    protected string $tituloPlural   = 'Categorías';
    protected string $variableLista  = 'categorias';
    protected string $variableItem   = 'categoria';
    protected array  $campos         = ['titulo'];
    protected int    $porPagina      = 10;
}
```

### `PROPIEDADES DEL CrudController`

| PROPIEDAD | TIPO | DESCRIPCIÓN | EJEMPLO |
|---|---|---|---|
| ***`$modelClass`*** | ***string*** | ***CLASE DEL MODELO CON NAMESPACE*** | ***`'App\Models\CategoriaModel'`*** |
| ***`$vistasPrefijo`*** | ***string*** | ***CARPETA DE VISTAS*** | ***`'categorias'`*** |
| ***`$rutaBase`*** | ***string*** | ***URL PARA REDIRECCIONES*** | ***`'/categorias'`*** |
| ***`$tituloSingular`*** | ***string*** | ***NOMBRE PARA MENSAJES*** | ***`'Categoría'`*** |
| ***`$tituloPlural`*** | ***string*** | ***NOMBRE PARA EL LISTADO*** | ***`'Categorías'`*** |
| ***`$variableLista`*** | ***string*** | ***VARIABLE EN VISTA INDEX*** | ***`'categorias'`*** |
| ***`$variableItem`*** | ***string*** | ***VARIABLE EN VISTA EDIT*** | ***`'categoria'`*** |
| ***`$campos`*** | ***array*** | ***CAMPOS DEL FORMULARIO*** | ***`['titulo']`*** |
| ***`$porPagina`*** | ***int*** | ***REGISTROS POR PÁGINA*** | ***`10` (0 = SIN PAGINACIÓN)*** |

### `MÉTODOS HOOK (PERSONALIZACIÓN)`

***LOS HOOKS SON MÉTODOS VACÍOS QUE LOS CONTROLADORES HIJOS SOBREESCRIBEN CUANDO NECESITAN COMPORTAMIENTO ESPECIAL:***

| HOOK | CUÁNDO SE EJECUTA | EJEMPLO DE USO |
|---|---|---|
| ***`datosExtraFormulario()`*** | ***EN CREATE() Y EDIT()*** | ***PASAR LISTA DE CATEGORÍAS PARA EL SELECT*** |
| ***`antesDeGuardar()`*** | ***EN STORE(), ANTES DE SAVE()*** | ***PROCESAR Y SUBIR IMAGEN*** |
| ***`despuesDeGuardar()`*** | ***EN STORE(), DESPUÉS DE SAVE()*** | ***SINCRONIZAR ETIQUETAS EN TABLA PIVOTE*** |
| ***`antesDeActualizar()`*** | ***EN UPDATE(), ANTES DE UPDATE()*** | ***PROCESAR NUEVA IMAGEN, BORRAR LA ANTERIOR*** |
| ***`despuesDeActualizar()`*** | ***EN UPDATE(), DESPUÉS DE UPDATE()*** | ***SINCRONIZAR ETIQUETAS*** |
| ***`antesDeEliminar()`*** | ***EN DELETE(), ANTES DE DELETE()*** | ***BORRAR IMAGEN DEL SERVIDOR, BORRAR PIVOTE*** |

### `FUNCIÓN registrarCrud()`

***ARCHIVO: `app/Config/Routes.php`***

```php
// ANTES: 18 LÍNEAS DE RUTAS MANUALES (6 POR ENTIDAD × 3 ENTIDADES)
$routes->get('/categorias', 'Categoria::index');
$routes->get('/categorias/create', 'Categoria::create');
// ... 4 líneas más por entidad ...

// AHORA: 3 LÍNEAS CON registrarCrud()
registrarCrud($routes, 'peliculas', 'Pelicula');
registrarCrud($routes, 'categorias', 'Categoria');
registrarCrud($routes, 'etiquetas', 'Etiqueta');
```

### `COMANDO php spark crud:generar`

***ARCHIVO: `app/Commands/GenerarCrud.php`***

```bash
# GENERAR UN CRUD COMPLETO PARA UNA NUEVA ENTIDAD "Producto"
> ddev exec php spark crud:generar Producto

# GENERA AUTOMÁTICAMENTE:
#   ✓ app/Controllers/Producto.php (HEREDA DE CrudController)
#   ✓ app/Views/productos/index.php (TABLA BOOTSTRAP CON PAGINACIÓN)
#   ✓ app/Views/productos/create.php (FORMULARIO DE CREACIÓN)
#   ✓ app/Views/productos/edit.php (FORMULARIO DE EDICIÓN)
```

### `FLUJO PARA AÑADIR UNA NUEVA ENTIDAD`

```bash
# 1. GENERAR EL ESQUELETO (1 SEGUNDO)
> ddev exec php spark crud:generar Producto

# 2. CREAR LA MIGRACIÓN
> ddev exec php spark make:migration Productos

# 3. CREAR EL MODELO
> ddev exec php spark make:model ProductoModel

# 4. COMPLETAR LOS CAMPOS EN EL CONTROLADOR GENERADO
# 5. COMPLETAR LOS INPUTS EN LAS VISTAS GENERADAS

# 6. AÑADIR LA RUTA EN Routes.php:
registrarCrud($routes, 'productos', 'Producto');

# 7. EJECUTAR LA MIGRACIÓN
> ddev exec php spark migrate
```


---

## `URLS DE ACCESO 🌐`

| URL | DESCRIPCIÓN |
|---|---|
| ***https://udemy.ddev.site*** | ***PÁGINA PRINCIPAL*** |
| ***https://udemy.ddev.site/auth/login*** | ***FORMULARIO DE LOGIN*** |
| ***https://udemy.ddev.site/auth/registro*** | ***FORMULARIO DE REGISTRO*** |
| ***https://udemy.ddev.site/peliculas*** | ***CRUD DE PELÍCULAS (REQUIERE LOGIN)*** |
| ***https://udemy.ddev.site/categorias*** | ***CRUD DE CATEGORÍAS (REQUIERE LOGIN)*** |
| ***https://udemy.ddev.site/etiquetas*** | ***CRUD DE ETIQUETAS (REQUIERE LOGIN)*** |
| ***https://udemy.ddev.site/api/peliculas*** | ***API REST PELÍCULAS (JSON)*** |
| ***https://udemy.ddev.site/api/categorias*** | ***API REST CATEGORÍAS (JSON)*** |
| ***https://udemy.ddev.site/peliculas/pdf/5*** | ***PDF DE PELÍCULA (SECCIÓN 23)*** |
| ***https://udemy.ddev.site/api/peliculas?busqueda=matrix*** | ***API CON FILTROS (SECCIÓN 19)*** |
| ***https://udemy.ddev.site/api/peliculas?page=2&per_page=20*** | ***API CON PAGINACIÓN (SECCIÓN 19)*** |

---

## `RESUMEN DE SECCIONES COMPLETADAS 📋`

| SECCIÓN | CONTENIDO |
|---|---|
| ***3*** | ***CRUD COMPLETO DE PELÍCULAS (MIGRACIÓN, MODELO, CONTROLADOR, VISTAS, RUTAS)*** |
| ***4*** | ***CRUD COMPLETO DE CATEGORÍAS (RETO: REPLICAR EL PATRÓN DE PELÍCULAS)*** |
| ***9*** | ***VALIDACIONES AVANZADAS: REGLAS EN EL MODELO, MENSAJES CUSTOM EN ESPAÑOL, is_unique*** |
| ***10*** | ***FILTROS DE SEGURIDAD: AUTHFILTER, ADMINFILTER, REGISTRO EN Config/Filters.php*** |
| ***11*** | ***AUTENTICACIÓN: LOGIN, REGISTRO, LOGOUT, HASH BCRYPT, SESIONES, ROLES (ADMIN/USUARIO)*** |
| ***12*** | ***API REST CRUD: ENDPOINTS JSON PARA CATEGORÍAS Y PELÍCULAS CON RESOURCECONTROLLER*** |
| ***14*** | ***RELACIÓN 1:N: CATEGORÍA → PELÍCULAS CON FK categoria_id Y LEFT JOIN*** |
| ***15*** | ***RELACIÓN N:M: ETIQUETAS ↔ PELÍCULAS CON TABLA PIVOTE, CRUD ETIQUETAS Y CHECKBOXES*** |
| ***16*** | ***CARGA DE ARCHIVOS: SUBIDA DE IMÁGENES CON VALIDACIÓN, NOMBRES ALEATORIOS Y ELIMINACIÓN*** |
| ***17*** | ***INTEGRACIÓN: API CON ETIQUETAS, NAVBAR AMPLIADA, FILTRO AUTH EN ETIQUETAS*** |
| ***18*** | ***LISTADO PAGINADO Y FILTROS: PAGINACIÓN EN TODOS LOS LISTADOS, BÚSQUEDA POR TEXTO, FILTRO POR CATEGORÍA/ETIQUETA, LIKE AGRUPADO CON groupStart()/groupEnd()*** |
| ***19*** | ***REST API AVANZADA: PAGINACIÓN EN API, FILTROS/BÚSQUEDA, UPLOAD DE IMÁGENES, ASIGNACIÓN DE ETIQUETAS, FILTRO ApiAuthFilter*** |
| ***20-21*** | ***CODEIGNITER SHIELD (TEÓRICO): AUTENTICACIÓN OFICIAL, GRUPOS, PERMISOS, TOKENS, COMPARACIÓN CON SISTEMA MANUAL*** |
| ***22*** | ***COMPONENTES AVANZADOS (TEÓRICO): .env, SPARK, EVENTOS, CACHÉ, EMAILS, ENCRIPTACIÓN, ENTORNOS, LOGGING*** |
| ***23*** | ***LIBRERÍAS: LIBRERÍA PERSONALIZADA PdfGenerator, REGISTRO COMO SERVICIO, ENDPOINT PDF, LIBRERÍAS DE TERCEROS*** |
| ***24*** | ***HELPERS: HELPER PERSONALIZADO proyecto_helper.php CON fecha_es(), generar_slug(), badge_rol(), tiempo_relativo()*** |
| ***25*** | ***CRUD AUTOMATIZADO: CrudController ABSTRACTO, HOOKS, registrarCrud(), COMANDO php spark crud:generar*** |

---

## `SOLUCIÓN DE PROBLEMAS COMUNES 🔧`

| ERROR | CAUSA | SOLUCIÓN |
|---|---|---|
| ***`Table 'db.usuarios' doesn't exist`*** | ***NO SE EJECUTÓ LA MIGRACIÓN DE USUARIOS*** | ***`ddev exec php spark migrate`*** |
| ***`Table 'db.peliculas' doesn't exist`*** | ***NO SE EJECUTÓ NINGUNA MIGRACIÓN*** | ***`ddev exec php spark migrate`*** |
| ***NO HAY USUARIOS PARA HACER LOGIN*** | ***NO SE EJECUTÓ EL SEEDER DE USUARIOS*** | ***`ddev exec php spark db:seed UsuarioSeeder`*** |
| ***CREDENCIALES INCORRECTAS CON 123456*** | ***LOS USUARIOS NO EXISTEN EN LA BD*** | ***EJECUTAR EL SEEDER: `ddev exec php spark db:seed UsuarioSeeder`*** |
| ***REDIRIGE AL LOGIN AL ENTRAR A /peliculas*** | ***ES EL COMPORTAMIENTO CORRECTO (FILTRO AUTH)*** | ***INICIA SESIÓN PRIMERO EN /auth/login*** |
| ***ERROR 500 AL ACCEDER A LA WEB*** | ***FALTA EL ARCHIVO `.env` O ESTÁ MAL CONFIGURADO*** | ***COPIAR `env` A `.env` Y CONFIGURAR (VER PASO 4)*** |
| ***`Table 'db.etiquetas' doesn't exist`*** | ***NO SE EJECUTÓ LA MIGRACIÓN DE ETIQUETAS*** | ***`ddev exec php spark migrate`*** |
| ***NO HAY ETIQUETAS EN LOS CHECKBOXES*** | ***NO SE EJECUTÓ EL SEEDER DE ETIQUETAS*** | ***`ddev exec php spark db:seed EtiquetaSeeder`*** |
| ***LA IMAGEN NO SE SUBE*** | ***EL FORMULARIO NO TIENE `enctype="multipart/form-data"`*** | ***VERIFICAR QUE EL FORM TENGA ESE ATRIBUTO*** |
| ***DDEV NO ARRANCA*** | ***DOCKER NO ESTÁ CORRIENDO O WSL ESTÁ APAGADO*** | ***INICIAR DOCKER DESKTOP Y EJECUTAR `ddev start`*** |
| ***LA PAGINACIÓN NO MUESTRA ENLACES*** | ***HAY MENOS REGISTROS QUE EL LÍMITE POR PÁGINA*** | ***INSERTAR MÁS DATOS O REDUCIR EL NÚMERO POR PÁGINA*** |
| ***LOS FILTROS SE PIERDEN AL PAGINAR*** | ***EL FORMULARIO NO USA `method="GET"`*** | ***VERIFICAR QUE EL FORM USE GET Y QUE LOS INPUTS TENGAN EL VALUE CON EL FILTRO ACTUAL*** |

---

> [!TIP]
> ***TODO EL CÓDIGO DEL PROYECTO ESTÁ COMENTADO LÍNEA POR LÍNEA EN MAYÚSCULAS PARA FACILITAR EL APRENDIZAJE***
