<?php

// ESPACIO DE NOMBRES PARA LAS MIGRACIONES DE LA APP
namespace App\Database\Migrations;

// IMPORTAMOS LA CLASE BASE MIGRATION DE CODEIGNITER
use CodeIgniter\Database\Migration;

// MIGRACIÓN PARA AÑADIR LA COLUMNA categoria_id A LA TABLA PELICULAS
// ESTO CREA LA RELACIÓN UNO A MUCHOS: UNA CATEGORÍA TIENE MUCHAS PELÍCULAS
// CADA PELÍCULA PERTENECE A UNA SOLA CATEGORÍA
class AddCategoriaIdToPeliculas extends Migration
{
    // MÉTODO QUE SE EJECUTA AL CORRER LA MIGRACIÓN (php spark migrate)
    public function up()
    {
        // DEFINIMOS LA NUEVA COLUMNA QUE SE VA A AÑADIR A LA TABLA PELICULAS
        $campos = [
            // COLUMNA categoria_id: CLAVE FORÁNEA QUE REFERENCIA A LA TABLA CATEGORIAS
            'categoria_id' => [
                // TIPO ENTERO SIN SIGNO (IGUAL QUE EL id DE CATEGORIAS)
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                // PUEDE SER NULO PARA PELÍCULAS SIN CATEGORÍA ASIGNADA
                'null'       => true,
                // SE AÑADE DESPUÉS DE LA COLUMNA descripcion
                'after'      => 'descripcion',
            ],
        ];

        // AÑADIMOS LA COLUMNA A LA TABLA PELICULAS YA EXISTENTE
        $this->forge->addColumn('peliculas', $campos);

        // AÑADIMOS UN ÍNDICE A categoria_id PARA MEJORAR EL RENDIMIENTO DE LOS JOINs
        // LAS CLAVES FORÁNEAS SIEMPRE DEBEN TENER UN ÍNDICE
        $this->forge->addKey('categoria_id', false, false, 'idx_peliculas_categoria');
    }

    // MÉTODO QUE SE EJECUTA AL REVERTIR LA MIGRACIÓN (php spark migrate:rollback)
    public function down()
    {
        // ELIMINAMOS LA COLUMNA categoria_id DE LA TABLA PELICULAS
        $this->forge->dropColumn('peliculas', 'categoria_id');
    }
}
