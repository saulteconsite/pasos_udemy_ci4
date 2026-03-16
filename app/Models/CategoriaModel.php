<?php

// ESPACIO DE NOMBRES PARA LOS MODELOS DE LA APP
namespace App\Models;

// IMPORTAMOS LA CLASE BASE MODEL DE CODEIGNITER
use CodeIgniter\Model;

// MODELO QUE REPRESENTA LA TABLA CATEGORIAS EN LA BASE DE DATOS
class CategoriaModel extends Model
{
    // NOMBRE DE LA TABLA EN LA BASE DE DATOS
    protected $table      = 'categorias';

    // CAMPO QUE ACTÚA COMO CLAVE PRIMARIA
    protected $primaryKey = 'id';

    // CAMPOS QUE SE PUEDEN INSERTAR/ACTUALIZAR DESDE FORMULARIOS
    protected $allowedFields = ['titulo'];

    // ACTIVAR GESTIÓN AUTOMÁTICA DE CREATED_AT Y UPDATED_AT
    protected $useTimestamps = true;

    // REGLAS DE VALIDACIÓN QUE SE EJECUTAN AUTOMÁTICAMENTE AL USAR SAVE() O UPDATE()
    protected $validationRules = [
        // EL TÍTULO ES OBLIGATORIO, MÍNIMO 3 CARACTERES, MÁXIMO 100, Y DEBE SER ÚNICO EN LA TABLA
        'titulo' => 'required|min_length[3]|max_length[100]|is_unique[categorias.titulo,id,{id}]',
    ];

    // MENSAJES DE VALIDACIÓN PERSONALIZADOS EN ESPAÑOL
    protected $validationMessages = [
        'titulo' => [
            // MENSAJE CUANDO NO SE ENVÍA EL CAMPO TITULO
            'required'   => 'EL TÍTULO DE LA CATEGORÍA ES OBLIGATORIO.',
            // MENSAJE CUANDO EL TÍTULO TIENE MENOS DE 3 CARACTERES
            'min_length' => 'EL TÍTULO DEBE TENER AL MENOS 3 CARACTERES.',
            // MENSAJE CUANDO EL TÍTULO SUPERA LOS 100 CARACTERES
            'max_length' => 'EL TÍTULO NO PUEDE SUPERAR LOS 100 CARACTERES.',
            // MENSAJE CUANDO YA EXISTE UNA CATEGORÍA CON ESE TÍTULO
            'is_unique'  => 'YA EXISTE UNA CATEGORÍA CON ESE TÍTULO.',
        ],
    ];
}
