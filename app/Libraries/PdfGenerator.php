<?php

// ESPACIO DE NOMBRES PARA LAS LIBRERÍAS PERSONALIZADAS DE LA APP
namespace App\Libraries;

// LIBRERÍA PERSONALIZADA PARA GENERAR DOCUMENTOS PDF EN HTML
// ENCAPSULA LA LÓGICA DE GENERACIÓN DE PDFs PARA QUE SEA REUTILIZABLE
// EN UN PROYECTO REAL SE INTEGRARÍA CON DOMPDF, TCPDF U OTRA LIBRERÍA PDF
class PdfGenerator
{
    // PROPIEDAD PARA ALMACENAR EL TÍTULO DEL DOCUMENTO PDF
    protected $tituloPdf;

    // PROPIEDAD PARA ALMACENAR EL CONTENIDO HTML DEL DOCUMENTO
    protected $contenidoPdf;

    // PROPIEDAD PARA DEFINIR LA ORIENTACIÓN DEL DOCUMENTO (portrait O landscape)
    protected $orientacionPdf = 'portrait';

    // MÉTODO PARA ESTABLECER EL TÍTULO DEL PDF
    // RETORNA $this PARA PERMITIR ENCADENAMIENTO DE MÉTODOS (METHOD CHAINING)
    // EJEMPLO: $pdf->setTitulo('Mi PDF')->setContenido('<p>Hola</p>')->generar()
    public function setTitulo(string $titulo): self
    {
        // GUARDAMOS EL TÍTULO EN LA PROPIEDAD
        $this->tituloPdf = $titulo;
        // RETORNAMOS LA INSTANCIA PARA PERMITIR ENCADENAR
        return $this;
    }

    // MÉTODO PARA ESTABLECER EL CONTENIDO HTML DEL PDF
    // RETORNA $this PARA PERMITIR ENCADENAMIENTO DE MÉTODOS
    public function setContenido(string $contenido): self
    {
        // GUARDAMOS EL CONTENIDO EN LA PROPIEDAD
        $this->contenidoPdf = $contenido;
        // RETORNAMOS LA INSTANCIA PARA PERMITIR ENCADENAR
        return $this;
    }

    // MÉTODO PARA ESTABLECER LA ORIENTACIÓN DEL PDF
    // OPCIONES: 'portrait' (VERTICAL) O 'landscape' (HORIZONTAL)
    public function setOrientacion(string $orientacion): self
    {
        // GUARDAMOS LA ORIENTACIÓN EN LA PROPIEDAD
        $this->orientacionPdf = $orientacion;
        // RETORNAMOS LA INSTANCIA PARA PERMITIR ENCADENAR
        return $this;
    }

    // MÉTODO PRINCIPAL QUE GENERA EL HTML DEL PDF
    // EN UN PROYECTO REAL AQUÍ USARÍAMOS DOMPDF PARA CONVERTIR HTML A PDF BINARIO
    // POR AHORA GENERAMOS HTML QUE PUEDE SER CONVERTIDO A PDF
    public function generar(): string
    {
        // CONSTRUIMOS LA ESTRUCTURA HTML COMPLETA DEL DOCUMENTO
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="es">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        // USAMOS esc() PARA ESCAPAR EL TÍTULO Y PREVENIR XSS
        $html .= '<title>' . esc($this->tituloPdf) . '</title>';
        // ESTILOS CSS INLINE PARA EL DOCUMENTO PDF
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; margin: 20px; color: #333; }';
        $html .= 'h1 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 15px; }';
        $html .= 'th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }';
        $html .= 'th { background-color: #2c3e50; color: white; }';
        $html .= 'tr:nth-child(even) { background-color: #f2f2f2; }';
        $html .= '.footer { margin-top: 30px; text-align: center; color: #888; font-size: 12px; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        // TÍTULO PRINCIPAL DEL DOCUMENTO
        $html .= '<h1>' . esc($this->tituloPdf) . '</h1>';
        // CONTENIDO DEL DOCUMENTO (YA FORMATEADO POR EL MÉTODO QUE LLAMA A generar())
        $html .= $this->contenidoPdf;
        // PIE DE PÁGINA CON LA FECHA DE GENERACIÓN
        $html .= '<div class="footer">Generado el ' . date('d/m/Y H:i:s') . ' | CI4 Udemy</div>';
        $html .= '</body>';
        $html .= '</html>';

        // RETORNAMOS EL HTML COMPLETO DEL DOCUMENTO
        return $html;
    }

