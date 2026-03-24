<?php

// ESPACIO DE NOMBRES PARA LOS CONTROLADORES DE LA APP
namespace App\Controllers;

// IMPORTAMOS LA INTERFAZ DE RESPUESTA HTTP PARA VERIFICAR TIPOS DE RETORNO
use CodeIgniter\HTTP\ResponseInterface;

// CONTROLADOR BASE ABSTRACTO PARA AUTOMATIZAR LAS OPERACIONES CRUD
// SECCIÓN 25: SISTEMA CRUD AUTOMATIZADO
// ESTE CONTROLADOR CONTIENE TODA LA LÓGICA REPETITIVA DEL CRUD (INDEX, CREATE, STORE, EDIT, UPDATE, DELETE)
// LOS CONTROLADORES HIJOS (CATEGORÍA, ETIQUETA, ETC.) SOLO DEFINEN PROPIEDADES DE CONFIGURACIÓN
// Y SOBREESCRIBEN LOS MÉTODOS HOOK CUANDO NECESITAN COMPORTAMIENTO PERSONALIZADO (EJ: SUBIR IMAGEN)
abstract class CrudController extends BaseController
{
    // =============================================
    // PROPIEDADES QUE CADA CONTROLADOR HIJO DEBE DEFINIR
    // =============================================

    // NOMBRE COMPLETO DE LA CLASE DEL MODELO (INCLUYENDO NAMESPACE)
    // EJEMPLO: 'App\Models\CategoriaModel'
    protected string $modelClass = '';

    // INSTANCIA DEL MODELO (SE CREA AUTOMÁTICAMENTE EN EL CONSTRUCTOR)
    protected $modelo;

    // PREFIJO DE LAS VISTAS: NOMBRE DE LA CARPETA DENTRO DE app/Views/
    // EJEMPLO: 'categorias' → BUSCA EN app/Views/categorias/
    protected string $vistasPrefijo = '';

    // PREFIJO DE LA URL PARA REDIRECCIONES
    // EJEMPLO: '/categorias' → REDIRIGE A base_url('/categorias')
    protected string $rutaBase = '';

    // TÍTULO EN SINGULAR PARA LOS MENSAJES FLASH
    // EJEMPLO: 'Categoría' → "Categoría creado/a correctamente"
    protected string $tituloSingular = '';

    // TÍTULO EN PLURAL PARA EL TÍTULO DEL LISTADO
    // EJEMPLO: 'Categorías' → "Listado de Categorías"
    protected string $tituloPlural = '';

    // NOMBRE DE LA VARIABLE QUE SE PASA A LA VISTA INDEX
    // EJEMPLO: 'categorias' → $datos['categorias'] = ...
    protected string $variableLista = '';

    // NOMBRE DE LA VARIABLE QUE SE PASA A LA VISTA EDIT
    // EJEMPLO: 'categoria' → $datos['categoria'] = ...
    protected string $variableItem = '';

    // ARRAY CON LOS NOMBRES DE LOS CAMPOS DEL FORMULARIO
    // ESTOS CAMPOS SE LEEN DEL POST Y SE GUARDAN EN LA BD
    // EJEMPLO: ['titulo'] O ['titulo', 'descripcion', 'categoria_id']
    protected array $campos = [];

    // NÚMERO DE REGISTROS POR PÁGINA (0 = SIN PAGINACIÓN, TRAE TODOS)
    protected int $porPagina = 0;

    // =============================================
    // CONSTRUCTOR: CREA LA INSTANCIA DEL MODELO AUTOMÁTICAMENTE
    // =============================================
    public function __construct()
    {
        // SI SE DEFINIÓ UNA CLASE DE MODELO, CREAMOS SU INSTANCIA
        if (!empty($this->modelClass)) {
            // new $this->modelClass() CREA UNA INSTANCIA DE LA CLASE INDICADA
            // ES LO MISMO QUE HACER new CategoriaModel() PERO DINÁMICO
            $this->modelo = new $this->modelClass();
        }
    }

