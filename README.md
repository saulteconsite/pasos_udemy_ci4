# `PROYECTO UDEMY - CODEIGNITER 4 🔷`

![img](https://i.pinimg.com/originals/a1/f8/be/a1f8be54a08a324c83e747a8fa5ed660.gif)

> [!NOTE]
> ***ESTE PROYECTO ES EL RESULTADO DE LAS SECCIONES 3 A 17 DEL CURSO DE UDEMY "CODEIGNITER 4 DESDE CERO + INTEGRACIÓN CON BOOTSTRAP 4 O 5". INCLUYE LOS CRUDS COMPLETOS DE PELÍCULAS, CATEGORÍAS Y ETIQUETAS, RELACIONES UNO A MUCHOS (1:N) Y MUCHOS A MUCHOS (N:M), CARGA DE ARCHIVOS (IMÁGENES), VALIDACIONES AVANZADAS, SISTEMA DE AUTENTICACIÓN CON LOGIN/REGISTRO, FILTROS DE SEGURIDAD, CONTRASEÑAS HASHEADAS CON BCRYPT, ROLES DE USUARIO (ADMIN/USUARIO) Y UNA API REST COMPLETA. TODO DESPLEGADO CON DDEV EN WSL***

---

## `ESTRUCTURA DEL PROYECTO 📁`

```
app/
├── Config/
│   ├── Routes.php                    # RUTAS CRUD, AUTH, ETIQUETAS Y API REST
│   └── Filters.php                   # CONFIGURACIÓN DE FILTROS (AUTH, ADMIN)
├── Controllers/
│   ├── Pelicula.php                  # CONTROLADOR CRUD PELÍCULAS (CON CATEGORÍA, ETIQUETAS E IMAGEN)
│   ├── Categoria.php                 # CONTROLADOR CRUD CATEGORÍAS (WEB)
│   ├── Etiqueta.php                  # CONTROLADOR CRUD ETIQUETAS/TAGS (WEB)
│   ├── Auth.php                      # CONTROLADOR AUTENTICACIÓN (LOGIN, REGISTRO, LOGOUT)
│   ├── ApiPelicula.php               # CONTROLADOR API REST PELÍCULAS (JSON)
│   └── ApiCategoria.php              # CONTROLADOR API REST CATEGORÍAS (JSON)
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
├── Filters/
│   ├── AuthFilter.php                # FILTRO: VERIFICA QUE EL USUARIO ESTÉ LOGUEADO
│   └── AdminFilter.php               # FILTRO: VERIFICA QUE EL USUARIO SEA ADMIN
├── Models/
│   ├── PeliculaModel.php             # MODELO PELÍCULAS (CON JOIN CATEGORÍA Y VALIDACIÓN)
│   ├── CategoriaModel.php            # MODELO CATEGORÍAS (CON VALIDACIÓN, UNIQUE Y MENSAJES)
│   ├── EtiquetaModel.php             # MODELO ETIQUETAS (CON VALIDACIÓN Y UNIQUE)
│   ├── PeliculaEtiquetaModel.php     # MODELO TABLA PIVOTE (SINCRONIZAR RELACIÓN N:M)
│   └── UsuarioModel.php              # MODELO USUARIOS (CON HASH BCRYPT AUTOMÁTICO)
└── Views/
    ├── layout/
    │   └── main.php                  # LAYOUT PRINCIPAL CON NAVBAR DINÁMICA (LOGIN/LOGOUT)
    ├── peliculas/
    │   ├── index.php                 # LISTADO DE PELÍCULAS (CON IMAGEN Y CATEGORÍA)
    │   ├── create.php                # FORMULARIO CREAR (SELECT CATEGORÍA + CHECKBOXES ETIQUETAS + IMAGEN)
    │   └── edit.php                  # FORMULARIO EDITAR (PRECARGADO CON RELACIONES E IMAGEN)
    ├── etiquetas/
    │   ├── index.php                 # LISTADO DE ETIQUETAS
    │   ├── create.php                # FORMULARIO CREAR ETIQUETA
    │   └── edit.php                  # FORMULARIO EDITAR ETIQUETA
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

---

> [!TIP]
> ***TODO EL CÓDIGO DEL PROYECTO ESTÁ COMENTADO LÍNEA POR LÍNEA EN MAYÚSCULAS PARA FACILITAR EL APRENDIZAJE***
