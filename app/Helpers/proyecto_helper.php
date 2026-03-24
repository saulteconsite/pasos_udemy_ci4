<?php

// =============================================
// HELPER PERSONALIZADO DEL PROYECTO: proyecto_helper.php
// SECCIÓN 24: TRABAJANDO CON HELPERS EN CODEIGNITER 4
// =============================================
// ESTE ARCHIVO CONTIENE FUNCIONES UTILITARIAS REUTILIZABLES QUE SE PUEDEN
// LLAMAR DESDE CUALQUIER CONTROLADOR, VISTA, MODELO O LIBRERÍA.
// LOS HELPERS SON FUNCIONES SUELTAS (NO CLASES) QUE SE GUARDAN EN app/Helpers/
// EL NOMBRE DEL ARCHIVO DEBE TERMINAR EN _helper.php Y SE CARGA CON helper('proyecto')
// CADA FUNCIÓN VA ENVUELTA EN if (!function_exists()) PARA PREVENIR ERRORES
// SI EL HELPER SE CARGA DOS VECES

// =============================================
// FUNCIÓN fecha_es: FORMATEA UNA FECHA EN ESPAÑOL
// =============================================
// RECIBE UNA FECHA EN FORMATO Y-m-d H:i:s Y LA CONVIERTE A "16 de Marzo de 2026"
// SE USA EN LAS VISTAS PARA MOSTRAR FECHAS MÁS LEGIBLES QUE EL FORMATO DE LA BD
if (!function_exists('fecha_es')) {
    function fecha_es(string $fecha): string
    {
        // ARRAY CON LOS NOMBRES DE LOS MESES EN ESPAÑOL
        $meses = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];

        // CONVERTIMOS LA FECHA STRING A TIMESTAMP (NÚMERO DE SEGUNDOS DESDE 1970)
        $timestamp = strtotime($fecha);
        // EXTRAEMOS EL DÍA, MES Y AÑO DEL TIMESTAMP
        $dia = date('d', $timestamp);
        // BUSCAMOS EL NOMBRE DEL MES EN NUESTRO ARRAY
        $mes = $meses[date('m', $timestamp)];
        $anio = date('Y', $timestamp);

        // RETORNAMOS LA FECHA FORMATEADA EN ESPAÑOL
        return "$dia de $mes de $anio";
    }
}

// =============================================
// FUNCIÓN generar_slug: GENERA UNA URL AMIGABLE DESDE UN TEXTO
// =============================================
// RECIBE UN TEXTO COMO "El Padrino - Parte II" Y DEVUELVE "el-padrino-parte-ii"
if (!function_exists('generar_slug')) {
    function generar_slug(string $texto): string
    {
        // CONVERTIMOS TODO EL TEXTO A MINÚSCULAS
        $texto = strtolower($texto);
        // REEMPLAZAMOS LOS CARACTERES ACENTUADOS POR SUS EQUIVALENTES SIN ACENTO
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'u'],
            $texto
        );
        // REEMPLAZAMOS CUALQUIER CARÁCTER QUE NO SEA LETRA O NÚMERO POR UN GUIÓN
        $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
        // ELIMINAMOS GUIONES AL INICIO Y AL FINAL DEL TEXTO
        $texto = trim($texto, '-');
        // RETORNAMOS EL SLUG GENERADO
        return $texto;
    }
}

// =============================================
// FUNCIÓN badge_rol: GENERA UN BADGE HTML DE BOOTSTRAP CON EL ROL DEL USUARIO
// =============================================
// RECIBE EL ROL ('admin', 'editor', 'usuario') Y DEVUELVE UN SPAN CON CLASES BOOTSTRAP
if (!function_exists('badge_rol')) {
    function badge_rol(string $rol): string
    {
        // ARRAY QUE ASOCIA CADA ROL CON SU CLASE CSS DE BOOTSTRAP
        $clases = [
            'admin'   => 'bg-success',
            'editor'  => 'bg-warning text-dark',
            'usuario' => 'bg-info',
        ];
        // OBTENEMOS LA CLASE CSS DEL ROL; SI NO EXISTE, USAMOS GRIS (bg-secondary)
        $clase = $clases[$rol] ?? 'bg-secondary';
        // RETORNAMOS EL HTML DEL BADGE CON EL ROL EN MAYÚSCULAS
        return '<span class="badge ' . $clase . '">' . strtoupper(esc($rol)) . '</span>';
    }
}

