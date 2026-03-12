# Proyecto CodeIgniter 4 - Curso Udemy

Proyecto de aprendizaje de CodeIgniter 4 con DDEV en WSL. Incluye CRUDs completos de **Películas** y **Categorías** con Bootstrap 5.

---

## Requisitos previos

- Windows con WSL2 habilitado
- DDEV instalado dentro de WSL
- Docker Desktop o Docker CE en WSL

---

## 1. Estructura del proyecto

```
app/
├── Config/
│   └── Routes.php                  # RUTAS CRUD DE PELÍCULAS Y CATEGORÍAS
├── Controllers/
│   ├── Pelicula.php                # CONTROLADOR CRUD PELÍCULAS
│   └── Categoria.php               # CONTROLADOR CRUD CATEGORÍAS
├── Database/
│   ├── Migrations/
│   │   ├── 2026-03-12-113339_Peliculas.php   # MIGRACIÓN TABLA PELICULAS
│   │   └── 2026-03-12-114415_Categorias.php  # MIGRACIÓN TABLA CATEGORIAS
│   └── Seeds/
│       ├── PeliculaSeeder.php      # DATOS DE PRUEBA: 5 PELÍCULAS
│       └── CategoriaSeeder.php     # DATOS DE PRUEBA: 10 CATEGORÍAS
├── Models/
│   ├── PeliculaModel.php           # MODELO PELÍCULAS
│   └── CategoriaModel.php          # MODELO CATEGORÍAS
└── Views/
    ├── layout/
    │   └── main.php                # LAYOUT PRINCIPAL CON BOOTSTRAP 5
    ├── peliculas/
    │   ├── index.php               # LISTADO DE PELÍCULAS
    │   ├── create.php              # FORMULARIO CREAR PELÍCULA
    │   └── edit.php                # FORMULARIO EDITAR PELÍCULA
    └── categorias/
        ├── index.php               # LISTADO DE CATEGORÍAS
        ├── create.php              # FORMULARIO CREAR CATEGORÍA
        └── edit.php                # FORMULARIO EDITAR CATEGORÍA
```

---

## 2. Configuración inicial del entorno

### 2.1 Arrancar WSL y DDEV

Si WSL se queda colgado o no responde (error `Wsl/Service/0x8007274c`), hay que reiniciarlo:

```powershell
# APAGAR WSL COMPLETAMENTE DESDE POWERSHELL
wsl --shutdown

# VERIFICAR QUE WSL ESTÁ DETENIDO
wsl --list --verbose

# ARRANCAR WSL DE NUEVO (SE INICIA AUTOMÁTICAMENTE AL EJECUTAR UN COMANDO)
wsl -d DDEV -- echo "WSL OK"
```

### 2.2 Arrancar DDEV en el proyecto

```bash
# ENTRAR AL DIRECTORIO DEL PROYECTO DENTRO DE WSL
cd /home/ddev/www/udemy

# SI LOS CONTENEDORES ESTÁN CAÍDOS O CORRUPTOS, LIMPIAR Y ARRANCAR
ddev poweroff
ddev start
```

### 2.3 Archivo .env

El archivo `.env` en la raíz del proyecto contiene la configuración de base de datos para DDEV:

```
CI_ENVIRONMENT = development
app.baseURL = 'https://UDEMY.ddev.site'
database.default.hostname = db
database.default.database = db
database.default.username = db
database.default.password = db
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

## 3. Base de datos - Migraciones

### 3.1 Crear las migraciones con Spark

```bash
# CREAR MIGRACIÓN PARA LA TABLA PELÍCULAS
ddev exec php spark make:migration Peliculas

# CREAR MIGRACIÓN PARA LA TABLA CATEGORÍAS
ddev exec php spark make:migration Categorias
```

### 3.2 Tabla `peliculas`

Columnas: `id` (INT, PK, autoincrement), `titulo` (VARCHAR 150), `descripcion` (TEXT, nullable), `created_at` (DATETIME), `updated_at` (DATETIME).

### 3.3 Tabla `categorias`

Columnas: `id` (INT, PK, autoincrement), `titulo` (VARCHAR 100), `created_at` (DATETIME), `updated_at` (DATETIME).

### 3.4 Ejecutar las migraciones

```bash
# EJECUTAR TODAS LAS MIGRACIONES PENDIENTES
ddev exec php spark migrate

# VERIFICAR EL ESTADO DE LAS MIGRACIONES
ddev exec php spark migrate:status
```

### 3.5 Revertir migraciones (si es necesario)

```bash
# REVERTIR TODAS LAS MIGRACIONES
ddev exec php spark migrate:rollback -a

