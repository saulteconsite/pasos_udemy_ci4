<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS EL MODELO DE USUARIOS
use App\Models\UsuarioModel;

// CONTROLADOR DE AUTENTICACIÓN: GESTIONA LOGIN, REGISTRO Y LOGOUT
class Auth extends BaseController
{
    // PROPIEDAD PARA ALMACENAR LA INSTANCIA DEL MODELO DE USUARIOS
    protected $usuarioModel;

    // CONSTRUCTOR: SE EJECUTA AL CREAR UNA INSTANCIA DEL CONTROLADOR
    public function __construct()
    {
        // CREAMOS UNA INSTANCIA DEL MODELO USUARIO
        $this->usuarioModel = new UsuarioModel();
        // CARGAMOS LOS HELPERS DE FORMULARIO Y URL QUE NECESITAMOS EN LAS VISTAS
        helper(['form', 'url']);
    }

    // =============================================
    // MÉTODO LOGIN: MUESTRA EL FORMULARIO DE INICIO DE SESIÓN
    // =============================================
    public function login()
    {
        // SI EL USUARIO YA ESTÁ LOGUEADO, LO REDIRIGIMOS A PELÍCULAS
        if (session()->get('usuario_id')) {
            // REDIRIGIMOS PORQUE YA TIENE SESIÓN ACTIVA
            return redirect()->to(base_url('/peliculas'));
        }

        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Iniciar Sesión';

        // CARGAMOS LA VISTA DEL FORMULARIO DE LOGIN
        return view('auth/login', $datos);
    }

