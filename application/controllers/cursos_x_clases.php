<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Cursos_x_clases extends CI_Controller {


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
    var $nombres_config=array('tabla1','tabla2','tabla3','tabla4','tabla5');
//============================================================================================================================================
// Fin de los nombres de las funciones de configuraciones                                                                                    1
//============================================================================================================================================
       var $tabla1 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "personas.id_usuario as id_usuario","personas.nombre as nombre","apellido","ruc","documento_identidad","email","genero","fecha_nacimiento","encode(imagen, 'base64') as imagen", "usuario", "(select count(1) from (select 1 from proyectos_x_personas where id_usuario=personas.id_usuario group by id_usuario, id_proyecto) tabla_aux (valor)) as count_proyectos","finalizado","(select count(1) from cursos_x_alumnos where id_curso=cursos.id_curso) as count_participantes", "(select count(1) from curso_x_comentarios where id_curso=cursos.id_curso) as count_comentarios"
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
                    'label' => '',
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
                "join" => "personas inner join cursos on (personas.id_usuario=cursos.id_usuario) inner join usuarios on (cursos.id_usuario=usuarios.id_usuario)",
                "where" => "cursos.id_curso=:id_curso order by cursos.id_curso",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['N','N','N','N']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini',
                'columna' => 'ini',
                'dimension_tabla' => '4',
                'titulo' => 'Tutor',
                'class_tabla' => '',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
       var $tabla2 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_comentario", "id_curso", "curso_x_comentarios.id_usuario as id_usuario", "fecha_hora", "comentario_persona", "get_user_nombre(curso_x_comentarios.id_usuario) as user_nombre", "COALESCE(to_char(fecha_hora, 'dd/mm/yyyy HH24:MI:SS')) as fecha_formato", "encode(usuarios.imagen, 'base64') as imagen"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_comentario"
                ],
                "columnas_actualizables" =>  [
                    "id_curso", "id_usuario", "comentario_persona"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_comentario"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Comentario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "id_curso"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "id_usuario"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Usuario',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "fecha_hora"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Fecha Completa:',
                    'placeholder' => 'Clase',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "comentario_persona"=>[
                    'tipo' => 'textarea',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Comentario:',
                    'placeholder' => 'Contenido',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '3000',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ]
                ],
                "update_table" => "curso_x_comentarios",
                "join" => "curso_x_comentarios left outer join usuarios on (curso_x_comentarios.id_usuario=usuarios.id_usuario)",
                "where" => "id_curso=:id_curso",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Comentarios',
                'class_tabla' => 'display compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
       var $tabla3 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "cursos_x_alumnos.id_usuario", "get_user_nombre(cursos_x_alumnos.id_usuario) as nombre_usuario", "encode(imagen, 'base64') as imagen"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "respuesta_tutor"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "respuesta_tutor"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => '',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
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
                    ]
                ],
                "update_table" => "cursos_x_alumnos",
                "join" => "cursos_x_alumnos left outer join usuarios on (cursos_x_alumnos.id_usuario=usuarios.id_usuario)",
                "where" => "cursos_x_alumnos.id_curso=:id_curso",
                "lectura_where_variables" => [],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'fin',
                'dimension_tabla' => '2',
                'titulo' => 'Participantes',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
    
       var $tabla4 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_clase", "id_curso", "grupo", "numero_clase", "nombre_clase", "contenido", "minutos", "estado", "(select id_usuario from cursos where cursos.id_curso=cursos_x_clases.id_curso) as id_usuario"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_clase"
                ],
                "columnas_actualizables" =>  [
                    "id_curso", "grupo", "numero_clase", "nombre_clase", "contenido", "minutos", "estado"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_curso"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "grupo"=>[
                    'tipo' => 'select',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Nombre del grupo:',
                    'placeholder' => 'Grupo',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['001-Introducción' => 'Introducción','002-Basico' => 'Basico','003-Avanzado' => 'Avanzado'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre,
                    'required' => ''
                    ],
                    "numero_clase"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Numero de Clase:',
                    'placeholder' => 'Orden de Clase',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '6',
                    'data-inputmask' => "'mask': '9{0,5}'",
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ],
                    "nombre_clase"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Nombre de la Clase:',
                    'placeholder' => 'Clase',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ],
                    "contenido"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Descripción:',
                    'placeholder' => 'Tema que Contiene',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ],
                    "minutos"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Tiempo:',
                    'placeholder' => 'En minutos',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '5',
                    'dimension_input' => '6',
                    'data-inputmask' => "'mask': '9{0,5}'",
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
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
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre,
                    'required' => ''
                    ]
                ],
                "update_table" => "cursos_x_clases",
                "join" => "cursos_x_clases",
                "where" => "id_curso=:id_curso and estado='A'",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'ini',
                'dimension_tabla' => '8',
                'titulo' => 'Clases Del Curso',
                'class_tabla' => 'display compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
       var $tabla5 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_test", "titulo", "descripcion", "estado", "id_curso", "COALESCE(to_char(fecha_hora, 'dd/mm/yyyy HH24:MI:SS')) as fecha_formato"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_test"
                ],
                "columnas_actualizables" =>  [
                    "titulo", "descripcion", "estado", "id_curso"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_test"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => '',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "titulo"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Titulo del Examen:',
                    'placeholder' => 'Nombre',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "descripcion"=>[
                    'tipo' => 'textarea',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Noticia:',
                    'placeholder' => '',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '3000',
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
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'select_dato' => ['A' => 'Activo','I' => 'Inactivo'],//puede ser una array o un select de la base de datos
                    'select_default' => '',//coloca el valor por default en el select
                    'data-select' => '',//activar buscador en el select quitar el '-no' para activar en el nombre
                    ],
                    "id_curso"=>[
                    'tipo' => 'hidden',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Curso',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ]
                ],
                "update_table" => "tests",
                "join" => "tests",
                "where" => "id_curso=:id_curso and estado='A' and not exists(select 1 from respuestas_alumno where id_test=tests.id_test and id_usuario=:id_usuario) order by orden",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'fin',
                'columna' => 'fin',
                'dimension_tabla' => '12',
                'titulo' => 'Examenes',
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
                if ($config[0]['update_table']==='curso_x_comentarios'){
                $valor_decodificado=$this->funciones->caracteres_especiales_decodificar($this->manejador->getdatos($manejador,$datos),['comentario_persona']);
                return json_encode($valor_decodificado);
                }elseif ($config[0]['update_table']==='tests'){
                $valor_decodificado=$this->funciones->caracteres_especiales_decodificar($this->manejador->getdatos($manejador,$datos),['descripcion']); 
                return json_encode($valor_decodificado);
                }
                else{
                return json_encode($this->manejador->getdatos($manejador,$datos));
                }
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
                  <div style="display:none;" id="opcion'.$config[0]['update_table'].'" class="btn-group" style="padding: 0px 0px 3px 0px;">
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
            
            
            $exite_favorito=$this->config($this->tabla1,'sqlmanual',array("select count(1) as contador from favoritos_cursos where id_usuario=".$this->session->userdata('id_usuario')." and id_curso=".$this->uri->segment(3).""));
            
            $this->tabla4[0]['titulo']=$this->tabla4[0]['titulo'].' '.'<button onclick="opciones_favorito(this)" type="button" class="btn btn-default btn-xs">'.((1 == $exite_favorito->row()->contador) ? '<i class="fa fa-fw fa-thumbs-o-up"></i>' : 'Favorito').'</button>';
            
            
            $tablas_estructuras='';
            foreach ($this->nombres_config as $value) {
                $tablas_estructuras .= $this->config($this->$value,'table');
            }
            
            $estructura = [
                "dato" => $tablas_estructuras,
                "titulo_general" => "Clases",
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
            $this->load->view('general/chat');
            $this->load->view('general/scripts',["segmento" => base_url().$this->router->fetch_class().'/']);
            //$this->load->view($this->router->fetch_class().'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->tabla1,'configname'),"segmento" => base_url().$this->router->fetch_class().'/',"segmento_acortado" => base_url()]);
	}

        public function axtis()
	{
            $this->ejecucion_primaria();
            $clase=$this->router->fetch_class();
            foreach ($this->nombres_config as $value) {
                $this->load->view($clase.'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->$value,'configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url(),"id_usuario" => $this->session->userdata('id_usuario')]);
            }
	}
        
        
       
        public function grabardatos()
	{
        
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    //$valores= array_values($this->input->post('parametros'));
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados['id_usuario']=$this->session->userdata('id_usuario');
                    $valores= array_values($datos_agregados);
                    //echo var_dump($valores);
                    if ($this->input->post('tipo',true)==='curso_x_comentarios'){
                    
                    echo $this->config($this->$value,'update',$this->funciones->verificar_array($valores,['4']));
                    }
                    else{
                    echo $this->config($this->$value,'update',$this->funciones->verificar_array($valores));
                    }
                    
                    
                    //var_dump($this->funciones->verificar_array($valores));
                }

            }
	}

        
        public function borrardatos()
	{
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $valores= array_values($this->input->post('parametros'));
                    echo $this->config($this->$value,'delete',$this->funciones->verificar_array($valores));
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
                    $new_param=array_merge($this->input->post('parametros'),[':id_usuario' =>$this->session->userdata('id_usuario')]);
                    echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc($new_param,$this->{$value}[0]['where']));
                    //echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc($this->input->post('parametros'),$this->{$value}[0]['where']));
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
        
        public function opciones_favorito()
	{   
            //foreach ($this->nombres_config as $value) {
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    if ($this->input->post('opcion',true)=='Favorito'){
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into favoritos_cursos (id_usuario,id_curso) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_curso',true).")"));
                    
                    echo $array_mensaje;
                    }  else {
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("delete from favoritos_cursos where id_usuario=".$this->session->userdata('id_usuario')." and id_curso=".$this->input->post('id_curso',true).""));
                    
                    echo $array_mensaje;
                    
                    };
                    
                //}

            //}
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
            
            if (in_array(1,$pila)) {
                $this->tabla4[0]['action']['visible']='S';
            };
            if (in_array(3,$pila)) {
                $this->tabla4[0]['action']['visible']='S';
            };
            return $pila;
	}
        
        public function verificar_duenho()
	{
            
            $query = $this->db->query('
            select count(1) existe
            from cursos where id_usuario='.$this->session->userdata('id_usuario').' and id_curso='.$this->input->post('id_curso',true));
            $row = $query->row();
                
                if ($row->existe=='0'){
                    echo 'N';
                }else{
                    echo 'S';
                }
	}
        
        public function existe_examen_por_rendir()
	{   
            $query = $this->db->query("select count(1) as existe
from (select t.id_test, t.id_curso
from tests t
where (orden<(select orden from tests where id_test=".$this->input->post('id_test',true).")) and t.id_curso=".$this->input->post('id_curso',true)."
except
select t.id_test, t.id_curso
from tests t inner join respuestas_alumno ra on (t.id_test=ra.id_test)
where (orden<(select orden from tests where id_test=".$this->input->post('id_test',true).") or orden is null) and t.id_curso=".$this->input->post('id_curso',true)." and ra.id_usuario=".$this->session->userdata('id_usuario')."
group by t.id_test, t.id_curso) as tabla_aux (test,curso)");

                $row = $query->row();
            
                
                if ($row->existe=='0'){
                    echo 'S';
                }else{
                    echo 'N';
                }
	}
        
}
