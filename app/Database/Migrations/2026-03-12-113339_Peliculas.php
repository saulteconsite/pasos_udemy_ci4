<?php

// ESPACIO DE NOMBRES PARA LAS MIGRACIONES DE LA APP
namespace App\Database\Migrations;

// IMPORTAMOS LA CLASE BASE MIGRATION DE CODEIGNITER
use CodeIgniter\Database\Migration;

// CLASE DE MIGRACIÓN PARA CREAR LA TABLA PELICULAS
class Peliculas extends Migration
{
    // MÉTODO QUE SE EJECUTA AL CORRER LA MIGRACIÓN
    public function up()
    {
        // DEFINIMOS LAS COLUMNAS DE LA TABLA PELICULAS
        $this->forge->addField([
            // COLUMNA ID: CLAVE PRIMARIA AUTOINCREMENTAL
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // COLUMNA TITULO: NOMBRE DE LA PELÍCULA (MÁXIMO 150 CARACTERES)
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            // COLUMNA DESCRIPCION: TEXTO LARGO, PUEDE SER NULO
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // COLUMNA CREATED_AT: FECHA DE CREACIÓN AUTOMÁTICA
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            // COLUMNA UPDATED_AT: FECHA DE ÚLTIMA ACTUALIZACIÓN AUTOMÁTICA
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // DEFINIMOS EL CAMPO ID COMO CLAVE PRIMARIA
        $this->forge->addKey('id', true);

        // CREAMOS LA TABLA EN LA BASE DE DATOS
        $this->forge->createTable('peliculas');
    }

    // MÉTODO QUE SE EJECUTA AL REVERTIR LA MIGRACIÓN
    public function down()
    {
        // ELIMINAMOS LA TABLA PELICULAS DE LA BASE DE DATOS
        $this->forge->dropTable('peliculas');
    }
}