    // =============================================
    // MÉTODO INDEX: LISTADO PAGINADO DE REGISTROS
    // =============================================
    // OBTIENE TODOS LOS REGISTROS (O PAGINADOS) Y LOS PASA A LA VISTA INDEX
    public function index()
    {
        // PREPARAMOS EL TÍTULO PARA LA VISTA
        $datos['titulo'] = 'Listado de ' . $this->tituloPlural;

        // SI SE DEFINIÓ PAGINACIÓN (porPagina > 0), PAGINAMOS LOS RESULTADOS
        if ($this->porPagina > 0) {
            // paginate() TRAE SOLO $porPagina RESULTADOS Y CALCULA LAS PÁGINAS
            $datos[$this->variableLista] = $this->modelo
                ->orderBy('id', 'DESC')
                ->paginate($this->porPagina);
            // GUARDAMOS EL PAGER PARA GENERAR LOS ENLACES DE PAGINACIÓN EN LA VISTA
            $datos['pager'] = $this->modelo->pager;
        } else {
            // SIN PAGINACIÓN: TRAEMOS TODOS LOS REGISTROS
            $datos[$this->variableLista] = $this->modelo
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        // CARGAMOS LA VISTA INDEX DEL CONTROLADOR HIJO
        return view($this->vistasPrefijo . '/index', $datos);
    }

    // =============================================
    // MÉTODO CREATE: FORMULARIO DE CREACIÓN
    // =============================================
    // CARGA LA VISTA CON EL FORMULARIO VACÍO PARA CREAR UN NUEVO REGISTRO
    public function create()
    {
        // PREPARAMOS EL TÍTULO PARA LA VISTA
        $datos['titulo'] = 'Crear ' . $this->tituloSingular;

        // LLAMAMOS AL HOOK datosExtraFormulario() POR SI EL HIJO NECESITA
        // AÑADIR DATOS EXTRA (EJ: LISTA DE CATEGORÍAS PARA UN SELECT)
        $datos = $this->datosExtraFormulario($datos);

        // CARGAMOS LA VISTA CREATE DEL CONTROLADOR HIJO
        return view($this->vistasPrefijo . '/create', $datos);
    }

    // =============================================
    // MÉTODO STORE: GUARDAR NUEVO REGISTRO
    // =============================================
    // RECOGE LOS DATOS DEL FORMULARIO, LOS VALIDA Y LOS GUARDA EN LA BD
    public function store()
    {
        // RECOGEMOS LOS CAMPOS DEL POST DINÁMICAMENTE
        // EN VEZ DE ESCRIBIR $this->request->getPost('titulo') PARA CADA CAMPO,
        // RECORREMOS EL ARRAY DE CAMPOS Y LOS LEEMOS AUTOMÁTICAMENTE
        $datos = [];
        foreach ($this->campos as $campo) {
            // OBTENEMOS EL VALOR DEL CAMPO DEL POST
            $valor = $this->request->getPost($campo);
            // SI EL VALOR ES VACÍO O NULL, LO CONVERTIMOS A NULL
            // ESTO ES IMPORTANTE PARA CAMPOS OPCIONALES COMO categoria_id
            $datos[$campo] = ($valor === '' || $valor === null) ? null : $valor;
        }

        // LLAMAMOS AL HOOK antesDeGuardar() POR SI EL HIJO NECESITA
        // HACER ALGO ANTES (EJ: PROCESAR Y SUBIR UNA IMAGEN)
        $datos = $this->antesDeGuardar($datos);
        // SI EL HOOK DEVUELVE UNA RESPUESTA HTTP (EJ: REDIRECT CON ERROR), LA RETORNAMOS
        if ($datos instanceof ResponseInterface) {
            return $datos;
        }

        // INTENTAMOS GUARDAR USANDO EL MODELO; SI FALLA LA VALIDACIÓN, DEVUELVE FALSE
        if (!$this->modelo->save($datos)) {
            // REDIRIGIMOS AL FORMULARIO CON LOS DATOS Y LOS ERRORES
            return redirect()->back()->withInput()
                ->with('errors', $this->modelo->errors());
        }

        // LLAMAMOS AL HOOK despuesDeGuardar() POR SI EL HIJO NECESITA
        // HACER ALGO DESPUÉS (EJ: SINCRONIZAR ETIQUETAS EN LA TABLA PIVOTE)
        $this->despuesDeGuardar($this->modelo->getInsertID());

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url($this->rutaBase))
            ->with('mensaje', $this->tituloSingular . ' creado/a correctamente');
    }

    // =============================================
    // MÉTODO EDIT: FORMULARIO DE EDICIÓN
    // =============================================
    // BUSCA EL REGISTRO POR ID Y CARGA LA VISTA CON EL FORMULARIO PRECARGADO
    public function edit($id = null)
    {
        // BUSCAMOS EL REGISTRO POR SU ID
        $item = $this->modelo->find($id);
        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($item === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'No se encontró el/la ' . $this->tituloSingular
            );
        }

        // PREPARAMOS LOS DATOS PARA LA VISTA
        $datos['titulo'] = 'Editar ' . $this->tituloSingular;
        // PASAMOS EL REGISTRO ENCONTRADO A LA VISTA CON EL NOMBRE DE VARIABLE DEFINIDO
        $datos[$this->variableItem] = $item;

        // LLAMAMOS AL HOOK datosExtraFormulario() CON EL ID DEL REGISTRO
        $datos = $this->datosExtraFormulario($datos, $id);

