<?php

// ESPACIO DE NOMBRES PARA LOS COMANDOS PERSONALIZADOS DE LA APP
namespace App\Commands;

// IMPORTAMOS LA CLASE BASE PARA COMANDOS SPARK DE CODEIGNITER
use CodeIgniter\CLI\BaseCommand;
// IMPORTAMOS LA CLASE CLI PARA INTERACTUAR CON LA TERMINAL (COLORES, PROMPTS, ETC.)
use CodeIgniter\CLI\CLI;

// COMANDO PERSONALIZADO PARA GENERAR UN CRUD COMPLETO AUTOMÁTICAMENTE
// SE EJECUTA CON: php spark crud:generar NombreEntidad
// GENERA: CONTROLADOR + 3 VISTAS (INDEX, CREATE, EDIT)
// EL CONTROLADOR HEREDA DE CrudController, POR LO QUE SOLO NECESITA CONFIGURACIÓN
class GenerarCrud extends BaseCommand
{
    // GRUPO AL QUE PERTENECE EL COMANDO (SE MUESTRA AL EJECUTAR php spark)
    protected $group       = 'App';

    // NOMBRE DEL COMANDO (COMO SE EJECUTA DESDE LA TERMINAL)
    protected $name        = 'crud:generar';

    // DESCRIPCIÓN DEL COMANDO (SE MUESTRA EN LA AYUDA)
    protected $description = 'GENERA UN CRUD COMPLETO (CONTROLADOR + VISTAS) PARA UNA ENTIDAD';

    // INSTRUCCIONES DE USO DEL COMANDO
    protected $usage       = 'crud:generar [NombreEntidad]';

    // MÉTODO RUN: SE EJECUTA CUANDO EL USUARIO LANZA EL COMANDO
    // $params CONTIENE LOS ARGUMENTOS PASADOS AL COMANDO
    public function run(array $params)
    {
        // OBTENEMOS EL NOMBRE DE LA ENTIDAD DEL PRIMER ARGUMENTO
        // SI NO SE PASÓ ARGUMENTO, PREGUNTAMOS AL USUARIO CON CLI::prompt()
        $nombre = $params[0] ?? CLI::prompt('NOMBRE DE LA ENTIDAD (EJ: Producto)');

        // SI EL NOMBRE ESTÁ VACÍO, MOSTRAMOS ERROR Y SALIMOS
        if (empty($nombre)) {
            // CLI::error() MUESTRA TEXTO EN ROJO EN LA TERMINAL
            CLI::error('DEBES ESPECIFICAR UN NOMBRE DE ENTIDAD.');
            return;
        }

        // GENERAMOS LAS VARIANTES DEL NOMBRE PARA USARLAS EN LOS ARCHIVOS
        $singular    = ucfirst($nombre);
        $plural      = ucfirst($nombre) . 's';
        $minuscula   = strtolower($nombre);
        $minPlural   = strtolower($nombre) . 's';
        $modelClass  = ucfirst($nombre) . 'Model';

        // MOSTRAMOS UN MENSAJE DE INICIO EN COLOR VERDE
        CLI::write("GENERANDO CRUD PARA: {$singular}", 'green');
        CLI::newLine();

        // =============================================
        // 1. GENERAR EL CONTROLADOR
        // =============================================
        $controladorContenido = $this->generarControlador(
            $singular, $plural, $minuscula, $minPlural, $modelClass
        );
        $rutaControlador = APPPATH . 'Controllers/' . $singular . '.php';
        file_put_contents($rutaControlador, $controladorContenido);
        CLI::write("  CONTROLADOR CREADO: {$rutaControlador}", 'yellow');

        // =============================================
        // 2. CREAR EL DIRECTORIO DE VISTAS
        // =============================================
        $dirVistas = APPPATH . 'Views/' . $minPlural;
        if (!is_dir($dirVistas)) {
            mkdir($dirVistas, 0755, true);
        }

        // =============================================
        // 3. GENERAR VISTA INDEX (LISTADO)
        // =============================================
        $indexContenido = $this->generarVistaIndex($singular, $plural, $minPlural);
        file_put_contents($dirVistas . '/index.php', $indexContenido);
        CLI::write("  VISTA INDEX CREADA: {$dirVistas}/index.php", 'yellow');

        // =============================================
        // 4. GENERAR VISTA CREATE (FORMULARIO DE CREACIÓN)
        // =============================================
        $createContenido = $this->generarVistaCreate($singular, $minPlural);
        file_put_contents($dirVistas . '/create.php', $createContenido);
        CLI::write("  VISTA CREATE CREADA: {$dirVistas}/create.php", 'yellow');

        // =============================================
        // 5. GENERAR VISTA EDIT (FORMULARIO DE EDICIÓN)
        // =============================================
        $editContenido = $this->generarVistaEdit($singular, $minuscula, $minPlural);
        file_put_contents($dirVistas . '/edit.php', $editContenido);
        CLI::write("  VISTA EDIT CREADA: {$dirVistas}/edit.php", 'yellow');

        // MOSTRAMOS RESUMEN E INSTRUCCIONES FINALES
        CLI::newLine();
        CLI::write('CRUD GENERADO EXITOSAMENTE.', 'green');
        CLI::newLine();
        CLI::write('PASOS PENDIENTES:', 'white');
        CLI::write("  1. CREAR EL MODELO {$modelClass} CON LOS CAMPOS NECESARIOS", 'white');
        CLI::write("  2. CREAR LA MIGRACION PARA LA TABLA {$minPlural}", 'white');
        CLI::write("  3. ANADIR LA RUTA EN Routes.php:", 'white');
        CLI::write("     registrarCrud(\$routes, '{$minPlural}', '{$singular}');", 'cyan');
        CLI::write("  4. COMPLETAR LOS CAMPOS EN EL CONTROLADOR Y LAS VISTAS GENERADAS", 'white');
    }

