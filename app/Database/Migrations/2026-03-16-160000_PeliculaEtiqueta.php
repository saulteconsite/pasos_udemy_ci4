<?php

// ESPACIO DE NOMBRES PARA LAS MIGRACIONES DE LA APP
namespace App\Database\Migrations;

// IMPORTAMOS LA CLASE BASE MIGRATION DE CODEIGNITER
use CodeIgniter\Database\Migration;

// MIGRACIÓN PARA CREAR LA TABLA PIVOTE pelicula_etiqueta
// ESTA TABLA INTERMEDIA PERMITE LA RELACIÓN MUCHOS A MUCHOS (N:M)
// UNA PELÍCULA PUEDE TENER MUCHAS ETIQUETAS Y UNA ETIQUETA PUEDE ESTAR EN MUCHAS PELÍCULAS
class PeliculaEtiqueta extends Migration
{
    // MÉTODO QUE SE EJECUTA AL CORRER LA MIGRACIÓN (php spark migrate)
    public function up()
    {
        // DEFINIMOS LAS COLUMNAS DE LA TABLA PIVOTE
        $this->forge->addField([
            // COLUMNA ID: CLAVE PRIMARIA AUTOINCREMENTAL DE LA TABLA PIVOTE
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // COLUMNA pelicula_id: REFERENCIA AL ID DE LA TABLA PELICULAS
            'pelicula_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // COLUMNA etiqueta_id: REFERENCIA AL ID DE LA TABLA ETIQUETAS
            'etiqueta_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // DEFINIMOS EL CAMPO ID COMO CLAVE PRIMARIA
        $this->forge->addKey('id', true);

        // CREAMOS LA TABLA EN LA BASE DE DATOS
        $this->forge->createTable('pelicula_etiqueta');
    }

    // MÉTODO QUE SE EJECUTA AL REVERTIR LA MIGRACIÓN (php spark migrate:rollback)
    public function down()
    {
        // ELIMINAMOS LA TABLA PIVOTE pelicula_etiqueta DE LA BASE DE DATOS
        $this->forge->dropTable('pelicula_etiqueta');
    }
}