    // MÉTODO ESPECÍFICO PARA GENERAR UN PDF CON LA FICHA DE UNA PELÍCULA
    // RECIBE UN ARRAY CON LOS DATOS DE LA PELÍCULA Y GENERA EL HTML FORMATEADO
    public function peliculaPdf(array $pelicula): string
    {
        // ESTABLECEMOS EL TÍTULO DEL PDF CON EL NOMBRE DE LA PELÍCULA
        $this->setTitulo('Ficha de Película: ' . ($pelicula['titulo'] ?? 'Sin título'));

        // CONSTRUIMOS UNA TABLA HTML CON LOS DATOS DE LA PELÍCULA
        $contenido = '<table>';
        // CABECERA DE LA TABLA
        $contenido .= '<tr><th>Campo</th><th>Valor</th></tr>';
        // FILA CON EL ID
        $contenido .= '<tr><td><strong>ID</strong></td><td>' . ($pelicula['id'] ?? '-') . '</td></tr>';
        // FILA CON EL TÍTULO (ESCAPADO CON esc() PARA SEGURIDAD)
        $contenido .= '<tr><td><strong>Título</strong></td><td>' . esc($pelicula['titulo'] ?? '') . '</td></tr>';
        // FILA CON LA DESCRIPCIÓN
        $contenido .= '<tr><td><strong>Descripción</strong></td><td>' . esc($pelicula['descripcion'] ?? 'Sin descripción') . '</td></tr>';
        // FILA CON EL NOMBRE DE LA CATEGORÍA (SI TIENE)
        $contenido .= '<tr><td><strong>Categoría</strong></td><td>' . esc($pelicula['categoria_nombre'] ?? 'Sin categoría') . '</td></tr>';
        // FILA CON LA IMAGEN (SI TIENE)
        $contenido .= '<tr><td><strong>Imagen</strong></td><td>' . (!empty($pelicula['imagen']) ? 'Sí (' . esc($pelicula['imagen']) . ')' : 'No tiene') . '</td></tr>';
        // FILA CON LA FECHA DE CREACIÓN
        $contenido .= '<tr><td><strong>Fecha de creación</strong></td><td>' . ($pelicula['created_at'] ?? '-') . '</td></tr>';
        // CERRAMOS LA TABLA
        $contenido .= '</table>';

        // ESTABLECEMOS EL CONTENIDO Y GENERAMOS EL HTML
        $this->setContenido($contenido);
        return $this->generar();
    }

    // MÉTODO PARA GENERAR UN PDF CON EL LISTADO DE PELÍCULAS
    // RECIBE UN ARRAY DE PELÍCULAS Y GENERA UNA TABLA CON TODAS
    public function listadoPeliculasPdf(array $peliculas): string
    {
        // ESTABLECEMOS EL TÍTULO DEL PDF
        $this->setTitulo('Listado de Películas (' . count($peliculas) . ' registros)');

        // CONSTRUIMOS UNA TABLA HTML CON TODAS LAS PELÍCULAS
        $contenido = '<table>';
        // CABECERA DE LA TABLA CON LAS COLUMNAS
        $contenido .= '<tr>';
        $contenido .= '<th>ID</th>';
        $contenido .= '<th>Título</th>';
        $contenido .= '<th>Categoría</th>';
        $contenido .= '<th>Creado</th>';
        $contenido .= '</tr>';

        // RECORREMOS CADA PELÍCULA Y AÑADIMOS UNA FILA A LA TABLA
        foreach ($peliculas as $pelicula) {
            $contenido .= '<tr>';
            $contenido .= '<td>' . ($pelicula['id'] ?? '-') . '</td>';
            $contenido .= '<td>' . esc($pelicula['titulo'] ?? '') . '</td>';
            $contenido .= '<td>' . esc($pelicula['categoria_nombre'] ?? 'Sin categoría') . '</td>';
            $contenido .= '<td>' . ($pelicula['created_at'] ?? '-') . '</td>';
            $contenido .= '</tr>';
        }

        // CERRAMOS LA TABLA
        $contenido .= '</table>';

        // ESTABLECEMOS EL CONTENIDO Y GENERAMOS EL HTML
        $this->setContenido($contenido);
        return $this->generar();
    }
}
