# `PROYECTO UDEMY - CODEIGNITER 4 🔷`

![img](https://i.pinimg.com/originals/a1/f8/be/a1f8be54a08a324c83e747a8fa5ed660.gif)

> [!NOTE]
> ***ESTE PROYECTO ES EL RESULTADO DE LAS SECCIONES 3 A 12 DEL CURSO DE UDEMY "CODEIGNITER 4 DESDE CERO + INTEGRACIÓN CON BOOTSTRAP 4 O 5". INCLUYE LOS CRUDS COMPLETOS DE PELÍCULAS Y CATEGORÍAS, VALIDACIONES AVANZADAS CON MENSAJES PERSONALIZADOS, SISTEMA DE AUTENTICACIÓN CON LOGIN/REGISTRO, FILTROS DE SEGURIDAD, CONTRASEÑAS HASHEADAS CON BCRYPT, ROLES DE USUARIO (ADMIN/USUARIO) Y UNA API REST COMPLETA PARA CATEGORÍAS Y PELÍCULAS. TODO DESPLEGADO CON DDEV EN WSL***

---

## `ESTRUCTURA DEL PROYECTO 📁`

```
app/
├── Config/
│   ├── Routes.php                    # RUTAS CRUD, AUTH Y API REST
│   └── Filters.php                   # CONFIGURACIÓN DE FILTROS (AUTH, ADMIN)
├── Controllers/
│   ├── Pelicula.php                  # CONTROLADOR CRUD PELÍCULAS (WEB)
│   ├── Categoria.php                 # CONTROLADOR CRUD CATEGORÍAS (WEB)
│   ├── Auth.php                      # CONTROLADOR AUTENTICACIÓN (LOGIN, REGISTRO, LOGOUT)
│   ├── ApiPelicula.php               # CONTROLADOR API REST PELÍCULAS (JSON)
│   └── ApiCategoria.php              # CONTROLADOR API REST CATEGORÍAS (JSON)
├── Database/
│   ├── Migrations/
│   │   ├── 2026-03-12-113339_Peliculas.php   # MIGRACIÓN TABLA PELICULAS
│   │   ├── 2026-03-12-114415_Categorias.php  # MIGRACIÓN TABLA CATEGORIAS
│   │   └── 2026-03-16-100000_Usuarios.php    # MIGRACIÓN TABLA USUARIOS (CON HASH)
│   └── Seeds/
│       ├── PeliculaSeeder.php        # DATOS DE PRUEBA: 5 PELÍCULAS
│       ├── CategoriaSeeder.php       # DATOS DE PRUEBA: 10 CATEGORÍAS
│       └── UsuarioSeeder.php         # DATOS DE PRUEBA: 3 USUARIOS (ADMIN + NORMALES)
├── Filters/
│   ├── AuthFilter.php                # FILTRO: VERIFICA QUE EL USUARIO ESTÉ LOGUEADO
│   └── AdminFilter.php               # FILTRO: VERIFICA QUE EL USUARIO SEA ADMIN
├── Models/
│   ├── PeliculaModel.php             # MODELO PELÍCULAS (CON VALIDACIÓN Y MENSAJES CUSTOM)
│   ├── CategoriaModel.php            # MODELO CATEGORÍAS (CON VALIDACIÓN, UNIQUE Y MENSAJES)
│   └── UsuarioModel.php              # MODELO USUARIOS (CON HASH BCRYPT AUTOMÁTICO)
└── Views/
    ├── layout/
    │   └── main.php                  # LAYOUT PRINCIPAL CON NAVBAR DINÁMICA (LOGIN/LOGOUT)
    ├── peliculas/
    │   ├── index.php                 # LISTADO DE PELÍCULAS
    │   ├── create.php                # FORMULARIO CREAR PELÍCULA
    │   └── edit.php                  # FORMULARIO EDITAR PELÍCULA
    ├── categorias/
    │   ├── index.php                 # LISTADO DE CATEGORÍAS
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

```bash
# CREAR LAS TABLAS EN LA BASE DE DATOS (PELICULAS, CATEGORIAS Y USUARIOS)
> ddev exec php spark migrate

# INSERTAR LOS DATOS DE PRUEBA
> ddev exec php spark db:seed PeliculaSeeder
> ddev exec php spark db:seed CategoriaSeeder
> ddev exec php spark db:seed UsuarioSeeder
```

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

## `URLS DE ACCESO 🌐`

| URL | DESCRIPCIÓN |
|---|---|
| ***https://udemy.ddev.site*** | ***PÁGINA PRINCIPAL*** |
| ***https://udemy.ddev.site/auth/login*** | ***FORMULARIO DE LOGIN*** |
| ***https://udemy.ddev.site/auth/registro*** | ***FORMULARIO DE REGISTRO*** |
| ***https://udemy.ddev.site/peliculas*** | ***CRUD DE PELÍCULAS (REQUIERE LOGIN)*** |
| ***https://udemy.ddev.site/categorias*** | ***CRUD DE CATEGORÍAS (REQUIERE LOGIN)*** |
| ***https://udemy.ddev.site/api/peliculas*** | ***API REST PELÍCULAS (JSON)*** |
| ***https://udemy.ddev.site/api/categorias*** | ***API REST CATEGORÍAS (JSON)*** |

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

---

> [!TIP]
> ***TODO EL CÓDIGO DEL PROYECTO ESTÁ COMENTADO LÍNEA POR LÍNEA EN MAYÚSCULAS PARA FACILITAR EL APRENDIZAJE***
