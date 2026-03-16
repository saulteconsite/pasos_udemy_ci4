<?php

// ESPACIO DE NOMBRES PARA LOS MODELOS DE LA APP
namespace App\Models;

// IMPORTAMOS LA CLASE BASE MODEL DE CODEIGNITER
use CodeIgniter\Model;

// MODELO QUE REPRESENTA LA TABLA ETIQUETAS EN LA BASE DE DATOS
// LAS ETIQUETAS SON TAGS/PALABRAS CLAVE QUE SE ASIGNAN A LAS PELÍCULAS
class EtiquetaModel extends Model
{
    // NOMBRE DE LA TABLA EN LA BASE DE DATOS
    protected $table      = 'etiquetas';

    // CAMPO QUE ACTÚA COMO CLAVE PRIMARIA
    protected $primaryKey = 'id';

    // CAMPOS QUE SE PUEDEN INSERTAR/ACTUALIZAR DESDE FORMULARIOS
    protected $allowedFields = ['nombre'];

    // ACTIVAR GESTIÓN AUTOMÁTICA DE CREATED_AT Y UPDATED_AT
    protected $useTimestamps = true;

    // REGLAS DE VALIDACIÓN QUE SE EJECUTAN AUTOMÁTICAMENTE AL USAR SAVE() O UPDATE()
    protected $validationRules = [
        // EL NOMBRE ES OBLIGATORIO, MÍNIMO 2 CARACTERES, MÁXIMO 80, Y DEBE SER ÚNICO
        'nombre' => 'required|min_length[2]|max_length[80]|is_unique[etiquetas.nombre,id,{id}]',
    ];

    // MENSAJES DE VALIDACIÓN PERSONALIZADOS EN ESPAÑOL
    protected $validationMessages = [
        'nombre' => [
            // MENSAJE CUANDO NO SE ENVÍA EL NOMBRE
            'required'   => 'EL NOMBRE DE LA ETIQUETA ES OBLIGATORIO.',
            // MENSAJE CUANDO EL NOMBRE TIENE MENOS DE 2 CARACTERES
            'min_length' => 'EL NOMBRE DEBE TENER AL MENOS 2 CARACTERES.',
            // MENSAJE CUANDO EL NOMBRE SUPERA LOS 80 CARACTERES
            'max_length' => 'EL NOMBRE NO PUEDE SUPERAR LOS 80 CARACTERES.',
            // MENSAJE CUANDO YA EXISTE UNA ETIQUETA CON ESE NOMBRE
            'is_unique'  => 'YA EXISTE UNA ETIQUETA CON ESE NOMBRE.',
        ],
    ];
}
