<?php

// ESPACIO DE NOMBRES PARA LOS SEEDERS DE LA APP
namespace App\Database\Seeds;

// IMPORTAMOS LA CLASE BASE SEEDER DE CODEIGNITER
use CodeIgniter\Database\Seeder;

// SEEDER PARA INSERTAR DATOS DE PRUEBA EN LA TABLA PELICULAS
class PeliculaSeeder extends Seeder
{
    // MÉTODO QUE SE EJECUTA AL CORRER EL SEEDER
    public function run()
    {
        // ARRAY CON 5 PELÍCULAS DE EJEMPLO
        $peliculas = [
            ['titulo' => 'El Padrino', 'descripcion' => 'La historia de la familia Corleone, una de las más poderosas dinastías del crimen organizado en América.'],
            ['titulo' => 'Pulp Fiction', 'descripcion' => 'Las vidas de dos sicarios, un boxeador y la esposa de un gángster se entrelazan en cuatro historias de violencia y redención.'],
            ['titulo' => 'Interestelar', 'descripcion' => 'Un grupo de exploradores viaja a través de un agujero de gusano en el espacio para asegurar la supervivencia de la humanidad.'],
            ['titulo' => 'Matrix', 'descripcion' => 'Un programador descubre que la realidad que conoce es una simulación creada por máquinas y se une a la rebelión.'],
            ['titulo' => 'Coco', 'descripcion' => 'Un niño mexicano apasionado por la música viaja al mundo de los muertos para descubrir la verdadera historia de su familia.'],
        ];

        // OBTENEMOS LA FECHA Y HORA ACTUAL PARA LOS CAMPOS DE TIMESTAMP
        $now = date('Y-m-d H:i:s');

        // RECORREMOS CADA PELÍCULA E INSERTAMOS EN LA TABLA
        foreach ($peliculas as $pelicula) {
            // AÑADIMOS LA FECHA DE CREACIÓN
            $pelicula['created_at'] = $now;
            // AÑADIMOS LA FECHA DE ACTUALIZACIÓN
            $pelicula['updated_at'] = $now;
            // INSERTAMOS EL REGISTRO EN LA TABLA PELICULAS
            $this->db->table('peliculas')->insert($pelicula);
        }
    }
}