# VOLVER A EJECUTAR
ddev exec php spark migrate
```

---

## 4. Modelos

Se crearon dos modelos que extienden `CodeIgniter\Model`:

- **PeliculaModel** → tabla `peliculas`, campos permitidos: `titulo`, `descripcion`, timestamps automáticos.
- **CategoriaModel** → tabla `categorias`, campos permitidos: `titulo`, timestamps automáticos.

---

## 5. Controladores CRUD

Cada controlador tiene 6 métodos:

| Método     | Función                                      |
|------------|----------------------------------------------|
| `index()`  | Listar todos los registros                   |
| `create()` | Mostrar formulario de creación               |
| `store()`  | Validar y guardar nuevo registro en la BD    |
| `edit($id)`| Mostrar formulario de edición con datos      |
| `update($id)` | Validar y actualizar registro en la BD   |
| `delete($id)` | Eliminar registro de la BD               |

Ambos controladores incluyen:
- Validación de campos con reglas (`required`, `min_length`, `max_length`)
- Redirecciones con mensajes flash de éxito
- Manejo de errores 404 si no se encuentra el registro

---

## 6. Rutas

Definidas en `app/Config/Routes.php`:

| Método | Ruta                        | Acción                  |
|--------|-----------------------------|-------------------------|
| GET    | `/peliculas`                | Listar películas        |
| GET    | `/peliculas/create`         | Formulario crear        |
| POST   | `/peliculas/store`          | Guardar nueva           |
| GET    | `/peliculas/edit/(:num)`    | Formulario editar       |
| POST   | `/peliculas/update/(:num)`  | Actualizar existente    |
| POST   | `/peliculas/delete/(:num)`  | Eliminar                |
| GET    | `/categorias`               | Listar categorías       |
| GET    | `/categorias/create`        | Formulario crear        |
| POST   | `/categorias/store`         | Guardar nueva           |
| GET    | `/categorias/edit/(:num)`   | Formulario editar       |
| POST   | `/categorias/update/(:num)` | Actualizar existente    |
| POST   | `/categorias/delete/(:num)` | Eliminar                |

Para ver todas las rutas registradas:

```bash
ddev exec php spark routes
```

---

## 7. Vistas con Bootstrap 5

### 7.1 Layout principal (`layout/main.php`)

- Carga Bootstrap 5 y Font Awesome desde CDN
- Barra de navegación con enlaces a Películas y Categorías
- Sistema de mensajes flash (alertas verdes de éxito)
- Usa `renderSection('contenido')` para inyectar el contenido de cada vista hija

### 7.2 Vistas hijas

Cada vista extiende el layout con `$this->extend('layout/main')` y define su contenido dentro de `$this->section('contenido')`.

- **index.php** → Tabla con listado, botones Editar y Eliminar
- **create.php** → Formulario con validación, token CSRF, función `old()` para mantener datos
- **edit.php** → Formulario precargado con datos actuales de la BD

---

## 8. Seeders - Datos de prueba

### 8.1 Crear los seeders

```bash
# CREAR SEEDER PARA PELÍCULAS
ddev exec php spark make:seeder PeliculaSeeder

# CREAR SEEDER PARA CATEGORÍAS
ddev exec php spark make:seeder CategoriaSeeder
```

### 8.2 Ejecutar los seeders

```bash
# INSERTAR 5 PELÍCULAS DE PRUEBA
ddev exec php spark db:seed PeliculaSeeder

# INSERTAR 10 CATEGORÍAS DE PRUEBA
ddev exec php spark db:seed CategoriaSeeder
```

### 8.3 Datos insertados

**Películas:** El Padrino, Pulp Fiction, Interestelar, Matrix, Coco.

**Categorías:** Acción, Comedia, Drama, Terror, Ciencia Ficción, Romance, Animación, Suspenso, Aventura, Documental.

---

## 9. Acceder a la aplicación

```bash
# ABRIR EN EL NAVEGADOR DESDE WSL
ddev launch
```

O acceder directamente a:

- **Películas:** https://udemy.ddev.site/peliculas
- **Categorías:** https://udemy.ddev.site/categorias

---

## 10. Comandos útiles de referencia

```bash
# ARRANCAR EL PROYECTO
ddev start

# PARAR EL PROYECTO
ddev stop

# APAGAR TODO DDEV (TODOS LOS PROYECTOS)
ddev poweroff

# ENTRAR AL CONTENEDOR WEB POR SSH
ddev ssh

# EJECUTAR COMANDOS PHP SPARK DENTRO DEL CONTENEDOR
ddev exec php spark migrate
ddev exec php spark migrate:status
ddev exec php spark migrate:rollback -a
ddev exec php spark db:seed NombreDelSeeder
ddev exec php spark routes

# ACCEDER A MYSQL DIRECTAMENTE
ddev mysql

# VER LOGS DEL PROYECTO
ddev logs

# ABRIR EL PROYECTO EN EL NAVEGADOR
ddev launch
```

---

## 11. Tecnologías utilizadas

- **CodeIgniter 4.7.0** — Framework PHP
- **PHP 8.4** — Lenguaje del servidor
- **MariaDB 11.8** — Base de datos
- **Bootstrap 5.3.3** — Framework CSS para la interfaz
- **Font Awesome 6.5.1** — Íconos
- **DDEV v1.25.1** — Entorno de desarrollo local
- **WSL2** — Subsistema Windows para Linux
- **Apache** — Servidor web (apache-fpm)
