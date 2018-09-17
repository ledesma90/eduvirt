<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Personas_buscador extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();
          $this->load->model('manejador');
          $this->load->helper('clase_dinamica');
          $this->load->library('funciones');
          $this->load->library('table');
          $this->load->helper('form');
          $this->load->helper('security');
          $this->funciones->salir();

        }
 
//============================================================================================================================================
// Nombre de las funciones de configuraciones                                                                                                1
//============================================================================================================================================
    var $nombres_config=array('tabla1');
//============================================================================================================================================
// Fin de los nombres de las funciones de configuraciones                                                                                    1
//============================================================================================================================================
       var $tabla1 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "personas.id_usuario","nombre","apellido","ruc","documento_identidad","email","genero","to_char(fecha_nacimiento,'dd/mm/yyyy') as fecha_nacimiento","estado","get_user_nombre(personas.id_usuario) as nombre_usuario","encode(imagen, 'base64') as imagen"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_usuario"
                ],
                "columnas_actualizables" =>  [
                    "nombre","apellido","ruc","documento_identidad","email","genero","fecha_nacimiento"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "nombre"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Nombre:',
                    'placeholder' => 'Nombre',
                    'fila' => 'ini',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "apellido"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Apellido:',
                    'placeholder' => 'Apellido',
                    'fila' => 'fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "ruc"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Ruc:',
                    'placeholder' => 'Ruc',
                    'fila' => 'ini',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask' => "'mask': '9{0,28}-9{0,2}'",
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "documento_identidad"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'C.I.:',
                    'placeholder' => 'Documento de Identidad',
                    'fila' => 'medio',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask-integer' => "",
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "genero"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Genero:',
                    'fila' => 'fin',
                    'class' => 'form-control',
                    'maxlength' => '1',
                    'dimension_input' => '4',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['M' => 'Masculino','F' => 'Femenino'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "fecha_nacimiento"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Fecha de Nacimiento',
                    'placeholder' => 'Fecha de Nacimiento',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                    'style' => 'text-align: left; width: 100%;',
                    'datepicker' => '',
                    ],
                    "bloque1"=>[
                    'tipo' => 'bloque',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => ' ',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'value' => 'Bloque de trabajo',
                    'dimension_input' => '12',
                    'type' => 'button',
                    'style' => 'background-color: lightblue; width: 100%;',
                    ],
                    "email"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Email:',
                    'placeholder' => 'Email',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'data-inputmask' => "'alias': 'email'",
                    'style' => "text-align: left; width: 100%;",
                    ]
                ],
                "update_table" => "personas",
                "join" => "personas left outer join usuarios on (personas.id_usuario=usuarios.id_usuario)",
                "where" => "get_like_busqueda_persona(get_user_nombre(personas.id_usuario),nombre,apellido,email) like'%'||upper(:id_buscador)||'%'",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','N','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini',
                'columna' => 'ini',
                'dimension_tabla' => '8',
                'titulo' => 'Resutados de la busqueda',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       var $tabla2 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_direccion","id_usuario","id_barrio","get_ubicacion(id_barrio) as ubicacion","direccion","tipo","principal"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_direccion"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","id_barrio","direccion","tipo","principal"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4'
                    ],
                    "id_barrio"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Ubicación:',
                    'placeholder' => 'Busqueda',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => 'select id_barrio as id, get_ubicacion(id_barrio) as valor from barrios order by nombre',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "direccion"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Dirección:',
                    'placeholder' => 'Dirección',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    ],
                    "tipo"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Tipo:',
                    'placeholder' => 'Tipo',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['1' => 'Casa','2' => 'Departamento'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "principal"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Principal:',
                    'placeholder' => 'Principal',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['1' => 'Principal','2' => 'Secundario'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "direcciones",
                "join" => "direcciones",
                "where" => "id_usuario=:1",//si se declara la tabla padre solo se puede usar una variable
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Direcciones de la persona',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       var $tabla3 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_topico","id_usuario","id_categoria","topic","tema","get_usuario_nombre(id_usuario) as nombre_usuario","get_count_comentarios(id_topico) as cantidad_respuestas","get_ultimo_comentario(id_topico) as ultimo_comentario"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_topico"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","id_categoria","topic","tema"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'type'  => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Usuario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "id_categoria"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Categoria:',
                    'placeholder' => 'Categoria',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => 'select id_categoria as id, categoria as valor from categoria_topicos',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "topic"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Nombre del Topic:',
                    'placeholder' => 'Topico',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "tema"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Descripción del Topico:',
                    'placeholder' => 'Tema',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ]
                ],
                "update_table" => "topicos",
                "join" => "topicos",
                "where" => "id_usuario = :1 order by id_topico desc",
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','N','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '6',
                'titulo' => 'Topicos de la Persona',
                'class_tabla' => 'display compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
           
           var $tabla4 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_curso", "nombre", "id_usuario", "estado", "duracion", "descripcion", "categoria"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_curso"
                ],
                "columnas_actualizables" =>  [
                    "nombre", "id_usuario", "estado", "duracion", "descripcion", "categoria"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_curso"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Id:',
                    'placeholder' => 'Codigo Curso',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "nombre"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Curso:',
                    'placeholder' => 'Nombre del Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "id_usuario"=>[
                    'type'  => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Usuario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "estado"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Estado:',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '1',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['A' => 'Activo','I' => 'Inactivo'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "duracion"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Durcaión:',
                    'placeholder' => 'Tiempo estimativo del Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '80',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "descripcion"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Descripción:',
                    'placeholder' => 'Información relevante del Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '80',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "categoria"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Categoria:',
                    'placeholder' => 'Categoria',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => 'select id_categoria as id, nombre as valor from cursos_categoria',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "cursos",
                "join" => "cursos",
                "where" => "id_usuario=:1",
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Cursos De la Persona',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
           
           var $tabla5 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_curso", "nombre", "id_usuario", "estado", "duracion", "descripcion", "categoria"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_curso"
                ],
                "columnas_actualizables" =>  [
                    "nombre", "id_usuario", "estado", "duracion", "descripcion", "categoria"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_curso"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Id:',
                    'placeholder' => 'Codigo Curso',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "nombre"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Curso:',
                    'placeholder' => 'Nombre del Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "id_usuario"=>[
                    'type'  => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Usuario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "estado"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Estado:',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '1',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['A' => 'Activo','I' => 'Inactivo'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "duracion"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Durcaión:',
                    'placeholder' => 'Tiempo estimativo del Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '80',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "descripcion"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Descripción:',
                    'placeholder' => 'Información relevante del Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '80',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "categoria"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Categoria:',
                    'placeholder' => 'Categoria',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => 'select id_categoria as id, nombre as valor from cursos_categoria',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "cursos_inscriptos",
                "join" => "cursos",
                "where" => "id_curso in (select id_curso from cursos_x_alumnos where id_usuario=:1)",
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Cursos Inscriptos de la Persona',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
           
           var $tabla6 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id","proyectos_x_personas.id_usuario", "proyectos_x_personas.id_proyecto", "usuarios.usuario", "instituciones.nombre||' - '||proyectos.nombre as nombre"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario", "id_proyecto"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Integrante:',
                    'placeholder' => 'Busque el usuario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => 'select id_usuario as id, usuario as valor from usuarios',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "id_proyecto"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Proyecto:',
                    'placeholder' => 'Busque el proyecto',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => 'select id_proyecto as id, instituciones.nombre ||\' - \'|| proyectos.nombre as valor from proyectos inner join instituciones on (proyectos.id_institucion=instituciones.id_institucion)',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "proyectos_x_personas",
                "join" => "proyectos_x_personas left outer join usuarios on (proyectos_x_personas.id_usuario=usuarios.id_usuario) left outer join proyectos on (proyectos_x_personas.id_proyecto=proyectos.id_proyecto) left outer join instituciones on (instituciones.id_institucion=proyectos.id_institucion)",
                "where" => "proyectos_x_personas.id_proyecto in (select id_proyecto from proyectos_x_personas where id_usuario=:1)",
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'fin',
                'dimension_tabla' => '6',
                'titulo' => 'Proyectos de la Persona',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
       var $tabla7 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "p.id_usuario","usuario","null as password","estado","encode(imagen, 'base64') as imagen"
                ],
                "calculado" =>  [
                    "Caccion"
                ],
                "clave_primaria" =>  [
                    "id_usuario"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","usuario","estado"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Usuario:',
                    'placeholder' => 'Usuario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "password"=>[
                    'tipo' => 'password',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Contraseña:',
                    'placeholder' => 'Contraseña',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "estado"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Estado:',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '1',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['A' => 'Activo','I' => 'Inactivo'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "usuarios",
                "join" => "usuarios as p",
                "where" => "id_usuario=:1",//si se declara la tabla padre solo se puede usar una variable
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'ini',
                'dimension_tabla' => '4',
                'titulo' => 'Datos del Usuario',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       var $tabla8 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_rol_x_usuario","id_usuario","id_rol"," (select rol from roles where id_rol=roles_x_usuarios.id_rol) as rol"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_rol_x_usuario"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","id_rol"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_rol_x_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo Rol del Usuario:',
                    'placeholder' => 'Codigo Identificador',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "id_rol"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Id:',
                    'placeholder' => 'Codigo Rol',
                    'fila' => 'fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;",
                    'select_dato' => 'select id_rol as id, rol as valor from roles order by rol',//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "roles_x_usuarios",
                "join" => "roles_x_usuarios",
                "where" => "id_usuario=:1",//si se declara la tabla padre solo se puede usar una variable
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Roles del Usuario',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       var $tabla9 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_telefono","id_usuario","telefono","tipo","principal"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_telefono"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","telefono","tipo","principal"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12'
                    ],
                    "telefono"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Telefono:',
                    'placeholder' => 'Telefono',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'data-inputmask-phone' => "",
                    'dimension_input' => '12'
                    ],
                    "tipo"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Tipo:',
                    'placeholder' => 'Tipo',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['1' => 'Movil','2' => 'Fijo'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "principal"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Principal:',
                    'placeholder' => 'Principal',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['1' => 'Principal','2' => 'Secundario'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "telefonos",
                "join" => "telefonos",
                "where" => "id_usuario=:1",//si se declara la tabla padre solo se puede usar una variable
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Telefonos de la persona',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
       var $tabla10 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "contactos.id_usuario", "contacto", "nuevo_mensaje", "get_user_nombre(contacto) as nombre_usuario", "encode(imagen, 'base64') as imagen"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_usuario"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","contacto","nuevo_mensaje"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12'
                    ],
                    "contacto"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Telefono:',
                    'placeholder' => 'Telefono',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'data-inputmask-phone' => "",
                    'dimension_input' => '12'
                    ],
                    "nuevo_mensaje"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Tipo:',
                    'placeholder' => 'Tipo',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['1' => 'Movil','2' => 'Fijo'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ]
                ],
                "update_table" => "contactos",
                "join" => "contactos inner join usuarios on (contactos.contacto=usuarios.id_usuario)",
                "where" => "contactos.id_usuario=:1",//si se declara la tabla padre solo se puede usar una variable
                "lectura_where_variables" => [':1' =>['id_usuario','P']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["personas","id_usuario"],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'fin',
                'columna' => 'fin',
                'dimension_tabla' => '4',
                'titulo' => 'Contactos de la Persona',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
        
        
//============================================================================================================================================
// CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                                   2-3
//============================================================================================================================================
        public function config($array=null,$opcion=null,$datos=null)
	{   
            return $this->opraciones_basicas($opcion,$datos,$array);
	}
        
//============================================================================================================================================
// FIN DE LA CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                         2-3
//============================================================================================================================================

        public function opraciones_basicas($opcion=null,$datos=null,$config=null)
	{
            $manejador=$this->manejador->transaccion($config);
            if($opcion==null){
            return $manejador;
            }
            if($opcion=='result'){
            return json_encode($this->manejador->getdatos($manejador,$datos));
            }
            if($opcion=='resultsql'){
            return $this->manejador->getdatossql($manejador,$datos);
            }
            if(is_array($datos)){
            $objeto=$manejador->crearObjeto($datos);
                if ($opcion=='update'){
                return $this->manejador->update($objeto);
                }
                if ($opcion=='delete'){
                return $this->manejador->delete($objeto);
                }
                if ($opcion=='getid'){
                return $this->manejador->getid($objeto);
                }
            }
            if($opcion=='table'){
                $estructura_tabla  = '';
                
                if ('ini'===$config[0]['fila'] || 'ini-fin'===$config[0]['fila']){
                                $estructura_tabla .= '<div class="row">';
                }
                
                if ('ini'===$config[0]['columna'] || 'ini-fin'===$config[0]['columna']){
                                $estructura_tabla .= '<div class="col-xs-'.$config[0]['dimension_tabla'].'">';
                }
                
                $estructura_tabla .= '
            <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">'.$config[0]['titulo'].'</h3>
              <div class="box-tools pull-right">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">';
                if($config[0]['action']['visible']=='S'){
                $estructura_tabla .= '
                  <div class="btn-group" style="padding: 0px 0px 3px 0px;">
                  <button type="button" class="btn btn-info">Acción</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">';
                if($config[0]['action']['opciones'][0]=='S'){$estructura_tabla .= '<li><a id="insertar'.$config[0]['update_table'].'">Insertar</a></li>';};
                if($config[0]['action']['opciones'][1]=='S'){$estructura_tabla .= '<li><a id="modificar'.$config[0]['update_table'].'">Modificar</a></li>';};
                if($config[0]['action']['opciones'][2]=='S'){$estructura_tabla .= '<li><a id="borrar'.$config[0]['update_table'].'">Borrar</a></li>';};
                if($config[0]['action']['opciones'][3]=='S'){$estructura_tabla .= '<li class="divider"></li>
                    <li><a id="leer'.$config[0]['update_table'].'">Leer</a></li>';};
                $estructura_tabla .=  '</ul>
                </div>';
                }
                
                
                //$estructura_tabla .= '<button id="insertar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul" style="margin-right: 1px; margin-top: 1px; width: 100px;" type="button">Insertar</button>';
                //$estructura_tabla .= '<button id="modificar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul" style="margin-right: 1px; margin-top: 1px; width: 100px;" type="button">Modificar</button>';
                //$estructura_tabla .= '<button id="borrar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul" style="margin-right: 1px; margin-top: 1px; width: 100px;" type="button">Borrar</button>';
                //$estructura_tabla .= '<button id="leer'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul" style="margin-right: 1px; margin-top: 1px; width: 100px;" type="button">Leer</button>';
                $estructura_tabla .= $this->manejador->gettable($config[0], array_merge($config[0]["select"],$config[0]["calculado"]));
                $estructura_tabla .= '<div class="ajax-content">
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          ';
                
                if ('fin'===$config[0]['columna'] || 'ini-fin'===$config[0]['columna']){
                                $estructura_tabla .= '</div>';
                }
                
                if ('fin'===$config[0]['fila'] || 'ini-fin'===$config[0]['fila']){
                                $estructura_tabla .= '</div>';
                }
                
                return $estructura_tabla;
                
                
            }
            if($opcion=='configname'){
                return $this->manejador->getselectname($config);
            }
            if($opcion=='sqlmanual'){
                return $this->manejador->sqlmanual($manejador,$datos);
            }
	}



        
        
	public function index()
	{   
            
//============================================================================================================================================
// SE CREA LA TABLA CON SU NOMBRE PARA LA VISTA                                                                                              3
//============================================================================================================================================
            $pila=$this->ejecucion_primaria();
            $tablas_estructuras='';
            foreach ($this->nombres_config as $value) {
                $tablas_estructuras .= $this->config($this->$value,'table');
            }
            
            $estructura = [
                "dato" => $tablas_estructuras,
                "titulo_general" => "Personas",
                "id_usuario" => $this->session->userdata('id_usuario'),
                "usuario" => $this->session->userdata('usuario'),
                "imagen" => $this->session->userdata('imagen'),
                "tipo" => $pila
            ];
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
            

            $this->load->view('general/cabecera');  

            $this->load->view('general/menu',$estructura);//funciona
            $this->load->view('general/menu_izquierdo',$estructura);//funciona
            $this->load->view('general/contenido',$estructura);
            
            foreach ($this->nombres_config as $value) {
                
                $this->load->view('general/formulario_modal',["dato" => $this->config($this->{$value},'configname')]);
                
            }
            
            $this->load->view('general/pie');
            $this->load->view('general/menu_derecho');//parece funcionar
            $this->load->view('general/scripts',["dato" => $this->config($this->tabla1,'configname'),"segmento" => base_url().$this->router->fetch_class().'/']);

	}

        public function axtis()
	{
            $clase=$this->router->fetch_class();
            foreach ($this->nombres_config as $value) {
                $this->load->view($clase.'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->$value,'configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url()]);
            }
	}
        
        
       
        public function grabardatos()
	{
        
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $valores= array_values($this->input->post('parametros'));
                    //echo var_dump($valores);
                    $this->config($this->$value,'update',$this->funciones->verificar_array($valores));
                    //var_dump($this->funciones->verificar_array($valores));
                }

            }
	}

        
        public function borrardatos()
	{
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $valores= array_values($this->input->post('parametros'));
                    $this->config($this->$value,'delete',$this->funciones->verificar_array($valores));
                }

            }
	}
        
        
        public function result()
	{   
            foreach ($this->nombres_config as $value) {
                //$this->input->post('parametros',true)[1]
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    
                    //echo var_dump($this->input->post('parametros'));
                    ///if($this->input->post('tipo',true)=='personas'){
                    //echo $this->config($this->$value,'resultsql',  $this->funciones->strReplaceAssoc($this->input->post('parametros'),$this->{$value}[0]['where']));
                    //echo $this->funciones->strReplaceAssoc($this->input->post('parametros'),$this->{$value}[0]['where']);
                    //}else{
                    echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc($this->input->post('parametros'),$this->{$value}[0]['where']));
                    //}
                }

            }
	}
        
        public function grabarimagen()
	{
            
                $target_path = "imagenes/";
                opendir($target_path);
                $target_path = $target_path.$_FILES['uploadedfile']['name']; 
                if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) { 
                    echo "El archivo ". $_FILES['uploadedfile']['name']. " ha sido subido";
                } else{
                echo "Ha ocurrido un error, trate de nuevo!";
                
                }
            
            
                //echo $data;
            //'https://images2.alphacoders.com/117/thumb-1920-11780.jpg'
            // Read in a binary file
            $datai = file_get_contents( $target_path );

            // Escape the binary data
            $escaped = bin2hex( $datai );

            
            
            
            $this->config($this->tabla2,'sqlmanual',array("update usuarios set imagen=decode('{$escaped}' , 'hex') where id_usuario=".$this->input->post('id_usuario',true)));
            redirect('/personas/', 'refresh');
	}
        
        
        public function ejecucion_primaria()
	{
            
            $query2 = $this->db->query('
            select distinct id_rol as id_rol
            from roles_x_usuarios where id_usuario='.$this->session->userdata('id_usuario').'');
            $pila = array();
            foreach ($query2->result() as $row)
            {
                array_push($pila, $row->id_rol);
            }
            

            
            return $pila;
	}
        
}
