<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- CABECERA CON TÍTULO Y BOTÓN DE CREAR NUEVA ETIQUETA -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Etiquetas</h1>
    <!-- BOTÓN QUE LLEVA AL FORMULARIO DE CREACIÓN -->
    <a href="<?= base_url('/etiquetas/create') ?>" class="btn btn-primary">
        <i class="fa fa-plus"></i> Nueva Etiqueta
    </a>
</div>

<!-- =============================================
     SECCIÓN 18: BARRA DE BÚSQUEDA PARA ETIQUETAS
     ============================================= -->
<!-- FORMULARIO DE BÚSQUEDA: USA GET PARA QUE EL FILTRO APAREZCA EN LA URL -->
<form action="<?= base_url('/etiquetas') ?>" method="GET" class="card card-body bg-light mb-4">
    <div class="row g-3 align-items-end">
        <!-- CAMPO DE BÚSQUEDA POR TEXTO (NOMBRE) -->
        <div class="col-md-8">
            <label for="busqueda" class="form-label fw-bold">
                <i class="fa fa-search"></i> Buscar etiqueta
            </label>
            <!-- EL VALUE MUESTRA EL FILTRO ACTUAL PARA QUE NO SE PIERDA AL PAGINAR -->
            <input type="text" name="busqueda" id="busqueda" class="form-control"
                   placeholder="Escribe el nombre..."
                   value="<?= esc($busqueda ?? '') ?>">
        </div>
        <!-- BOTONES DE ACCIÓN -->
        <div class="col-md-4">
            <button type="submit" class="btn btn-dark me-2">
                <i class="fa fa-filter"></i> Buscar
            </button>
            <!-- ENLACE PARA LIMPIAR EL FILTRO -->
            <a href="<?= base_url('/etiquetas') ?>" class="btn btn-outline-secondary">
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
                <th>Nombre</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- SI HAY ETIQUETAS, LAS RECORREMOS CON UN FOREACH -->
            <?php if (!empty($etiquetas)): ?>
                <?php foreach ($etiquetas as $etiqueta): ?>
                    <tr>
                        <!-- MOSTRAMOS EL ID DE LA ETIQUETA -->
                        <td><?= $etiqueta['id'] ?></td>
                        <!-- MOSTRAMOS EL NOMBRE COMO BADGE -->
                        <td><span class="badge bg-secondary"><?= esc($etiqueta['nombre']) ?></span></td>
                        <!-- MOSTRAMOS LA FECHA DE CREACIÓN -->
                        <td><?= $etiqueta['created_at'] ?></td>
                        <td>
                            <!-- BOTÓN PARA EDITAR -->
                            <a href="<?= base_url('/etiquetas/edit/' . $etiqueta['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <!-- FORMULARIO PARA ELIMINAR -->
                            <form action="<?= base_url('/etiquetas/delete/' . $etiqueta['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta etiqueta?')">
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
                    <td colspan="4" class="text-center">No se encontraron etiquetas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- =============================================
     SECCIÓN 18: ENLACES DE PAGINACIÓN PARA ETIQUETAS
     ============================================= -->
<?php if (isset($pager)): ?>
    <div class="d-flex justify-content-center mt-3">
        <!-- links() GENERA LOS ENLACES DE PAGINACIÓN CON ESTILO BOOTSTRAP -->
        <?= $pager->links('default', 'default_full') ?>
    </div>
<?php endif; ?>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
