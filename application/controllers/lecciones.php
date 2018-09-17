<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Lecciones extends CI_Controller {


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
                    "personas.id_usuario as id_usuario","personas.nombre as nombre","apellido","ruc","documento_identidad","email","genero","fecha_nacimiento","encode(imagen, 'base64') as imagen", "usuario", "(select count(1) from (select 1 from proyectos_x_personas where id_usuario=personas.id_usuario group by id_usuario, id_proyecto) tabla_aux (valor)) as count_proyectos","finalizado","(select count(1) from cursos_x_alumnos where id_curso=cursos.id_curso) as count_participantes", "(select count(1) from tareas where id_clase=cursos_x_clases.id_clase) as count_tareas"
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
                    'grabar_formato' => 'S',
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
                "join" => "personas inner join cursos on (personas.id_usuario=cursos.id_usuario) inner join usuarios on (cursos.id_usuario=usuarios.id_usuario) inner join cursos_x_clases on (cursos.id_curso=cursos_x_clases.id_curso)",
                "where" => "cursos_x_clases.id_clase=:id_clase order by cursos_x_clases.id_clase",
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
                    "id_tarea_tutor", "id_clase", "COALESCE(to_char(fecha_ini, 'dd/mm/yyyy')) as fecha_ini", "COALESCE(to_char(fecha_fin, 'dd/mm/yyyy')) as fecha_fin", "nota_tarea"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_tarea_tutor"
                ],
                "columnas_actualizables" =>  [
                    "id_clase", "fecha_ini", "fecha_fin", "nota_tarea"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_tarea_tutor"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo tarea',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "id_clase"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Clase',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "fecha_ini"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Inicio de Prorroga',
                    'placeholder' => 'Fecha inicial',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                    'style' => 'text-align: left; width: 100%;',
                    'datepicker' => '',
                    'required' => ''
                    ],
                    "fecha_fin"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Finalización de Prorroga',
                    'placeholder' => 'Fecha final',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                    'style' => 'text-align: left; width: 100%;',
                    'datepicker' => '',
                    'required' => ''
                    ],
                    "nota_tarea"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Puntaje de la tarea:',
                    'placeholder' => 'Puntaje',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask' => "'mask': '9{0,5}'",
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ]
                ],
                "update_table" => "tareas_tutor",
                "join" => "tareas_tutor",
                "where" => "id_clase=:id_clase order by id_tarea_tutor asc",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Validación de Tareas',
                'class_tabla' => 'display compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       
       var $tabla3 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_tarea", "tareas.id_usuario as id_usuario", "id_clase", "comentario", "tarea", "fecha_hora", "get_user_nombre(tareas.id_usuario) as user_nombre", "COALESCE(to_char(fecha_hora, 'dd/mm/yyyy HH24:MI:SS')) as fecha_formato", "encode(usuarios.imagen, 'base64') as imagen", "nota"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_tarea"
                ],
                "columnas_actualizables" =>  [
                    "id_clase", "comentario", "tarea", "nota"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_tarea"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo tarea',
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
                    "id_clase"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo Clase',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "tarea"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Contenido',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '35',
                    'dimension_input' => '4',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "comentario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Comentario:',
                    'placeholder' => 'Contenido',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '12',
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
                    "nota"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Puntaje de la tarea:',
                    'placeholder' => 'Puntaje',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '4',
                    'data-inputmask' => "'mask': '9{0,5}'",
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ]
                ],
                "update_table" => "tareas",
                "join" => "tareas left outer join usuarios on (tareas.id_usuario=usuarios.id_usuario)",
                "where" => "(not exists(select 1 from cursos c inner join cursos_x_clases cc on (c.id_curso=cc.id_curso) where c.id_usuario=:id_usuario and cc.id_clase=:id_clase) and id_clase=:id_clase and tareas.id_usuario=:id_usuario) or (exists(select 1 from cursos c inner join cursos_x_clases cc on (c.id_curso=cc.id_curso) where c.id_usuario=:id_usuario and cc.id_clase=:id_clase) and id_clase=:id_clase) order by fecha_formato asc, tareas.id_usuario asc",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['N','S','N','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'medio',
                'dimension_tabla' => '4',
                'titulo' => 'Tareas',
                'class_tabla' => 'display compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
       
       var $tabla4 = [0=>[
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
                    'grabar_formato' => 'S',
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
                    'grabar_formato' => 'S',
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
                "join" => "cursos_x_alumnos left outer join usuarios on (cursos_x_alumnos.id_usuario=usuarios.id_usuario) inner join cursos_x_clases on (cursos_x_alumnos.id_curso=cursos_x_clases.id_curso)",
                "where" => "cursos_x_clases.id_clase=:id_clase",
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
    
       var $tabla5 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_leccion", "contenido", "id_clase", "titulo"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_leccion"
                ],
                "columnas_actualizables" =>  [
                    "contenido", "id_clase", "titulo"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_clase"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => '',
                    'placeholder' => 'Codigo clase',
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
                    'label' => 'Titulo:',
                    'placeholder' => 'Tema de la Lección',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '30',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ],
                    "contenido"=>[
                    'tipo' => 'textarea',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Lección:',
                    'placeholder' => 'Contenido',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '3000',
                    'dimension_input' => '12',
                    'style' => "text-align: left; width: 100%;",
                    'required' => ''
                    ]
                ],
                "update_table" => "lecciones",
                "join" => "lecciones",
                "where" => "id_clase=:id_clase order by id_leccion",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'fin',
                'columna' => 'ini-fin',
                'dimension_tabla' => '8',
                'titulo' => 'Lecciones',
                'class_tabla' => 'display',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
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
                if ($config[0]['update_table']==='lecciones'){
                $valor_decodificado=$this->funciones->caracteres_especiales_decodificar($this->manejador->getdatos($manejador,$datos),['contenido']);
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
                if ($config[0]['update_table']=='tareas'){
                    $estructura_tabla .= '<li><a id="subir_tarea">Gestor de tareas</a></li>';
                }
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



        
        
	public function index($data)
	{   
            
//============================================================================================================================================
// SE CREA LA TABLA CON SU NOMBRE PARA LA VISTA                                                                                              3
//============================================================================================================================================
            $pila=$this->ejecucion_primaria();
            
            $tablas_estructuras='';
            foreach ($this->nombres_config as $value) {
                $tablas_estructuras .= $this->config($this->$value,'table');
            }
            
            
            //echo $this->session->userdata('id_usuario');
            //echo $_SESSION['id_usuario'];
            //echo $_SESSION['clase'];
            //session_start();
            //$_SESSION['id_user']=$this->session->userdata('id_usuario');
            
            
            
            $estructura = [
                "dato" => $tablas_estructuras,
                "titulo_general" => "Lecciones",
                "id_usuario" => $this->session->userdata('id_usuario'),
                "usuario" => $this->session->userdata('usuario'),
                "imagen" => $this->session->userdata('imagen'),
                "tipo" => $pila
            ];
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
            $cookie_value = array(
                "id_usuario" => $this->session->userdata('id_usuario'),
                "id_clase" => $data,
            );
            
            
            $cookie_name = "user";
            //$cookie_value = "John Doe65";
            setcookie($cookie_name, serialize($cookie_value), time() + (86400 * 30), "/"); // 86400 = 1 

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
            //$this->load->view($this->router->fetch_class().'/funciones_'.$this->tabla1[0]['update_table'],["dato" => $this->config($this->tabla1,'configname'),"segmento" => base_url().$this->router->fetch_class().'/',"segmento_acortado" => base_url()]);
            //$this->load->view($this->router->fetch_class().'/funciones_'.$this->tabla2[0]['update_table'],["dato" => $this->config($this->tabla2,'configname'),"segmento" => base_url().$this->router->fetch_class().'/',"segmento_acortado" => base_url()]);
            //$this->load->view($this->router->fetch_class().'/funciones_'.$this->tabla3[0]['update_table'],["dato" => $this->config($this->tabla3,'configname'),"segmento" => base_url().$this->router->fetch_class().'/',"segmento_acortado" => base_url()]);
            //$clase=$this->router->fetch_class();
            
            //$this->load->view($clase.'/funciones_'.$this->$tabla1[0]['update_table'],["dato" => $this->config($this->tabla1,'configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url()]);
            //$this->load->view($clase.'/funciones_'.$this->$tabla2[0]['update_table'],["dato" => $this->config('tabla2','configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url()]);
            //$this->load->view($clase.'/funciones_'.$this->$tabla3[0]['update_table'],["dato" => $this->config('tabla3','configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url()]);
            
    }   

        public function axtis()
	{
            $this->ejecucion_primaria();
            $clase=$this->router->fetch_class();
            foreach ($this->nombres_config as $value) {
                $this->load->view($clase.'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->$value,'configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url()]);
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
                    if ($this->input->post('tipo',true)==='lecciones'){
                    
                    echo $this->config($this->$value,'update',$this->funciones->verificar_array($valores,['1']));
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
                    $new_param=array_merge($this->input->post('parametros'),[':id_usuario' =>$this->session->userdata('id_usuario')]);
                    echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc($new_param,$this->{$value}[0]['where']));
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
        
        
        public function verificar_subida()
	{
            
                $query = $this->db->query("select count(1) as existe from tareas_tutor where current_date between cast(fecha_ini as date) and cast(fecha_fin as date) and id_clase=".$this->input->post('id_clase',true));

                $row = $query->row();
                
                if ($row->existe=='0'){
                    echo 'N';
                }else{
                    echo 'S';
                }
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
                $this->tabla2[0]['action']['visible']='S';
                $this->tabla4[0]['action']['visible']='S';
            };
            if (in_array(3,$pila)) {
                $this->tabla2[0]['action']['visible']='S';
                $this->tabla4[0]['action']['visible']='S';
            };
            return $pila;
	}
        
        
        public function verificar_duenho()
	{
            
            $query = $this->db->query('
            select count(1) existe
            from cursos_x_clases cl inner join cursos cu on (cl.id_curso=cu.id_curso) where id_usuario='.$this->session->userdata('id_usuario').' and cl.id_clase='.$this->input->post('id_clase',true));
            $row = $query->row();
                
                if ($row->existe=='0'){
                    echo 'N';
                }else{
                    echo 'S';
                }
	}

        
        
}
