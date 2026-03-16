<?php

// ESPACIO DE NOMBRES PARA LOS MODELOS DE LA APP
namespace App\Models;

// IMPORTAMOS LA CLASE BASE MODEL DE CODEIGNITER
use CodeIgniter\Model;

// MODELO QUE REPRESENTA LA TABLA PIVOTE pelicula_etiqueta
// ESTA TABLA INTERMEDIA GESTIONA LA RELACIÓN MUCHOS A MUCHOS (N:M)
// ENTRE PELÍCULAS Y ETIQUETAS
class PeliculaEtiquetaModel extends Model
{
    // NOMBRE DE LA TABLA PIVOTE EN LA BASE DE DATOS
    protected $table      = 'pelicula_etiqueta';

    // CAMPO QUE ACTÚA COMO CLAVE PRIMARIA
    protected $primaryKey = 'id';

    // CAMPOS QUE SE PUEDEN INSERTAR/ACTUALIZAR
    // pelicula_id: ID DE LA PELÍCULA
    // etiqueta_id: ID DE LA ETIQUETA
    protected $allowedFields = ['pelicula_id', 'etiqueta_id'];

    // NO USAMOS TIMESTAMPS EN LA TABLA PIVOTE (NO TIENE created_at NI updated_at)
    protected $useTimestamps = false;

    // MÉTODO PARA OBTENER TODAS LAS ETIQUETAS ASIGNADAS A UNA PELÍCULA
    // RECIBE EL ID DE LA PELÍCULA Y DEVUELVE UN ARRAY CON LOS IDs DE SUS ETIQUETAS
    public function getEtiquetasDePelicula($peliculaId)
    {
        // BUSCAMOS TODOS LOS REGISTROS DE LA TABLA PIVOTE QUE TENGAN ESE pelicula_id
        // select('etiqueta_id') SOLO TRAE LA COLUMNA etiqueta_id
        // findColumn() DEVUELVE UN ARRAY PLANO DE VALORES (NO ARRAY DE ARRAYS)
        return $this->where('pelicula_id', $peliculaId)
                     ->findColumn('etiqueta_id') ?? [];
        // SI NO HAY RESULTADOS, DEVOLVEMOS UN ARRAY VACÍO
    }

    // MÉTODO PARA SINCRONIZAR LAS ETIQUETAS DE UNA PELÍCULA
    // ELIMINA LAS ANTERIORES Y ASIGNA LAS NUEVAS (COMO UN "SYNC")
    public function sincronizar($peliculaId, array $etiquetaIds)
    {
        // PRIMERO ELIMINAMOS TODAS LAS ETIQUETAS ACTUALES DE ESA PELÍCULA
        $this->where('pelicula_id', $peliculaId)->delete();

        // LUEGO INSERTAMOS LAS NUEVAS ETIQUETAS UNA POR UNA
        foreach ($etiquetaIds as $etiquetaId) {
            // INSERTAMOS UN REGISTRO EN LA TABLA PIVOTE CON EL PAR película-etiqueta
            $this->insert([
                'pelicula_id' => $peliculaId,
                'etiqueta_id' => $etiquetaId,
            ]);
        }
    }
}
