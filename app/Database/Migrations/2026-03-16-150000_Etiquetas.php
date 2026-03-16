<?php

// ESPACIO DE NOMBRES PARA LAS MIGRACIONES DE LA APP
namespace App\Database\Migrations;

// IMPORTAMOS LA CLASE BASE MIGRATION DE CODEIGNITER
use CodeIgniter\Database\Migration;

// MIGRACIÓN PARA CREAR LA TABLA ETIQUETAS (TAGS)
// LAS ETIQUETAS SON PALABRAS CLAVE QUE SE PUEDEN ASIGNAR A LAS PELÍCULAS
class Etiquetas extends Migration
{
    // MÉTODO QUE SE EJECUTA AL CORRER LA MIGRACIÓN (php spark migrate)
    public function up()
    {
        // DEFINIMOS LAS COLUMNAS DE LA TABLA ETIQUETAS
        $this->forge->addField([
            // COLUMNA ID: CLAVE PRIMARIA AUTOINCREMENTAL
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // COLUMNA NOMBRE: TEXTO DE LA ETIQUETA (POR EJEMPLO: "CLÁSICO", "PREMIADA")
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '80',
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
        $this->forge->createTable('etiquetas');
    }

    // MÉTODO QUE SE EJECUTA AL REVERTIR LA MIGRACIÓN (php spark migrate:rollback)
    public function down()
    {
        // ELIMINAMOS LA TABLA ETIQUETAS DE LA BASE DE DATOS
        $this->forge->dropTable('etiquetas');
    }
}