    // =============================================
    // MÉTODO LOGINPOST: PROCESA EL FORMULARIO DE LOGIN
    // =============================================
    public function loginPost()
    {
        // DEFINIMOS LAS REGLAS DE VALIDACIÓN PARA EL FORMULARIO DE LOGIN
        $reglas = [
            // EL EMAIL ES OBLIGATORIO Y DEBE TENER FORMATO DE EMAIL VÁLIDO
            'email'    => 'required|valid_email',
            // LA CONTRASEÑA ES OBLIGATORIA
            'password' => 'required',
        ];

        // SI LA VALIDACIÓN FALLA, REDIRIGIMOS AL FORMULARIO CON LOS ERRORES
        if (!$this->validate($reglas)) {
            // VOLVEMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // OBTENEMOS EL EMAIL Y LA CONTRASEÑA DEL FORMULARIO
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // BUSCAMOS AL USUARIO EN LA BASE DE DATOS POR SU EMAIL
        // where() FILTRA POR EMAIL Y first() DEVUELVE EL PRIMER RESULTADO O NULL
        $usuario = $this->usuarioModel->where('email', $email)->first();

        // SI EL USUARIO NO EXISTE, MOSTRAMOS ERROR
        if ($usuario === null) {
            // REDIRIGIMOS CON UN MENSAJE DE ERROR GENÉRICO (POR SEGURIDAD NO DECIMOS QUÉ FALLÓ)
            return redirect()->back()->withInput()->with('error', 'CREDENCIALES INCORRECTAS. VERIFICA TU EMAIL Y CONTRASEÑA.');
        }

        // VERIFICAMOS QUE LA CONTRASEÑA INTRODUCIDA COINCIDA CON EL HASH GUARDADO EN LA BD
        // password_verify() COMPARA LA CONTRASEÑA EN TEXTO PLANO CON EL HASH BCRYPT
        if (!password_verify($password, $usuario['password'])) {
            // SI NO COINCIDE, REDIRIGIMOS CON ERROR GENÉRICO
            return redirect()->back()->withInput()->with('error', 'CREDENCIALES INCORRECTAS. VERIFICA TU EMAIL Y CONTRASEÑA.');
        }

        // SI TODO ES CORRECTO, GUARDAMOS LOS DATOS DEL USUARIO EN LA SESIÓN
        // set() GUARDA DATOS PERMANENTES EN LA SESIÓN (NO FLASHDATA)
        session()->set([
            // GUARDAMOS EL ID DEL USUARIO EN LA SESIÓN
            'usuario_id'     => $usuario['id'],
            // GUARDAMOS EL NOMBRE DEL USUARIO EN LA SESIÓN
            'usuario_nombre' => $usuario['nombre'],
            // GUARDAMOS EL EMAIL DEL USUARIO EN LA SESIÓN
            'usuario_email'  => $usuario['email'],
            // GUARDAMOS EL ROL DEL USUARIO EN LA SESIÓN (admin O usuario)
            'usuario_rol'    => $usuario['rol'],
            // MARCAMOS QUE EL USUARIO ESTÁ AUTENTICADO
            'logueado'       => true,
        ]);

        // REDIRIGIMOS AL LISTADO DE PELÍCULAS CON MENSAJE DE BIENVENIDA
        return redirect()->to(base_url('/peliculas'))->with('mensaje', 'BIENVENIDO, ' . $usuario['nombre'] . '!');
    }

    // =============================================
    // MÉTODO REGISTRO: MUESTRA EL FORMULARIO DE REGISTRO
    // =============================================
    public function registro()
    {
        // SI EL USUARIO YA ESTÁ LOGUEADO, LO REDIRIGIMOS A PELÍCULAS
        if (session()->get('usuario_id')) {
            // REDIRIGIMOS PORQUE YA TIENE SESIÓN ACTIVA
            return redirect()->to(base_url('/peliculas'));
        }

        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Registro de Usuario';

        // CARGAMOS LA VISTA DEL FORMULARIO DE REGISTRO
        return view('auth/registro', $datos);
    }

    // =============================================
    // MÉTODO REGISTROPOST: PROCESA EL FORMULARIO DE REGISTRO
    // =============================================
    public function registroPost()
    {
        // DEFINIMOS LAS REGLAS DE VALIDACIÓN PARA EL FORMULARIO DE REGISTRO
        $reglas = [
            // EL NOMBRE ES OBLIGATORIO, MÍNIMO 3 CARACTERES, MÁXIMO 100
            'nombre'              => 'required|min_length[3]|max_length[100]',
            // EL EMAIL ES OBLIGATORIO, FORMATO VÁLIDO Y ÚNICO EN LA TABLA USUARIOS
            'email'               => 'required|valid_email|is_unique[usuarios.email]',
            // LA CONTRASEÑA ES OBLIGATORIA Y MÍNIMO 6 CARACTERES
            'password'            => 'required|min_length[6]',
            // CONFIRMACIÓN DE CONTRASEÑA: DEBE COINCIDIR CON EL CAMPO PASSWORD
            'password_confirmar'  => 'required|matches[password]',
        ];

        // DEFINIMOS MENSAJES DE ERROR PERSONALIZADOS EN ESPAÑOL
        $mensajes = [
            'nombre' => [
                'required'   => 'EL NOMBRE ES OBLIGATORIO.',
                'min_length' => 'EL NOMBRE DEBE TENER AL MENOS 3 CARACTERES.',
                'max_length' => 'EL NOMBRE NO PUEDE SUPERAR LOS 100 CARACTERES.',
            ],
            'email' => [
                'required'    => 'EL EMAIL ES OBLIGATORIO.',
                'valid_email' => 'DEBES INTRODUCIR UN EMAIL VÁLIDO.',
                'is_unique'   => 'ESTE EMAIL YA ESTÁ REGISTRADO.',
            ],
            'password' => [
                'required'   => 'LA CONTRASEÑA ES OBLIGATORIA.',
                'min_length' => 'LA CONTRASEÑA DEBE TENER AL MENOS 6 CARACTERES.',
            ],
            'password_confirmar' => [
                'required' => 'DEBES CONFIRMAR LA CONTRASEÑA.',
                'matches'  => 'LAS CONTRASEÑAS NO COINCIDEN.',
            ],
        ];

        // SI LA VALIDACIÓN FALLA, REDIRIGIMOS AL FORMULARIO CON LOS ERRORES
        if (!$this->validate($reglas, $mensajes)) {
            // VOLVEMOS AL FORMULARIO CON LOS DATOS INTRODUCIDOS Y LOS ERRORES
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // PREPARAMOS LOS DATOS DEL NUEVO USUARIO
        $datos = [
            // NOMBRE DEL USUARIO
            'nombre'   => $this->request->getPost('nombre'),
            // EMAIL DEL USUARIO
            'email'    => $this->request->getPost('email'),
            // CONTRASEÑA EN TEXTO PLANO (EL MODELO LA HASHEARÁ AUTOMÁTICAMENTE CON beforeInsert)
            'password' => $this->request->getPost('password'),
            // ROL POR DEFECTO: USUARIO NORMAL
            'rol'      => 'usuario',
        ];

        // DESACTIVAMOS TEMPORALMENTE LA VALIDACIÓN DEL MODELO PARA EVITAR DOBLE VALIDACIÓN
        // YA VALIDAMOS ARRIBA CON REGLAS MÁS COMPLETAS (INCLUYENDO password_confirmar)
        $this->usuarioModel->skipValidation(true)->save($datos);

        // REDIRIGIMOS AL LOGIN CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url('/auth/login'))->with('mensaje', 'USUARIO REGISTRADO CORRECTAMENTE. YA PUEDES INICIAR SESIÓN.');
    }

    // =============================================
    // MÉTODO LOGOUT: CIERRA LA SESIÓN DEL USUARIO
    // =============================================
    public function logout()
    {
        // DESTRUIMOS COMPLETAMENTE LA SESIÓN (ELIMINA TODOS LOS DATOS GUARDADOS)
        session()->destroy();

        // REDIRIGIMOS AL LOGIN CON UN MENSAJE DE DESPEDIDA
        return redirect()->to(base_url('/auth/login'))->with('mensaje', 'SESIÓN CERRADA CORRECTAMENTE.');
    }
}
