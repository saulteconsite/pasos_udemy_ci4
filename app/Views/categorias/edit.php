<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- TÍTULO DE LA PÁGINA -->
<h1>Editar Categoría</h1>
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

<!-- FORMULARIO QUE ENVÍA LOS DATOS POR POST A LA RUTA UPDATE CON EL ID -->
<form action="<?= base_url('/categorias/update/' . $categoria['id']) ?>" method="POST">
    <!-- TOKEN CSRF PARA PROTEGER CONTRA ATAQUES -->
    <?= csrf_field() ?>

    <!-- CAMPO DE TEXTO PARA EL TÍTULO, PRECARGADO CON EL VALOR ACTUAL -->
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <!-- old() TIENE PRIORIDAD; SI NO HAY, USA EL VALOR DE LA BD -->
        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= old('titulo', esc($categoria['titulo'])) ?>" required>
    </div>

    <!-- BOTÓN PARA VOLVER AL LISTADO -->
    <a href="<?= base_url('/categorias') ?>" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
    <!-- BOTÓN PARA ENVIAR EL FORMULARIO Y ACTUALIZAR -->
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Actualizar
    </button>
</form>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
