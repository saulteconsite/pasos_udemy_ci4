<?php

// ESPACIO DE NOMBRES PARA LOS SEEDERS DE LA APP
namespace App\Database\Seeds;

// IMPORTAMOS LA CLASE BASE SEEDER DE CODEIGNITER
use CodeIgniter\Database\Seeder;

// SEEDER PARA INSERTAR DATOS DE PRUEBA EN LA TABLA CATEGORIAS
class CategoriaSeeder extends Seeder
{
    // MÉTODO QUE SE EJECUTA AL CORRER EL SEEDER
    public function run()
    {
        // ARRAY CON LAS CATEGORÍAS DE EJEMPLO
        $categorias = [
            ['titulo' => 'Acción'],
            ['titulo' => 'Comedia'],
            ['titulo' => 'Drama'],
            ['titulo' => 'Terror'],
            ['titulo' => 'Ciencia Ficción'],
            ['titulo' => 'Romance'],
            ['titulo' => 'Animación'],
            ['titulo' => 'Suspenso'],
            ['titulo' => 'Aventura'],
            ['titulo' => 'Documental'],
        ];

        // OBTENEMOS LA FECHA Y HORA ACTUAL PARA LOS CAMPOS DE TIMESTAMP
        $now = date('Y-m-d H:i:s');

        // RECORREMOS CADA CATEGORÍA E INSERTAMOS EN LA TABLA
        foreach ($categorias as $categoria) {
            // AÑADIMOS LA FECHA DE CREACIÓN
            $categoria['created_at'] = $now;
            // AÑADIMOS LA FECHA DE ACTUALIZACIÓN
            $categoria['updated_at'] = $now;
            // INSERTAMOS EL REGISTRO EN LA TABLA CATEGORIAS
            $this->db->table('categorias')->insert($categoria);
        }
    }
}
