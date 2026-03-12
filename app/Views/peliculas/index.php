<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- CABECERA CON TÍTULO Y BOTÓN DE CREAR NUEVA PELÍCULA -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Películas</h1>
    <!-- BOTÓN QUE LLEVA AL FORMULARIO DE CREACIÓN -->
    <a href="<?= base_url('/peliculas/create') ?>" class="btn btn-primary">
        <i class="fa fa-plus"></i> Nueva Película
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
                <th>Título</th>
                <th>Descripción</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- SI HAY PELÍCULAS, LAS RECORREMOS CON UN FOREACH -->
            <?php if (!empty($peliculas)): ?>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        <!-- MOSTRAMOS EL ID DE LA PELÍCULA -->
                        <td><?= $pelicula['id'] ?></td>
                        <!-- MOSTRAMOS EL TÍTULO ESCAPADO PARA EVITAR XSS -->
                        <td><?= esc($pelicula['titulo']) ?></td>
                        <!-- MOSTRAMOS LA DESCRIPCIÓN RECORTADA A 80 CARACTERES (ESCAPAMOS PRIMERO, LUEGO TRUNCAMOS) -->
                        <td><?= character_limiter(esc($pelicula['descripcion'] ?? ''), 80) ?></td>
                        <!-- MOSTRAMOS LA FECHA DE CREACIÓN -->
                        <td><?= $pelicula['created_at'] ?></td>
                        <td>
                            <!-- BOTÓN PARA EDITAR: LLEVA AL FORMULARIO DE EDICIÓN -->
                            <a href="<?= base_url('/peliculas/edit/' . $pelicula['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <!-- FORMULARIO PARA ELIMINAR: USA POST POR SEGURIDAD -->
                            <form action="<?= base_url('/peliculas/delete/' . $pelicula['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta película?')">
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
                <!-- SI NO HAY PELÍCULAS, MOSTRAMOS UN MENSAJE -->
                <tr>
                    <td colspan="5" class="text-center">No hay películas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
