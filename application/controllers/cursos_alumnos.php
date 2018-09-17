<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Cursos_alumnos extends CI_Controller {


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
                    "curso1_out","curso2_out","curso3_out","curso4_out","get_info_curso(curso1_out,id_usuario) as curso1_out_info","get_info_curso(curso2_out,id_usuario) as curso2_out_info","get_info_curso(curso3_out,id_usuario) as curso3_out_info","get_info_curso(curso4_out,id_usuario) as curso4_out_info"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    ""
                ],
                "columnas_actualizables" =>  [
                    
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    
                ],
                "update_table" => "cursos_alumnos",
                "join" => "pr_cursos_horizontal",
                "where" => "(:1,:2)",
                "lectura_where_variables" => [':1' =>['','E'],':2' =>['','E']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['N','N','N','N']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini',
                'columna' => 'ini-fin',
                'dimension_tabla' => '12',
                'titulo' => 'Cursos Habilitados',
                'class_tabla' => 'table no-margin',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
                'opcciones_funcion' => ['opcion_grabar' => 'N','opcion_borrar' => 'N','seleccionar_fila' => 'N'],
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
            
            $tablas_estructuras .= ' 
            <label>Categoria</label>
            <div class="row">
            
                <div class="col-xs-6">      
                    <select id="cursoscategoria" class="form-control" style="width: 100%;">

                    </select>
                </div>
            
            </div>                    
            ';
            
            
            
            foreach ($this->nombres_config as $value) {
                $tablas_estructuras .= $this->config($this->$value,'table');
            }
            
            $estructura = [
                "dato" => $tablas_estructuras,
                "titulo_general" => "Cursos Eduvirt",
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
            $this->load->view('general/scripts',["dato" => $this->config($this->tabla1,'configname'),"segmento" => base_url().$this->router->fetch_class().'/']);
            //$this->load->view($this->router->fetch_class().'/funciones_'.$this->tabla1[0]['update_table'],["dato" => $this->config($this->tabla1,'configname'),"segmento" => base_url().$this->router->fetch_class().'/',"segmento_acortado" => base_url()]);
	}

        public function axtis()
	{
            
            $var_aux=json_encode($this->config($this->tabla1,'sqlmanual',array("select id_categoria as id,nombre as text, 'false' as disabled from cursos_categoria "
                . "union all select 0 as id, 'Todos' as text, 'false' as disabled"))->result(),JSON_FORCE_OBJECT);
            
            //echo var_dump($var_aux);
            
            
            $clase=$this->router->fetch_class();
            foreach ($this->nombres_config as $value) {
                $this->load->view($clase.'/funciones_'.$this->$value[0]['update_table'],["dato" => $this->config($this->$value,'configname'),"segmento" => base_url().$clase.'/',"segmento_acortado" => base_url(),"array_datos" => $var_aux]);
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
                    $new_param=array_merge($this->input->post('parametros'),[':2' =>$this->session->userdata('id_usuario')]);
                    echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc_from($new_param,$this->{$value}[0]['where']));
                    //}
                }

            }
	}
        
        public function opciones_inscripcion()
	{   
            foreach ($this->nombres_config as $value) {
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    if ($this->input->post('opcion',true)=='Inscribirse'){
                    
                        
                    
                        $query1 = $this->db->query("select count(1) as existe from cursos where id_curso=".$this->input->post('id_curso',true)." and (fecha_ini is null or fecha_fin is null)");

                            $row1 = $query1->row();

                        $query2 = $this->db->query("select count(1) as existe from cursos where id_curso=".$this->input->post('id_curso',true)." and current_date <= fecha_ini");

                            $row2 = $query2->row();


                            if ($row1->existe=='1'){
                                $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into cursos_x_alumnos (id_usuario,id_curso) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_curso',true).")"));
                                echo $array_mensaje;
                            }else{
                                if ($row2->existe=='1'){
                                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into cursos_x_alumnos (id_usuario,id_curso) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_curso',true).")"));
                                    echo $array_mensaje;
                                }else{
                                    echo '0';
                                }
                            }


                             
                    
                    
                    
                    
                    }  else {
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("delete from cursos_x_alumnos where id_usuario=".$this->session->userdata('id_usuario')." and id_curso=".$this->input->post('id_curso',true).""));
                    
                    echo $array_mensaje;
                    
                    };
                    
                //}

            }
	}
        
        public function opciones_valoracion()
	{   
            foreach ($this->nombres_config as $value) {
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    if ($this->input->post('opcion',true)=='Me gusta'){
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into valoracion_curso (id_usuario,id_curso) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_curso',true).")"));
                    
                    echo $array_mensaje;
                    }  else {
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("delete from valoracion_curso where id_usuario=".$this->session->userdata('id_usuario')." and id_curso=".$this->input->post('id_curso',true).""));
                    
                    echo $array_mensaje;
                    
                    };
                    
                //}

            }
	}
        
        public function existe_inscripcion()
	{   
            $query = $this->db->query("select count(1) as existe from cursos_x_alumnos where id_usuario=".$this->session->userdata('id_usuario')." and id_curso=".$this->input->post('id_curso',true));

                $row = $query->row();
            
                
                if ($row->existe=='0'){
                    echo 'N';
                }else{
                    echo 'S';
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
