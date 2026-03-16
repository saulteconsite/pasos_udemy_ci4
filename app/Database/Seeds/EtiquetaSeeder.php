<?php

// ESPACIO DE NOMBRES PARA LOS SEEDERS DE LA APP
namespace App\Database\Seeds;

// IMPORTAMOS LA CLASE BASE SEEDER DE CODEIGNITER
use CodeIgniter\Database\Seeder;

// SEEDER PARA INSERTAR ETIQUETAS DE PRUEBA EN LA TABLA ETIQUETAS
class EtiquetaSeeder extends Seeder
{
    // MÉTODO QUE SE EJECUTA AL CORRER EL SEEDER (php spark db:seed EtiquetaSeeder)
    public function run()
    {
        // DEFINIMOS UN ARRAY CON LAS ETIQUETAS DE PRUEBA
        $etiquetas = [
            // CADA ETIQUETA TIENE UN NOMBRE Y FECHAS DE CREACIÓN/ACTUALIZACIÓN
            ['nombre' => 'Clásico',        'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Premiada',       'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Taquillera',     'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Independiente',  'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Recomendada',    'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Infantil',       'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Estreno',        'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Saga',           'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        // RECORREMOS CADA ETIQUETA DEL ARRAY Y LA INSERTAMOS EN LA TABLA
        foreach ($etiquetas as $etiqueta) {
            // INSERTAMOS LA ETIQUETA EN LA TABLA 'etiquetas' DE LA BASE DE DATOS
            $this->db->table('etiquetas')->insert($etiqueta);
        }
    }
}
