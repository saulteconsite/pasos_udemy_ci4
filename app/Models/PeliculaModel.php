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
    // SE AÑADEN categoria_id (RELACIÓN 1:N) E imagen (CARGA DE ARCHIVOS)
    protected $allowedFields = ['titulo', 'descripcion', 'categoria_id', 'imagen'];

    // ACTIVAR GESTIÓN AUTOMÁTICA DE CREATED_AT Y UPDATED_AT
    protected $useTimestamps = true;

    // REGLAS DE VALIDACIÓN QUE SE EJECUTAN AUTOMÁTICAMENTE AL USAR SAVE() O UPDATE()
    protected $validationRules = [
        // EL TÍTULO ES OBLIGATORIO, MÍNIMO 3 CARACTERES, MÁXIMO 150
        'titulo'       => 'required|min_length[3]|max_length[150]',
        // LA DESCRIPCIÓN ES OPCIONAL PERO SI SE ENVÍA NO PUEDE SUPERAR 5000 CARACTERES
        'descripcion'  => 'permit_empty|max_length[5000]',
        // LA CATEGORÍA ES OPCIONAL; SI SE ENVÍA DEBE SER UN NÚMERO ENTERO VÁLIDO
        'categoria_id' => 'permit_empty|is_natural_no_zero',
    ];

    // MENSAJES DE VALIDACIÓN PERSONALIZADOS EN ESPAÑOL
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
        'categoria_id' => [
            // MENSAJE CUANDO EL VALOR NO ES UN NÚMERO ENTERO POSITIVO
            'is_natural_no_zero' => 'DEBES SELECCIONAR UNA CATEGORÍA VÁLIDA.',
        ],
    ];

    // MÉTODO PERSONALIZADO PARA OBTENER PELÍCULAS CON EL NOMBRE DE SU CATEGORÍA
    // USA UN JOIN PARA TRAER EL TÍTULO DE LA CATEGORÍA JUNTO CON CADA PELÍCULA
    public function getPeliculasConCategoria()
    {
        // select() ESPECIFICA QUÉ COLUMNAS QUEREMOS TRAER
        // peliculas.* TRAE TODOS LOS CAMPOS DE PELICULAS
        // categorias.titulo AS categoria_nombre TRAE EL TÍTULO DE LA CATEGORÍA CON ALIAS
        return $this->select('peliculas.*, categorias.titulo AS categoria_nombre')
                     // JOIN LEFT PARA QUE TAMBIÉN APAREZCAN PELÍCULAS SIN CATEGORÍA
                     // SI UNA PELÍCULA NO TIENE CATEGORÍA, categoria_nombre SERÁ NULL
                     ->join('categorias', 'categorias.id = peliculas.categoria_id', 'left')
                     // ORDENAMOS POR ID DESCENDENTE (MÁS RECIENTES PRIMERO)
                     ->orderBy('peliculas.id', 'DESC')
                     // findAll() EJECUTA LA CONSULTA Y DEVUELVE TODOS LOS RESULTADOS
                     ->findAll();
    }

    // =============================================
    // SECCIÓN 18: MÉTODO PARA LISTADO PAGINADO CON FILTROS
    // =============================================
    // ESTE MÉTODO CONSTRUYE UNA CONSULTA DINÁMICA SEGÚN LOS FILTROS RECIBIDOS
    // Y DEVUELVE LOS RESULTADOS PAGINADOS (NO TODOS A LA VEZ)
    // RECIBE UN ARRAY DE FILTROS: busqueda, categoria_id, etiqueta_id
    // RECIBE EL NÚMERO DE RESULTADOS POR PÁGINA (POR DEFECTO 5)
    public function getPeliculasFiltradas($filtros = [], $porPagina = 5)
    {
        // INICIAMOS LA CONSULTA CON SELECT Y JOIN IGUAL QUE getPeliculasConCategoria()
        // peliculas.* TRAE TODOS LOS CAMPOS DE LA TABLA PELICULAS
        // categorias.titulo AS categoria_nombre TRAE EL NOMBRE DE LA CATEGORÍA
        $builder = $this->select('peliculas.*, categorias.titulo AS categoria_nombre')
                        // LEFT JOIN PARA INCLUIR PELÍCULAS SIN CATEGORÍA
                        ->join('categorias', 'categorias.id = peliculas.categoria_id', 'left');

        // =============================================
        // FILTRO 1: BÚSQUEDA POR TEXTO (LIKE AGRUPADO)
        // =============================================
        // SI EL USUARIO ESCRIBIÓ ALGO EN EL CAMPO DE BÚSQUEDA
        if (!empty($filtros['busqueda'])) {
            // groupStart() ABRE UN PARÉNTESIS EN LA CONSULTA SQL: WHERE (...)
            // ESTO AGRUPA LAS CONDICIONES OR PARA QUE NO INTERFIERAN CON OTROS FILTROS
            // SIN AGRUPAR: WHERE titulo LIKE '%matrix%' OR descripcion LIKE '%matrix%' AND categoria_id = 5
            // CON AGRUPAR: WHERE (titulo LIKE '%matrix%' OR descripcion LIKE '%matrix%') AND categoria_id = 5
            $builder->groupStart()
                        // like() BUSCA COINCIDENCIAS PARCIALES EN EL TÍTULO
                        // 'both' SIGNIFICA QUE BUSCA %texto% (COINCIDE EN CUALQUIER POSICIÓN)
                        ->like('peliculas.titulo', $filtros['busqueda'], 'both')
                        // orLike() TAMBIÉN BUSCA EN LA DESCRIPCIÓN (OR = CUALQUIERA DE LOS DOS)
                        ->orLike('peliculas.descripcion', $filtros['busqueda'], 'both')
                    // groupEnd() CIERRA EL PARÉNTESIS
                    ->groupEnd();
        }

        // =============================================
        // FILTRO 2: FILTRAR POR CATEGORÍA
        // =============================================
        // SI EL USUARIO SELECCIONÓ UNA CATEGORÍA EN EL SELECT
        if (!empty($filtros['categoria_id'])) {
            // where() AÑADE UNA CONDICIÓN EXACTA: categoria_id = X
            $builder->where('peliculas.categoria_id', $filtros['categoria_id']);
        }

        // =============================================
        // FILTRO 3: FILTRAR POR ETIQUETA
        // =============================================
        // SI EL USUARIO SELECCIONÓ UNA ETIQUETA EN EL SELECT
        if (!empty($filtros['etiqueta_id'])) {
            // JOIN CON LA TABLA PIVOTE PARA FILTRAR POR ETIQUETA
            // INNER JOIN PORQUE SOLO QUEREMOS PELÍCULAS QUE TENGAN ESA ETIQUETA
            $builder->join('pelicula_etiqueta', 'pelicula_etiqueta.pelicula_id = peliculas.id', 'inner')
                    // CONDICIÓN: QUE LA ETIQUETA SEA LA SELECCIONADA
                    ->where('pelicula_etiqueta.etiqueta_id', $filtros['etiqueta_id']);
        }

        // ORDENAMOS POR ID DESCENDENTE (MÁS RECIENTES PRIMERO)
        $builder->orderBy('peliculas.id', 'DESC');

        // paginate() EJECUTA LA CONSULTA PERO SOLO DEVUELVE $porPagina RESULTADOS
        // CODEIGNITER CALCULA AUTOMÁTICAMENTE EL OFFSET SEGÚN LA PÁGINA ACTUAL (GET ?page=2)
        // ADEMÁS GENERA INTERNAMENTE EL OBJETO PAGER QUE USAMOS EN LA VISTA PARA LOS ENLACES
        return $builder->paginate($porPagina);
    }
}
