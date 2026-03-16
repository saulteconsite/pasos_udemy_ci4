<?php

// ESPACIO DE NOMBRES PARA LOS SEEDERS DE LA APP
namespace App\Database\Seeds;

// IMPORTAMOS LA CLASE BASE SEEDER DE CODEIGNITER
use CodeIgniter\Database\Seeder;

// SEEDER PARA INSERTAR USUARIOS DE PRUEBA EN LA TABLA USUARIOS
class UsuarioSeeder extends Seeder
{
    // MÉTODO QUE SE EJECUTA AL CORRER EL SEEDER (php spark db:seed UsuarioSeeder)
    public function run()
    {
        // DEFINIMOS UN ARRAY CON LOS USUARIOS DE PRUEBA
        $usuarios = [
            [
                // PRIMER USUARIO: ADMINISTRADOR DEL SISTEMA
                'nombre'     => 'Admin',
                'email'      => 'admin@admin.com',
                // HASHEAMOS LA CONTRASEÑA CON BCRYPT PARA QUE NO SE GUARDE EN TEXTO PLANO
                'password'   => password_hash('123456', PASSWORD_DEFAULT),
                // ROL ADMINISTRADOR: TIENE ACCESO TOTAL
                'rol'        => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                // SEGUNDO USUARIO: USUARIO NORMAL
                'nombre'     => 'Usuario Demo',
                'email'      => 'usuario@usuario.com',
                // HASHEAMOS LA CONTRASEÑA CON BCRYPT
                'password'   => password_hash('123456', PASSWORD_DEFAULT),
                // ROL USUARIO: ACCESO LIMITADO
                'rol'        => 'usuario',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                // TERCER USUARIO: OTRO USUARIO NORMAL PARA PRUEBAS
                'nombre'     => 'María García',
                'email'      => 'maria@test.com',
                // HASHEAMOS LA CONTRASEÑA CON BCRYPT
                'password'   => password_hash('123456', PASSWORD_DEFAULT),
                // ROL USUARIO: ACCESO LIMITADO
                'rol'        => 'usuario',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // RECORREMOS CADA USUARIO DEL ARRAY Y LO INSERTAMOS EN LA TABLA
        foreach ($usuarios as $usuario) {
            // INSERTAMOS EL USUARIO EN LA TABLA 'usuarios' DE LA BASE DE DATOS
            $this->db->table('usuarios')->insert($usuario);
        }
    }
}
