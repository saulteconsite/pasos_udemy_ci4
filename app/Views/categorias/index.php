<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- CABECERA CON TÍTULO Y BOTÓN DE CREAR NUEVA CATEGORÍA -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Categorías</h1>
    <!-- BOTÓN QUE LLEVA AL FORMULARIO DE CREACIÓN -->
    <a href="<?= base_url('/categorias/create') ?>" class="btn btn-primary">
        <i class="fa fa-plus"></i> Nueva Categoría
    </a>
</div>

<!-- =============================================
     SECCIÓN 18: BARRA DE BÚSQUEDA PARA CATEGORÍAS
     ============================================= -->
<!-- FORMULARIO DE BÚSQUEDA: USA GET PARA QUE EL FILTRO APAREZCA EN LA URL -->
<form action="<?= base_url('/categorias') ?>" method="GET" class="card card-body bg-light mb-4">
    <div class="row g-3 align-items-end">
        <!-- CAMPO DE BÚSQUEDA POR TEXTO (TÍTULO) -->
        <div class="col-md-8">
            <label for="busqueda" class="form-label fw-bold">
                <i class="fa fa-search"></i> Buscar categoría
            </label>
            <!-- EL VALUE MUESTRA EL FILTRO ACTUAL PARA QUE NO SE PIERDA AL PAGINAR -->
            <input type="text" name="busqueda" id="busqueda" class="form-control"
                   placeholder="Escribe el título..."
                   value="<?= esc($busqueda ?? '') ?>">
        </div>
        <!-- BOTONES DE ACCIÓN -->
        <div class="col-md-4">
            <button type="submit" class="btn btn-dark me-2">
                <i class="fa fa-filter"></i> Buscar
            </button>
            <!-- ENLACE PARA LIMPIAR EL FILTRO -->
            <a href="<?= base_url('/categorias') ?>" class="btn btn-outline-secondary">
                <i class="fa fa-times"></i> Limpiar
            </a>
        </div>
    </div>
</form>

<!-- TABLA RESPONSIVE PARA QUE SE VEA BIEN EN MÓVILES -->
<div class="table-responsive">
    <!-- TABLA CON ESTILOS DE BOOTSTRAP: BORDES, RAYAS ALTERNAS Y EFECTO HOVER -->
    <table class="table table-bordered table-striped table-hover">
        <!-- CABECERA DE LA TABLA CON FONDO OSCURO -->
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- SI HAY CATEGORÍAS, LAS RECORREMOS CON UN FOREACH -->
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <!-- MOSTRAMOS EL ID DE LA CATEGORÍA -->
                        <td><?= $categoria['id'] ?></td>
                        <!-- MOSTRAMOS EL TÍTULO ESCAPADO PARA EVITAR XSS -->
                        <td><?= esc($categoria['titulo']) ?></td>
                        <!-- MOSTRAMOS LA FECHA DE CREACIÓN -->
                        <td><?= $categoria['created_at'] ?></td>
                        <td>
                            <!-- BOTÓN PARA EDITAR -->
                            <a href="<?= base_url('/categorias/edit/' . $categoria['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <!-- FORMULARIO PARA ELIMINAR -->
                            <form action="<?= base_url('/categorias/delete/' . $categoria['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- SI NO HAY RESULTADOS -->
                <tr>
                    <td colspan="4" class="text-center">No se encontraron categorías</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- =============================================
     SECCIÓN 18: ENLACES DE PAGINACIÓN PARA CATEGORÍAS
     ============================================= -->
<?php if (isset($pager)): ?>
    <div class="d-flex justify-content-center mt-3">
        <!-- links() GENERA LOS ENLACES DE PAGINACIÓN CON ESTILO BOOTSTRAP -->
        <?= $pager->links('default', 'default_full') ?>
    </div>
<?php endif; ?>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
