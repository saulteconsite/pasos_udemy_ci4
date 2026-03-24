<?php

// ESPACIO DE NOMBRES PARA LOS ARCHIVOS DE CONFIGURACIÓN
namespace Config;

// IMPORTAMOS LA CLASE BASE DE SERVICIOS DE CODEIGNITER
use CodeIgniter\Config\BaseService;

// IMPORTAMOS NUESTRA LIBRERÍA PERSONALIZADA PDF GENERATOR
use App\Libraries\PdfGenerator;

// ARCHIVO DE CONFIGURACIÓN DE SERVICIOS
// LOS SERVICIOS SON INSTANCIAS DE CLASES GESTIONADAS POR EL FRAMEWORK
// EL CONTENEDOR DE SERVICIOS SE ENCARGA DE:
// - CREAR LA INSTANCIA SOLO CUANDO SE NECESITA (LAZY LOADING)
// - REUTILIZAR LA MISMA INSTANCIA (SINGLETON) PARA AHORRAR MEMORIA
// - PERMITIR REEMPLAZAR IMPLEMENTACIONES FÁCILMENTE (PARA TESTING)
class Services extends BaseService
{
    // =============================================
    // SECCIÓN 23: SERVICIO PARA LA LIBRERÍA PDF GENERATOR
    // =============================================
    // REGISTRAMOS NUESTRA LIBRERÍA COMO SERVICIO PARA PODER ACCEDER CON:
    // $pdf = service('pdfGenerator');
    // EN VEZ DE: $pdf = new \App\Libraries\PdfGenerator();
    // LA VENTAJA ES QUE service() DEVUELVE SINGLETON (MISMA INSTANCIA SIEMPRE)
    public static function pdfGenerator(bool $getShared = true)
    {
        // SI SE PIDE LA INSTANCIA COMPARTIDA (POR DEFECTO), DEVOLVEMOS EL SINGLETON
        // getSharedInstance() BUSCA SI YA EXISTE UNA INSTANCIA; SI NO, LA CREA
        if ($getShared) {
            return static::getSharedInstance('pdfGenerator');
        }

        // SI SE PIDE UNA INSTANCIA NUEVA ($getShared = false), CREAMOS UNA NUEVA
        return new PdfGenerator();
    }
}
