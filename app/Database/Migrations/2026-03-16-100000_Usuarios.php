<?php

// ESPACIO DE NOMBRES PARA LAS MIGRACIONES DE LA APP
namespace App\Database\Migrations;

// IMPORTAMOS LA CLASE BASE MIGRATION DE CODEIGNITER
use CodeIgniter\Database\Migration;

// CLASE DE MIGRACIÓN PARA CREAR LA TABLA USUARIOS
class Usuarios extends Migration
{
    // MÉTODO QUE SE EJECUTA AL CORRER LA MIGRACIÓN (php spark migrate)
    public function up()
    {
        // DEFINIMOS LAS COLUMNAS DE LA TABLA USUARIOS
        $this->forge->addField([
            // COLUMNA ID: CLAVE PRIMARIA AUTOINCREMENTAL
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // COLUMNA NOMBRE: NOMBRE COMPLETO DEL USUARIO (MÁXIMO 100 CARACTERES)
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            // COLUMNA EMAIL: CORREO ELECTRÓNICO ÚNICO DEL USUARIO (MÁXIMO 100 CARACTERES)
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            // COLUMNA PASSWORD: CONTRASEÑA HASHEADA CON password_hash() (MÁXIMO 255 CARACTERES)
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            // COLUMNA ROL: TIPO DE USUARIO (admin O usuario), POR DEFECTO 'usuario'
            'rol' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'usuario',
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

        // AÑADIMOS UN ÍNDICE ÚNICO AL CAMPO EMAIL PARA QUE NO SE REPITA
        $this->forge->addUniqueKey('email');

        // CREAMOS LA TABLA EN LA BASE DE DATOS
        $this->forge->createTable('usuarios');
    }

    // MÉTODO QUE SE EJECUTA AL REVERTIR LA MIGRACIÓN (php spark migrate:rollback)
    public function down()
    {
        // ELIMINAMOS LA TABLA USUARIOS DE LA BASE DE DATOS
        $this->forge->dropTable('usuarios');
    }
}
