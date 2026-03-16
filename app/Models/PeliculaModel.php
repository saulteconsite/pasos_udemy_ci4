<?php

// ESPACIO DE NOMBRES PARA LOS MODELOS DE LA APP
namespace App\Models;

// IMPORTAMOS LA CLASE BASE MODEL DE CODEIGNITER
use CodeIgniter\Model;

// MODELO QUE REPRESENTA LA TABLA PELICULAS EN LA BASE DE DATOS
class PeliculaModel extends Model
{
    // NOMBRE DE LA TABLA EN LA BASE DE DATOS
    protected $table      = 'peliculas';

    // CAMPO QUE ACTÚA COMO CLAVE PRIMARIA
    protected $primaryKey = 'id';

    // CAMPOS QUE SE PUEDEN INSERTAR/ACTUALIZAR DESDE FORMULARIOS
    protected $allowedFields = ['titulo', 'descripcion'];

    // ACTIVAR GESTIÓN AUTOMÁTICA DE CREATED_AT Y UPDATED_AT
    protected $useTimestamps = true;

    // REGLAS DE VALIDACIÓN QUE SE EJECUTAN AUTOMÁTICAMENTE AL USAR SAVE() O UPDATE()
    // ASÍ NO HAY QUE REPETIRLAS EN CADA MÉTODO DEL CONTROLADOR
    protected $validationRules = [
        // EL TÍTULO ES OBLIGATORIO, MÍNIMO 3 CARACTERES, MÁXIMO 150
        'titulo'      => 'required|min_length[3]|max_length[150]',
        // LA DESCRIPCIÓN ES OPCIONAL PERO SI SE ENVÍA NO PUEDE SUPERAR 5000 CARACTERES
        'descripcion' => 'permit_empty|max_length[5000]',
    ];

    // MENSAJES DE VALIDACIÓN PERSONALIZADOS EN ESPAÑOL
    // SE ORGANIZAN POR CAMPO Y LUEGO POR REGLA
    protected $validationMessages = [
        'titulo' => [
            // MENSAJE CUANDO NO SE ENVÍA EL CAMPO TITULO
            'required'   => 'EL TÍTULO DE LA PELÍCULA ES OBLIGATORIO.',
            // MENSAJE CUANDO EL TÍTULO TIENE MENOS DE 3 CARACTERES
            'min_length' => 'EL TÍTULO DEBE TENER AL MENOS 3 CARACTERES.',
            // MENSAJE CUANDO EL TÍTULO SUPERA LOS 150 CARACTERES
            'max_length' => 'EL TÍTULO NO PUEDE SUPERAR LOS 150 CARACTERES.',
        ],
        'descripcion' => [
            // MENSAJE CUANDO LA DESCRIPCIÓN SUPERA LOS 5000 CARACTERES
            'max_length' => 'LA DESCRIPCIÓN NO PUEDE SUPERAR LOS 5000 CARACTERES.',
        ],
    ];
}
