<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Conversaciones extends CI_Controller {


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
                "where" => "id_usuario=:id_usuario",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','S','N','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => ["tests"],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini-fin',
                'columna' => 'ini-fin',
                'dimension_tabla' => '12',
                'titulo' => 'Cursos Administración',
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
                if ($config[0]['update_table']==='tests'){
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



        
        
	
        
        
        public function resultmensaje()
	{   

                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    if ("insertar"==$this->input->post('tipo',true) && strlen($this->input->post('mensaje',true))>0 ){
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into mensajes (emisor,receptor,mensaje) values (".$this->session->userdata('id_usuario').",".$this->input->post('contacto',true).",'".$this->input->post('mensaje')."') "));
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("update contactos set nuevo_mensaje=1 where id_usuario=".$this->input->post('contacto',true)." and contacto=".$this->session->userdata('id_usuario')));
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_mensajes(".$this->session->userdata('id_usuario').",".$this->input->post('contacto',true).") "))->result();
                    //$array_mensaje[0]->mensaje_out.$array_mensaje[1]->mensaje_out.$array_mensaje[2]->mensaje_out;
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
                    
                    };
                    
                    if ("leer"==$this->input->post('tipo',true) ){
          
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("update contactos set nuevo_mensaje=0 where id_usuario=".$this->session->userdata('id_usuario')." and contacto=".$this->input->post('contacto',true)));
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_mensajes(".$this->session->userdata('id_usuario').",".$this->input->post('contacto',true).") "))->result();
                    //$array_mensaje[0]->mensaje_out.$array_mensaje[1]->mensaje_out.$array_mensaje[2]->mensaje_out;
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
                    
                    };
                    

                    
                //}


	}
        
        
        public function resultcontactos()
	{   
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_contactos(".$this->session->userdata('id_usuario').") "))->result();
                    //$array_mensaje[0]->mensaje_out.$array_mensaje[1]->mensaje_out.$array_mensaje[2]->mensaje_out;
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
                //}

	}
        
        public function nuevomensaje()
	{   
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select count(1) as cantidad from contactos where id_usuario=".$this->session->userdata('id_usuario')." and nuevo_mensaje=1"))->row()->cantidad;
                    //$array_mensaje[0]->mensaje_out.$array_mensaje[1]->mensaje_out.$array_mensaje[2]->mensaje_out;
                    echo $array_mensaje;
                    
                //}

	}
        
        public function mensajeadd_contacto()
	{   
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into contactos (id_usuario,contacto) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_contacto',true).")"));
                    
                    echo $array_mensaje;
                    
	}
        
        
        public function topicos_favoritos()
	{   
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_topicos_favoritos(".$this->session->userdata('id_usuario').")"))->result();
                    
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
	}
        
        public function cursos_favoritos()
	{   
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_cursos_favoritos(".$this->session->userdata('id_usuario').")"))->result();
                    
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
	}
        
        
        
        public function consultas_favoritos()
	{   
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_consulta_favoritos(".$this->session->userdata('id_usuario').")"))->result();
                    
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
	}
        
        
        public function consultass_favoritos()
	{   
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("select * from get_consultas_favoritos(".$this->session->userdata('id_usuario').")"))->result();
                    
                    foreach($array_mensaje as $mensa)
                    {
                        $new_arr[] = $mensa->mensaje_out;
                    }
                    $res_arr = implode('',$new_arr);
                    echo $res_arr;
                    
	}
        
        
        
        
}
