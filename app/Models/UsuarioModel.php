<?php

// ESPACIO DE NOMBRES PARA LOS MODELOS DE LA APP
namespace App\Models;

// IMPORTAMOS LA CLASE BASE MODEL DE CODEIGNITER
use CodeIgniter\Model;

// MODELO QUE REPRESENTA LA TABLA USUARIOS EN LA BASE DE DATOS
class UsuarioModel extends Model
{
    // NOMBRE DE LA TABLA EN LA BASE DE DATOS
    protected $table      = 'usuarios';

    // CAMPO QUE ACTÚA COMO CLAVE PRIMARIA
    protected $primaryKey = 'id';

    // CAMPOS QUE SE PUEDEN INSERTAR/ACTUALIZAR DESDE FORMULARIOS
    protected $allowedFields = ['nombre', 'email', 'password', 'rol'];

    // ACTIVAR GESTIÓN AUTOMÁTICA DE CREATED_AT Y UPDATED_AT
    protected $useTimestamps = true;

    // REGLAS DE VALIDACIÓN QUE SE EJECUTAN AUTOMÁTICAMENTE AL USAR SAVE() O UPDATE()
    protected $validationRules = [
        // EL NOMBRE ES OBLIGATORIO, MÍNIMO 3 CARACTERES, MÁXIMO 100
        'nombre'   => 'required|min_length[3]|max_length[100]',
        // EL EMAIL ES OBLIGATORIO, DEBE SER UN EMAIL VÁLIDO Y ÚNICO EN LA TABLA
        'email'    => 'required|valid_email|is_unique[usuarios.email,id,{id}]',
        // LA CONTRASEÑA ES OBLIGATORIA Y MÍNIMO 6 CARACTERES
        'password' => 'required|min_length[6]',
    ];

    // MENSAJES DE VALIDACIÓN PERSONALIZADOS EN ESPAÑOL
    protected $validationMessages = [
        'nombre' => [
            // MENSAJE CUANDO NO SE ENVÍA EL NOMBRE
            'required'   => 'EL NOMBRE ES OBLIGATORIO.',
            // MENSAJE CUANDO EL NOMBRE TIENE MENOS DE 3 CARACTERES
            'min_length' => 'EL NOMBRE DEBE TENER AL MENOS 3 CARACTERES.',
            // MENSAJE CUANDO EL NOMBRE SUPERA LOS 100 CARACTERES
            'max_length' => 'EL NOMBRE NO PUEDE SUPERAR LOS 100 CARACTERES.',
        ],
        'email' => [
            // MENSAJE CUANDO NO SE ENVÍA EL EMAIL
            'required'    => 'EL EMAIL ES OBLIGATORIO.',
            // MENSAJE CUANDO EL EMAIL NO TIENE FORMATO VÁLIDO
            'valid_email' => 'DEBES INTRODUCIR UN EMAIL VÁLIDO.',
            // MENSAJE CUANDO YA EXISTE UN USUARIO CON ESE EMAIL
            'is_unique'   => 'ESTE EMAIL YA ESTÁ REGISTRADO.',
        ],
        'password' => [
            // MENSAJE CUANDO NO SE ENVÍA LA CONTRASEÑA
            'required'   => 'LA CONTRASEÑA ES OBLIGATORIA.',
            // MENSAJE CUANDO LA CONTRASEÑA TIENE MENOS DE 6 CARACTERES
            'min_length' => 'LA CONTRASEÑA DEBE TENER AL MENOS 6 CARACTERES.',
        ],
    ];

    // CALLBACKS: FUNCIONES QUE SE EJECUTAN AUTOMÁTICAMENTE ANTES DE INSERTAR
    // USAMOS beforeInsert PARA HASHEAR LA CONTRASEÑA ANTES DE GUARDARLA
    protected $beforeInsert = ['hashPassword'];

    // CALLBACKS: FUNCIONES QUE SE EJECUTAN AUTOMÁTICAMENTE ANTES DE ACTUALIZAR
    protected $beforeUpdate = ['hashPassword'];

    // MÉTODO PROTEGIDO QUE HASHEA LA CONTRASEÑA CON BCRYPT ANTES DE GUARDARLA
    // RECIBE EL ARRAY DE DATOS Y DEVUELVE EL ARRAY CON LA CONTRASEÑA HASHEADA
    protected function hashPassword(array $data)
    {
        // VERIFICAMOS QUE EXISTA EL CAMPO PASSWORD EN LOS DATOS ENVIADOS
        if (isset($data['data']['password'])) {
            // HASHEAMOS LA CONTRASEÑA USANDO EL ALGORITMO BCRYPT (PASSWORD_DEFAULT)
            // ESTO GENERA UN HASH SEGURO QUE INCLUYE SAL ALEATORIA AUTOMÁTICAMENTE
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        // DEVOLVEMOS EL ARRAY DE DATOS CON LA CONTRASEÑA YA HASHEADA
        return $data;
    }

    // ACTIVAMOS EL USO DE CALLBACKS (ANTES Y DESPUÉS DE INSERT/UPDATE/DELETE)
    protected $allowCallbacks = true;
}
