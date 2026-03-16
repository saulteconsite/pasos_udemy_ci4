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
                        <!-- MOSTRAMOS EL NOMBRE COMO BADGE DE BOOTSTRAP (ESTILO TAG) -->
                        <td><span class="badge bg-secondary"><?= esc($etiqueta['nombre']) ?></span></td>
                        <!-- MOSTRAMOS LA FECHA DE CREACIÓN -->
                        <td><?= $etiqueta['created_at'] ?></td>
                        <td>
                            <!-- BOTÓN PARA EDITAR: LLEVA AL FORMULARIO DE EDICIÓN -->
                            <a href="<?= base_url('/etiquetas/edit/' . $etiqueta['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <!-- FORMULARIO PARA ELIMINAR: USA POST POR SEGURIDAD -->
                            <form action="<?= base_url('/etiquetas/delete/' . $etiqueta['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta etiqueta?')">
                                <!-- TOKEN CSRF PARA PROTEGER CONTRA ATAQUES -->
                                <?= csrf_field() ?>
                                <!-- BOTÓN ROJO DE ELIMINAR -->
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- SI NO HAY ETIQUETAS, MOSTRAMOS UN MENSAJE -->
                <tr>
                    <td colspan="4" class="text-center">No hay etiquetas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
