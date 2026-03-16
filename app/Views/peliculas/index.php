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

<!-- =============================================
     SECCIÓN 18: BARRA DE FILTROS PARA EL LISTADO
     ============================================= -->
<!-- FORMULARIO DE FILTROS: USA GET PARA QUE LOS FILTROS APAREZCAN EN LA URL -->
<!-- ASÍ SE PUEDEN COMPARTIR ENLACES CON FILTROS APLICADOS Y FUNCIONA CON PAGINACIÓN -->
<form action="<?= base_url('/peliculas') ?>" method="GET" class="card card-body bg-light mb-4">
    <div class="row g-3 align-items-end">

        <!-- CAMPO DE BÚSQUEDA POR TEXTO (TÍTULO O DESCRIPCIÓN) -->
        <div class="col-md-3">
            <label for="busqueda" class="form-label fw-bold">
                <i class="fa fa-search"></i> Buscar
            </label>
            <!-- EL VALUE MUESTRA EL FILTRO ACTUAL PARA QUE NO SE PIERDA AL PAGINAR -->
            <!-- esc() ESCAPA EL VALOR PARA PREVENIR ATAQUES XSS -->
            <input type="text" name="busqueda" id="busqueda" class="form-control"
                   placeholder="Título o descripción..."
                   value="<?= esc($filtros['busqueda'] ?? '') ?>">
        </div>

        <!-- SELECT PARA FILTRAR POR CATEGORÍA -->
        <div class="col-md-3">
            <label for="categoria_id" class="form-label fw-bold">
                <i class="fa fa-folder"></i> Categoría
            </label>
            <select name="categoria_id" id="categoria_id" class="form-select">
                <!-- OPCIÓN POR DEFECTO: MUESTRA TODAS LAS CATEGORÍAS (SIN FILTRAR) -->
                <option value="">-- Todas --</option>
                <!-- RECORREMOS LAS CATEGORÍAS DISPONIBLES -->
                <?php foreach ($categorias as $cat): ?>
                    <!-- selected: SI EL ID COINCIDE CON EL FILTRO ACTUAL, SE MARCA COMO SELECCIONADO -->
                    <option value="<?= $cat['id'] ?>"
                        <?= ($filtros['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                        <?= esc($cat['titulo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- SELECT PARA FILTRAR POR ETIQUETA -->
        <div class="col-md-3">
            <label for="etiqueta_id" class="form-label fw-bold">
                <i class="fa fa-tag"></i> Etiqueta
            </label>
            <select name="etiqueta_id" id="etiqueta_id" class="form-select">
                <!-- OPCIÓN POR DEFECTO: MUESTRA TODAS LAS ETIQUETAS (SIN FILTRAR) -->
                <option value="">-- Todas --</option>
                <!-- RECORREMOS LAS ETIQUETAS DISPONIBLES -->
                <?php foreach ($etiquetas as $etq): ?>
                    <!-- selected: SI EL ID COINCIDE CON EL FILTRO ACTUAL -->
                    <option value="<?= $etq['id'] ?>"
                        <?= ($filtros['etiqueta_id'] ?? '') == $etq['id'] ? 'selected' : '' ?>>
                        <?= esc($etq['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- BOTONES DE ACCIÓN: FILTRAR Y LIMPIAR FILTROS -->
        <div class="col-md-3">
            <!-- BOTÓN SUBMIT: ENVÍA EL FORMULARIO CON LOS FILTROS POR GET -->
            <button type="submit" class="btn btn-dark w-100 mb-2">
                <i class="fa fa-filter"></i> Filtrar
            </button>
            <!-- ENLACE PARA LIMPIAR TODOS LOS FILTROS (VUELVE A LA URL SIN PARÁMETROS) -->
            <a href="<?= base_url('/peliculas') ?>" class="btn btn-outline-secondary w-100">
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
                <!-- COLUMNA PARA LA IMAGEN DE LA PELÍCULA -->
                <th>Imagen</th>
                <th>Título</th>
                <!-- COLUMNA PARA LA CATEGORÍA ASIGNADA (RELACIÓN 1:N) -->
                <th>Categoría</th>
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
                        <!-- MOSTRAMOS LA IMAGEN EN MINIATURA O UN PLACEHOLDER SI NO TIENE -->
                        <td>
                            <?php if (!empty($pelicula['imagen'])): ?>
                                <img src="<?= base_url('uploads/peliculas/' . $pelicula['imagen']) ?>" alt="Imagen" class="img-thumbnail" style="max-height: 60px;">
                            <?php else: ?>
                                <span class="text-muted"><i class="fa fa-image"></i></span>
                            <?php endif; ?>
                        </td>
                        <!-- MOSTRAMOS EL TÍTULO ESCAPADO PARA EVITAR XSS -->
                        <td><?= esc($pelicula['titulo']) ?></td>
                        <!-- MOSTRAMOS EL NOMBRE DE LA CATEGORÍA O "Sin categoría" -->
                        <td>
                            <?php if (!empty($pelicula['categoria_nombre'])): ?>
                                <span class="badge bg-primary"><?= esc($pelicula['categoria_nombre']) ?></span>
                            <?php else: ?>
                                <span class="text-muted">Sin categoría</span>
                            <?php endif; ?>
                        </td>
                        <!-- MOSTRAMOS LA DESCRIPCIÓN RECORTADA A 60 CARACTERES -->
                        <td><?= character_limiter(esc($pelicula['descripcion'] ?? ''), 60) ?></td>
                        <!-- MOSTRAMOS LA FECHA DE CREACIÓN -->
                        <td><?= $pelicula['created_at'] ?></td>
                        <td>
                            <!-- BOTÓN PARA EDITAR -->
                            <a href="<?= base_url('/peliculas/edit/' . $pelicula['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <!-- FORMULARIO PARA ELIMINAR -->
                            <form action="<?= base_url('/peliculas/delete/' . $pelicula['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta película?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- SI NO HAY PELÍCULAS QUE COINCIDAN CON LOS FILTROS -->
                <tr>
                    <td colspan="7" class="text-center">No se encontraron películas con los filtros aplicados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- =============================================
     SECCIÓN 18: ENLACES DE PAGINACIÓN
     ============================================= -->
<!-- VERIFICAMOS QUE EL PAGER EXISTA Y TENGA MÁS DE UNA PÁGINA -->
<?php if (isset($pager)): ?>
    <div class="d-flex justify-content-center mt-3">
        <!-- links() GENERA LOS ENLACES DE PAGINACIÓN AUTOMÁTICAMENTE -->
        <!-- 'default_full' ES LA PLANTILLA DE BOOTSTRAP QUE USA CODEIGNITER -->
        <!-- IMPORTANT: LOS FILTROS SE MANTIENEN EN LOS ENLACES PORQUE CODEIGNITER -->
        <!-- AÑADE AUTOMÁTICAMENTE LOS PARÁMETROS GET ACTUALES A LAS URLs DE PAGINACIÓN -->
        <!-- PERO DEBEMOS PASAR only PARA QUE SOLO USE EL SEGMENTO 'page' -->
        <?= $pager->links('default', 'default_full') ?>
    </div>
<?php endif; ?>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
