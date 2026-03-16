<?php

// ESPACIO DE NOMBRES PARA LAS MIGRACIONES DE LA APP
namespace App\Database\Migrations;

// IMPORTAMOS LA CLASE BASE MIGRATION DE CODEIGNITER
use CodeIgniter\Database\Migration;

// MIGRACIÓN PARA AÑADIR LA COLUMNA imagen A LA TABLA PELICULAS
// ESTE CAMPO ALMACENA EL NOMBRE DEL ARCHIVO DE IMAGEN SUBIDO
class AddImagenToPeliculas extends Migration
{
    // MÉTODO QUE SE EJECUTA AL CORRER LA MIGRACIÓN (php spark migrate)
    public function up()
    {
        // DEFINIMOS LA NUEVA COLUMNA QUE SE VA A AÑADIR
        $campos = [
            // COLUMNA imagen: GUARDA EL NOMBRE DEL ARCHIVO (EJ: "abc123.jpg")
            'imagen' => [
                // TIPO VARCHAR PARA ALMACENAR EL NOMBRE DEL ARCHIVO
                'type'       => 'VARCHAR',
                'constraint' => '255',
                // PUEDE SER NULO PARA PELÍCULAS SIN IMAGEN
                'null'       => true,
                // SE AÑADE DESPUÉS DE LA COLUMNA categoria_id
                'after'      => 'categoria_id',
            ],
        ];

        // AÑADIMOS LA COLUMNA A LA TABLA PELICULAS YA EXISTENTE
        $this->forge->addColumn('peliculas', $campos);
    }

    // MÉTODO QUE SE EJECUTA AL REVERTIR LA MIGRACIÓN (php spark migrate:rollback)
    public function down()
    {
        // ELIMINAMOS LA COLUMNA imagen DE LA TABLA PELICULAS
        $this->forge->dropColumn('peliculas', 'imagen');
    }
}
