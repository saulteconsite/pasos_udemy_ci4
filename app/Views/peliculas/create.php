<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- TÍTULO DE LA PÁGINA -->
<h1>Crear Película</h1>
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
<!-- enctype="multipart/form-data" ES OBLIGATORIO PARA SUBIR ARCHIVOS -->
<form action="<?= base_url('/peliculas/store') ?>" method="POST" enctype="multipart/form-data">
    <!-- TOKEN CSRF PARA PROTEGER CONTRA ATAQUES DE FALSIFICACIÓN DE PETICIONES -->
    <?= csrf_field() ?>

    <!-- CAMPO DE TEXTO PARA EL TÍTULO DE LA PELÍCULA -->
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <!-- old('titulo') MANTIENE EL VALOR SI HAY ERROR DE VALIDACIÓN -->
        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= old('titulo') ?>" required>
    </div>

    <!-- CAMPO DE TEXTO LARGO PARA LA DESCRIPCIÓN -->
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?= old('descripcion') ?></textarea>
    </div>

    <!-- SELECT DESPLEGABLE PARA ELEGIR LA CATEGORÍA (RELACIÓN 1:N) -->
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoría</label>
        <select class="form-select" id="categoria_id" name="categoria_id">
            <!-- OPCIÓN POR DEFECTO: SIN CATEGORÍA -->
            <option value="">-- Seleccionar categoría --</option>
            <!-- RECORREMOS TODAS LAS CATEGORÍAS Y LAS MOSTRAMOS COMO OPCIONES -->
            <?php foreach ($categorias as $categoria): ?>
                <!-- selected: SI old('categoria_id') COINCIDE CON ESTA CATEGORÍA, LA PRESELECCIONAMOS -->
                <option value="<?= $categoria['id'] ?>" <?= old('categoria_id') == $categoria['id'] ? 'selected' : '' ?>>
                    <?= esc($categoria['titulo']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- CHECKBOXES PARA ASIGNAR ETIQUETAS (RELACIÓN N:M) -->
    <div class="mb-3">
        <label class="form-label">Etiquetas</label>
        <div class="row">
            <!-- RECORREMOS TODAS LAS ETIQUETAS Y LAS MOSTRAMOS COMO CHECKBOXES -->
            <?php foreach ($etiquetas as $etiqueta): ?>
                <div class="col-md-3 col-6">
                    <div class="form-check">
                        <!-- CHECKBOX: name="etiquetas[]" ENVÍA UN ARRAY DE IDs AL CONTROLADOR -->
                        <input class="form-check-input" type="checkbox" name="etiquetas[]" value="<?= $etiqueta['id'] ?>" id="etiqueta_<?= $etiqueta['id'] ?>">
                        <!-- LABEL DEL CHECKBOX CON EL NOMBRE DE LA ETIQUETA -->
                        <label class="form-check-label" for="etiqueta_<?= $etiqueta['id'] ?>">
                            <?= esc($etiqueta['nombre']) ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CAMPO PARA SUBIR IMAGEN (SECCIÓN 16: CARGA DE ARCHIVOS) -->
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen (opcional, máx. 2MB)</label>
        <!-- accept="image/*" SOLO PERMITE SELECCIONAR ARCHIVOS DE IMAGEN -->
        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        <!-- TEXTO DE AYUDA DEBAJO DEL CAMPO -->
        <div class="form-text">FORMATOS PERMITIDOS: JPG, JPEG, PNG, GIF. TAMAÑO MÁXIMO: 2MB</div>
    </div>

    <!-- BOTÓN PARA VOLVER AL LISTADO -->
    <a href="<?= base_url('/peliculas') ?>" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
    <!-- BOTÓN PARA ENVIAR EL FORMULARIO Y GUARDAR -->
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Guardar
    </button>
</form>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
