<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Tareas extends CI_Controller {


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
          $this->load->helper('url');

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
                    "id_tarea", "tareas.id_usuario as id_usuario", "id_clase", "tarea", "comentario", "fecha_hora", "get_user_nombre(tareas.id_usuario) as user_nombre", "COALESCE(to_char(fecha_hora, 'dd/mm/yyyy HH24:MI:SS')) as fecha_formato", "encode(usuarios.imagen, 'base64') as imagen"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_tarea"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario", "id_clase", "tarea", "comentario"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_tarea"=>[
                    'type' => 'hidden',
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
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
                    'grabar_formato' => 'N',
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
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Dirección',
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
                    ]
                ],
                "update_table" => "tareas",
                "join" => "tareas left outer join usuarios on (tareas.id_usuario=usuarios.id_usuario)",
                "where" => "id_clase=:id_clase",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'S','opciones' =>['S','N','N','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'medio',
                'columna' => 'fin',
                'dimension_tabla' => '4',
                'titulo' => 'Tareas',
                'class_tabla' => 'display compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
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
            <div class="box">
            <div class="box-header">
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
            //echo $this->input->post('name',true);
            $tablas_estructuras='';
            foreach ($this->nombres_config as $value) {
                $tablas_estructuras .= $this->config($this->$value,'table');
            }
            
            
            $tablas_estructuras ='<form id="fileupload" action="" method="POST" enctype="multipart/form-data">
		<!-- Redirect browsers with JavaScript disabled to the origin page -->
		<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<div class="row fileupload-buttonbar">
			<div class="col-lg-7">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Seleccionar Archivos...</span>
                    <input type="file" name="files[]" multiple>
                </span>
				<button type="submit" class="btn btn-primary start">
					<i class="glyphicon glyphicon-upload"></i>
					<span>Subir</span>
				</button>
				<button type="reset" class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancelar Subida</span>
				</button>
				<button type="button" class="btn btn-danger delete">
					<i class="glyphicon glyphicon-trash"></i>
					<span>Borrar</span>
				</button>
				<input type="checkbox" class="toggle">
				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
			</div>
			<!-- The global progress state -->
			<div class="col-lg-5 fileupload-progress fade">
				<!-- The global progress bar -->
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					<div class="progress-bar progress-bar-success" style="width:0%;"></div>
				</div>
				<!-- The extended global progress state -->
				<div class="progress-extended">&nbsp;</div>
			</div>
		</div>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>';
            
            
            
            
            $estructura = [
                "dato" => $tablas_estructuras,
                "titulo_general" => "Tareas",
                "id_usuario" => $this->session->userdata('id_usuario'),
                "usuario" => $this->session->userdata('usuario'),
                "imagen" => $this->session->userdata('imagen'),
                "tipo" => $pila
            ];
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
            

            $this->load->view('general/cabecera_files_jquery');  

            $this->load->view('general/menu',$estructura);//funciona
            $this->load->view('general/menu_izquierdo',$estructura);//funciona
            $this->load->view('general/contenido',$estructura);
            
            foreach ($this->nombres_config as $value) {
                
                $this->load->view('general/formulario_modal',["dato" => $this->config($this->{$value},'configname')]);
                
            }
            
            $this->load->view('general/pie');
            $this->load->view('general/menu_derecho');//parece funcionar
            $this->load->view('general/scripts_files_jquery',["segmento" => base_url().$this->router->fetch_class().'/']);
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
            //$clase=$this->router->fetch_class();
            //foreach ($this->nombres_config as $value) {
            //    $this->load->view($clase.'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->$value,'configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url()]);
            //}
	}
        
        
       
        public function grabardatos()
	{
        
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    //$valores= array_values($this->input->post('parametros'));
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados['id_usuario']=$this->session->userdata('id_usuario');
                    $valores= array_values($datos_agregados);
                    echo var_dump($valores);
                    if ($this->input->post('tipo',true)==='lecciones'){
                    
                    $this->config($this->$value,'update',$this->funciones->verificar_array($valores,['4']));
                    }
                    else{
                    $this->config($this->$value,'update',$this->funciones->verificar_array($valores));
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
        
        
        
        public function json()
        {
        $options = [
        'script_url' => site_url('upload/json'),
        'upload_dir' => APPPATH . '../uploads/files/',
        'upload_url' => site_url('uploads/files/')
        ];
        $this->load->library('UploadHandler', $options);
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
