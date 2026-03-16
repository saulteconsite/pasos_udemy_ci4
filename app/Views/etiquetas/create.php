<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- TÍTULO DE LA PÁGINA -->
<h1>Crear Etiqueta</h1>
<hr>

<!-- SI HAY ERRORES DE VALIDACIÓN EN LA SESIÓN FLASH, LOS MOSTRAMOS -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <!-- RECORREMOS CADA ERROR Y LO MOSTRAMOS EN UNA LISTA -->
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- FORMULARIO QUE ENVÍA LOS DATOS POR POST A LA RUTA STORE -->
<form action="<?= base_url('/etiquetas/store') ?>" method="POST">
    <!-- TOKEN CSRF PARA PROTEGER CONTRA ATAQUES DE FALSIFICACIÓN DE PETICIONES -->
    <?= csrf_field() ?>

    <!-- CAMPO DE TEXTO PARA EL NOMBRE DE LA ETIQUETA -->
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <!-- old('nombre') MANTIENE EL VALOR SI HAY ERROR DE VALIDACIÓN -->
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="Ej: Clásico, Premiada, Taquillera..." required>
    </div>

    <!-- BOTÓN PARA VOLVER AL LISTADO -->
    <a href="<?= base_url('/etiquetas') ?>" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
    <!-- BOTÓN PARA ENVIAR EL FORMULARIO Y GUARDAR -->
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>
</form>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
