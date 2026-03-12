<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TÍTULO DE LA PÁGINA: USA LA VARIABLE $titulo O UN VALOR POR DEFECTO -->
    <title><?= $titulo ?? 'CodeIgniter 4 - CRUD' ?></title>
    <!-- CARGAMOS BOOTSTRAP 5 DESDE CDN PARA LOS ESTILOS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CARGAMOS FONT AWESOME DESDE CDN PARA LOS ÍCONOS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- BARRA DE NAVEGACIÓN SUPERIOR CON FONDO OSCURO -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- LOGO/NOMBRE DE LA APP QUE LLEVA AL INICIO -->
        <a class="navbar-brand" href="<?= base_url('/') ?>">CI4 Udemy</a>
        <!-- BOTÓN HAMBURGUESA PARA MÓVILES -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- ENLACES DE NAVEGACIÓN -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- ENLACE A LA SECCIÓN DE PELÍCULAS -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/peliculas') ?>">Películas</a>
                </li>
                <!-- ENLACE A LA SECCIÓN DE CATEGORÍAS -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/categorias') ?>">Categorías</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENEDOR PRINCIPAL CON MARGEN SUPERIOR -->
<div class="container mt-4">
    <!-- SI EXISTE UN MENSAJE FLASH EN LA SESIÓN, LO MOSTRAMOS COMO ALERTA VERDE -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <!-- MOSTRAMOS EL TEXTO DEL MENSAJE -->
            <?= session()->getFlashdata('mensaje') ?>
            <!-- BOTÓN X PARA CERRAR LA ALERTA -->
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- AQUÍ SE RENDERIZA EL CONTENIDO DE CADA VISTA HIJA -->
    <?= $this->renderSection('contenido') ?>
</div>

<!-- CARGAMOS EL JAVASCRIPT DE BOOTSTRAP 5 DESDE CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