    // MÉTODO PRIVADO QUE GENERA EL CONTENIDO PHP DEL CONTROLADOR
    private function generarControlador($singular, $plural, $min, $minP, $model): string
    {
        return "<?php\n"
            . "// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP\n"
            . "namespace App\\Controllers;\n\n"
            . "// CONTROLADOR CRUD PARA {$plural} - GENERADO CON php spark crud:generar\n"
            . "// HEREDA DE CrudController QUE CONTIENE TODA LA LOGICA DEL CRUD\n"
            . "class {$singular} extends CrudController\n"
            . "{\n"
            . "    // NOMBRE COMPLETO DE LA CLASE DEL MODELO\n"
            . "    protected string \$modelClass     = 'App\\\\Models\\\\{$model}';\n"
            . "    // PREFIJO DE LAS VISTAS: BUSCA EN app/Views/{$minP}/\n"
            . "    protected string \$vistasPrefijo  = '{$minP}';\n"
            . "    // URL BASE PARA REDIRECCIONES\n"
            . "    protected string \$rutaBase       = '/{$minP}';\n"
            . "    // NOMBRE EN SINGULAR PARA LOS MENSAJES\n"
            . "    protected string \$tituloSingular = '{$singular}';\n"
            . "    // NOMBRE EN PLURAL PARA EL TITULO DEL LISTADO\n"
            . "    protected string \$tituloPlural   = '{$plural}';\n"
            . "    // NOMBRE DE LA VARIABLE QUE RECIBE LA VISTA INDEX\n"
            . "    protected string \$variableLista  = '{$minP}';\n"
            . "    // NOMBRE DE LA VARIABLE QUE RECIBE LA VISTA EDIT\n"
            . "    protected string \$variableItem   = '{$min}';\n"
            . "    // CAMPOS DEL FORMULARIO - RELLENAR CON TUS CAMPOS\n"
            . "    protected array  \$campos         = [];\n"
            . "    // REGISTROS POR PAGINA (0 = SIN PAGINACION)\n"
            . "    protected int    \$porPagina      = 10;\n"
            . "}\n";
    }