// =============================================
// FUNCIÓN tiempo_relativo: MUESTRA "HACE X TIEMPO" EN VEZ DE LA FECHA EXACTA
// =============================================
// RECIBE UNA FECHA Y DEVUELVE "Hace 5 minutos", "Hace 3 horas", "Hace 2 días", ETC.
if (!function_exists('tiempo_relativo')) {
    function tiempo_relativo(string $fecha): string
    {
        // OBTENEMOS EL TIMESTAMP ACTUAL (AHORA)
        $ahora = time();
        // CONVERTIMOS LA FECHA RECIBIDA A TIMESTAMP
        $antes = strtotime($fecha);
        // CALCULAMOS LA DIFERENCIA EN SEGUNDOS ENTRE AHORA Y LA FECHA
        $diferencia = $ahora - $antes;

        // SI LA DIFERENCIA ES MENOR A 60 SEGUNDOS (1 MINUTO)
        if ($diferencia < 60) {
            return 'Hace un momento';
        } elseif ($diferencia < 3600) {
            // CALCULAMOS LOS MINUTOS DIVIDIENDO LOS SEGUNDOS ENTRE 60
            $minutos = floor($diferencia / 60);
            return "Hace {$minutos} minuto" . ($minutos > 1 ? 's' : '');
        } elseif ($diferencia < 86400) {
            // CALCULAMOS LAS HORAS DIVIDIENDO LOS SEGUNDOS ENTRE 3600
            $horas = floor($diferencia / 3600);
            return "Hace {$horas} hora" . ($horas > 1 ? 's' : '');
        } elseif ($diferencia < 2592000) {
            // CALCULAMOS LOS DÍAS DIVIDIENDO LOS SEGUNDOS ENTRE 86400
            $dias = floor($diferencia / 86400);
            return "Hace {$dias} día" . ($dias > 1 ? 's' : '');
        } else {
            // SI LA DIFERENCIA ES MAYOR A 30 DÍAS, MOSTRAMOS LA FECHA EN ESPAÑOL
            return fecha_es($fecha);
        }
    }
}

// =============================================
// FUNCIÓN texto_preview: RECORTA UN TEXTO Y AÑADE "..." AL FINAL
// =============================================
if (!function_exists('texto_preview')) {
    function texto_preview(string $texto, int $longitud = 100): string
    {
        // SI EL TEXTO ES MÁS CORTO QUE LA LONGITUD MÁXIMA, LO DEVOLVEMOS TAL CUAL
        if (mb_strlen($texto) <= $longitud) {
            return esc($texto);
        }
        // RECORTAMOS EL TEXTO A LA LONGITUD INDICADA (mb_ PARA MULTIBYTE: ACENTOS, Ñ)
        $recortado = mb_substr($texto, 0, $longitud);
        // BUSCAMOS EL ÚLTIMO ESPACIO PARA NO CORTAR UNA PALABRA POR LA MITAD
        $ultimoEspacio = mb_strrpos($recortado, ' ');
        if ($ultimoEspacio !== false) {
            $recortado = mb_substr($recortado, 0, $ultimoEspacio);
        }
        // RETORNAMOS EL TEXTO RECORTADO CON "..." AL FINAL, ESCAPADO PARA SEGURIDAD
        return esc($recortado) . '...';
    }
}

// =============================================
// FUNCIÓN tamano_archivo: FORMATEA UN TAMAÑO EN BYTES A KB, MB, GB
// =============================================
if (!function_exists('tamano_archivo')) {
    function tamano_archivo(int $bytes): string
    {
        // ARRAY CON LAS UNIDADES DE MEDIDA DE MENOR A MAYOR
        $unidades = ['B', 'KB', 'MB', 'GB'];
        // ÍNDICE QUE INDICA LA UNIDAD ACTUAL (EMPIEZA EN BYTES)
        $indice = 0;
        // MIENTRAS EL TAMAÑO SEA >= 1024, DIVIDIMOS Y SUBIMOS DE UNIDAD
        while ($bytes >= 1024 && $indice < count($unidades) - 1) {
            $bytes /= 1024;
            $indice++;
        }
        // RETORNAMOS EL TAMAÑO REDONDEADO A 2 DECIMALES CON SU UNIDAD
        return round($bytes, 2) . ' ' . $unidades[$indice];
    }
}