        // CARGAMOS LA VISTA EDIT DEL CONTROLADOR HIJO
        return view($this->vistasPrefijo . '/edit', $datos);
    }

    // =============================================
    // MÉTODO UPDATE: ACTUALIZAR REGISTRO EXISTENTE
    // =============================================
    // RECOGE LOS DATOS DEL FORMULARIO, LOS VALIDA Y ACTUALIZA EL REGISTRO EN LA BD
    public function update($id = null)
    {
        // BUSCAMOS EL REGISTRO POR SU ID
        $item = $this->modelo->find($id);
        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($item === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'No se encontró el/la ' . $this->tituloSingular
            );
        }

        // RECOGEMOS LOS CAMPOS DEL POST DINÁMICAMENTE (IGUAL QUE EN STORE)
        $datos = [];
        foreach ($this->campos as $campo) {
            $valor = $this->request->getPost($campo);
            $datos[$campo] = ($valor === '' || $valor === null) ? null : $valor;
        }

        // LLAMAMOS AL HOOK antesDeActualizar() (EJ: PROCESAR NUEVA IMAGEN, BORRAR LA ANTERIOR)
        $datos = $this->antesDeActualizar($datos, $item);
        if ($datos instanceof ResponseInterface) {
            return $datos;
        }

        // INTENTAMOS ACTUALIZAR
        if (!$this->modelo->update($id, $datos)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->modelo->errors());
        }

        // LLAMAMOS AL HOOK despuesDeActualizar() (EJ: SINCRONIZAR ETIQUETAS)
        $this->despuesDeActualizar($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url($this->rutaBase))
            ->with('mensaje', $this->tituloSingular . ' actualizado/a correctamente');
    }

    // =============================================
    // MÉTODO DELETE: ELIMINAR REGISTRO
    // =============================================
    // BUSCA EL REGISTRO, EJECUTA LIMPIEZA PREVIA Y LO ELIMINA DE LA BD
    public function delete($id = null)
    {
        // BUSCAMOS EL REGISTRO POR SU ID
        $item = $this->modelo->find($id);
        // SI NO EXISTE, LANZAMOS ERROR 404
        if ($item === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'No se encontró el/la ' . $this->tituloSingular
            );
        }

        // LLAMAMOS AL HOOK antesDeEliminar() (EJ: BORRAR IMAGEN DEL SERVIDOR, BORRAR REGISTROS PIVOTE)
        $this->antesDeEliminar($id, $item);

        // ELIMINAMOS EL REGISTRO DE LA BD
        $this->modelo->delete($id);

        // REDIRIGIMOS AL LISTADO CON UN MENSAJE DE ÉXITO
        return redirect()->to(base_url($this->rutaBase))
            ->with('mensaje', $this->tituloSingular . ' eliminado/a correctamente');
    }

    // =============================================
    // MÉTODOS HOOK: LOS CONTROLADORES HIJOS LOS SOBREESCRIBEN PARA PERSONALIZAR
    // =============================================

    // HOOK: AÑADIR DATOS EXTRA AL FORMULARIO (EJ: LISTA DE CATEGORÍAS PARA UN SELECT)
    // SE LLAMA EN create() Y edit() PARA PREPARAR DATOS ADICIONALES PARA LA VISTA
    protected function datosExtraFormulario(array $datos, $id = null): array
    {
        // POR DEFECTO NO AÑADE NADA; LOS HIJOS LO SOBREESCRIBEN SI NECESITAN
        return $datos;
    }

    // HOOK: LÓGICA EXTRA ANTES DE GUARDAR UN NUEVO REGISTRO (EJ: SUBIR IMAGEN)
    // PUEDE DEVOLVER EL ARRAY DE DATOS MODIFICADO O UNA RESPUESTA HTTP (REDIRECT)
    protected function antesDeGuardar(array $datos)
    {
        return $datos;
    }

    // HOOK: LÓGICA EXTRA DESPUÉS DE GUARDAR UN NUEVO REGISTRO (EJ: SINCRONIZAR ETIQUETAS)
    protected function despuesDeGuardar($id): void
    {
    }

    // HOOK: LÓGICA EXTRA ANTES DE ACTUALIZAR UN REGISTRO (EJ: PROCESAR NUEVA IMAGEN)
    protected function antesDeActualizar(array $datos, array $item)
    {
        return $datos;
    }

    // HOOK: LÓGICA EXTRA DESPUÉS DE ACTUALIZAR UN REGISTRO (EJ: SINCRONIZAR ETIQUETAS)
    protected function despuesDeActualizar($id): void
    {
    }

    // HOOK: LÓGICA EXTRA ANTES DE ELIMINAR UN REGISTRO (EJ: BORRAR IMAGEN, BORRAR PIVOTE)
    protected function antesDeEliminar($id, array $item): void
    {
    }
}