    // MÉTODO PRIVADO QUE GENERA LA VISTA INDEX (LISTADO CON TABLA BOOTSTRAP)
    private function generarVistaIndex($singular, $plural, $minP): string
    {
        return "<?= \$this->extend('layout/main') ?>\n"
            . "<?= \$this->section('contenido') ?>\n\n"
            . "<div class=\"d-flex justify-content-between align-items-center mb-3\">\n"
            . "    <h1>{$plural}</h1>\n"
            . "    <a href=\"<?= base_url('/{$minP}/create') ?>\" class=\"btn btn-primary\">\n"
            . "        <i class=\"fa fa-plus\"></i> Nuevo/a {$singular}\n"
            . "    </a>\n"
            . "</div>\n\n"
            . "<div class=\"table-responsive\">\n"
            . "    <table class=\"table table-bordered table-striped table-hover\">\n"
            . "        <thead class=\"table-dark\">\n"
            . "            <tr>\n"
            . "                <th>ID</th>\n"
            . "                <th><!-- COLUMNAS --></th>\n"
            . "                <th>Acciones</th>\n"
            . "            </tr>\n"
            . "        </thead>\n"
            . "        <tbody>\n"
            . "            <?php if (!empty(\${$minP})): ?>\n"
            . "                <?php foreach (\${$minP} as \$item): ?>\n"
            . "                    <tr>\n"
            . "                        <td><?= \$item['id'] ?></td>\n"
            . "                        <td><!-- CAMPOS --></td>\n"
            . "                        <td>\n"
            . "                            <a href=\"<?= base_url('/{$minP}/edit/' . \$item['id']) ?>\" class=\"btn btn-sm btn-warning\"><i class=\"fa fa-edit\"></i></a>\n"
            . "                            <form action=\"<?= base_url('/{$minP}/delete/' . \$item['id']) ?>\" method=\"POST\" class=\"d-inline\" onsubmit=\"return confirm('Seguro?')\">\n"
            . "                                <?= csrf_field() ?>\n"
            . "                                <button class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash\"></i></button>\n"
            . "                            </form>\n"
            . "                        </td>\n"
            . "                    </tr>\n"
            . "                <?php endforeach; ?>\n"
            . "            <?php else: ?>\n"
            . "                <tr><td colspan=\"3\" class=\"text-center\">No hay registros</td></tr>\n"
            . "            <?php endif; ?>\n"
            . "        </tbody>\n"
            . "    </table>\n"
            . "</div>\n\n"
            . "<?php if (isset(\$pager)): ?>\n"
            . "    <div class=\"d-flex justify-content-center\">\n"
            . "        <?= \$pager->links('default', 'default_full') ?>\n"
            . "    </div>\n"
            . "<?php endif; ?>\n\n"
            . "<?= \$this->endSection() ?>\n";
    }

    // MÉTODO PRIVADO QUE GENERA LA VISTA CREATE (FORMULARIO)
    private function generarVistaCreate($singular, $minP): string
    {
        return "<?= \$this->extend('layout/main') ?>\n"
            . "<?= \$this->section('contenido') ?>\n\n"
            . "<h1>Crear {$singular}</h1><hr>\n\n"
            . "<?php if (session()->getFlashdata('errors')): ?>\n"
            . "    <div class=\"alert alert-danger\"><ul class=\"mb-0\">\n"
            . "        <?php foreach (session()->getFlashdata('errors') as \$error): ?>\n"
            . "            <li><?= esc(\$error) ?></li>\n"
            . "        <?php endforeach; ?>\n"
            . "    </ul></div>\n"
            . "<?php endif; ?>\n\n"
            . "<form action=\"<?= base_url('/{$minP}/store') ?>\" method=\"POST\">\n"
            . "    <?= csrf_field() ?>\n"
            . "    <!-- CAMPOS DEL FORMULARIO -->\n"
            . "    <a href=\"<?= base_url('/{$minP}') ?>\" class=\"btn btn-secondary\"><i class=\"fa fa-arrow-left\"></i> Volver</a>\n"
            . "    <button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-save\"></i> Guardar</button>\n"
            . "</form>\n\n"
            . "<?= \$this->endSection() ?>\n";
    }

    // MÉTODO PRIVADO QUE GENERA LA VISTA EDIT (FORMULARIO DE EDICIÓN)
    private function generarVistaEdit($singular, $min, $minP): string
    {
        return "<?= \$this->extend('layout/main') ?>\n"
            . "<?= \$this->section('contenido') ?>\n\n"
            . "<h1>Editar {$singular}</h1><hr>\n\n"
            . "<?php if (session()->getFlashdata('errors')): ?>\n"
            . "    <div class=\"alert alert-danger\"><ul class=\"mb-0\">\n"
            . "        <?php foreach (session()->getFlashdata('errors') as \$error): ?>\n"
            . "            <li><?= esc(\$error) ?></li>\n"
            . "        <?php endforeach; ?>\n"
            . "    </ul></div>\n"
            . "<?php endif; ?>\n\n"
            . "<form action=\"<?= base_url('/{$minP}/update/' . \${$min}['id']) ?>\" method=\"POST\">\n"
            . "    <?= csrf_field() ?>\n"
            . "    <!-- CAMPOS DEL FORMULARIO -->\n"
            . "    <a href=\"<?= base_url('/{$minP}') ?>\" class=\"btn btn-secondary\"><i class=\"fa fa-arrow-left\"></i> Volver</a>\n"
            . "    <button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-save\"></i> Actualizar</button>\n"
            . "</form>\n\n"
            . "<?= \$this->endSection() ?>\n";
    }
}
