<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Mensajes extends CI_Controller {


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
                "where" => "contactos.id_usuario=:id_usuario",//si se declara la tabla padre solo se puede usar una variable
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini-fin',
                'columna' => 'ini',
                'dimension_tabla' => '4',
                'titulo' => 'Mis Contactos',
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
            
            
            $tablas_estructuras .='<div class="col-md-6">
              <!-- DIRECT CHAT -->
              <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Chat Directo</h3>

                  <div class="box-tools pull-right">
                  <span data-toggle="tooltip" id="mennuevo" title="" class="badge bg-light-blue" >0</span>
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                      <i class="fa fa-comments"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">


                  </div>
                  <!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                      
                    </ul>
                    <!-- /.contatcts-list -->
                  </div>
                  <!-- /.direct-chat-pane -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="">
              <form action="file:///C:/Users/Jos%C3%A9Miguel/Desktop/AdminLTE-2.4.0-rc/AdminLTE-2.4.0-rc/pages/widgets.html#" method="post">
                <div class="input-group">
                  <input id="id_mensaje" type="text" name="message" placeholder="Escribe un mensaje ..." class="form-control">
                      <span class="input-group-btn">
                        <button id="mensaje_enviar" type="submit" class="btn btn-primary btn-flat">Enviar</button>
                      </span>
                </div>
              </form>
            </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div></div>';
            
            
            
            
            $estructura = [
                "dato" => $tablas_estructuras,
                "titulo_general" => "Mensajes",
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
            $this->load->view('general/scripts',["segmento" => base_url().$this->router->fetch_class().'/']);

	}

        public function axtis()
	{
            $clase=$this->router->fetch_class();
            foreach ($this->nombres_config as $value) {
                $this->load->view($clase.'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->$value,'configname'),"segmento" => base_url().$clase.'/']);
            }
	}
        
        
       
        public function grabardatos()
	{
        
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados['id_usuario']=$this->session->userdata('id_usuario');
                    $valores= array_values($datos_agregados);
                    //$valores= array_values($this->input->post('parametros'));
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
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    //echo var_dump($this->input->post('parametros'));
                    ///if($this->input->post('tipo',true)=='personas'){
                    //echo $this->config($this->$value,'resultsql',  $this->funciones->strReplaceAssoc($this->input->post('parametros'),$this->{$value}[0]['where']));
                    //echo $this->funciones->strReplaceAssoc($this->input->post('parametros'),$this->{$value}[0]['where']);
                    //}else{
                    echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc($valores,$this->{$value}[0]['where']));
                    //}
                }

            }
	}
        
        
        public function resultmensaje()
	{   
            foreach ($this->nombres_config as $value) {
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    
                    if ("insertar"==$this->input->post('tipo',true) && strlen($this->input->post('mensaje',true))>0 ){
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into mensajes (emisor,receptor,mensaje) values (".$this->session->userdata('id_usuario').",".$this->input->post('contacto',true).",'".$this->input->post('mensaje')."') "));
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("update contactos set nuevo_mensaje=1 where id_usuario=".$this->input->post('contacto',true).""));
                    
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
          
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("update contactos set nuevo_mensaje=0 where id_usuario=".$this->session->userdata('id_usuario').""));
                    
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
	}
        
        
        public function resultcontactos()
	{   
            foreach ($this->nombres_config as $value) {
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
	}
        
        public function nuevomensaje()
	{   
            foreach ($this->nombres_config as $value) {
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
        
        
        public function salir()
	{   
            $this->session->sess_destroy();
            
            echo'salida';
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
