<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Guia_informativo extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();
          $this->load->model('manejador');
          $this->load->helper('clase_dinamica');
          $this->load->library('funciones');
          $this->load->library('table');
          $this->load->library('pagination');
          $this->load->helper('form');
          $this->load->helper('security');
          $this->funciones->salir();
          

        }
 
//============================================================================================================================================
// Nombre de las funciones de configuraciones                                                                                                1
//============================================================================================================================================
    var $nombres_config=array('tabla1');
    var $paginacion;
    var $limite_paginacion=20;
//============================================================================================================================================
// Fin de los nombres de las funciones de configuraciones                                                                                    1
//============================================================================================================================================
       var $tabla1 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "id_guia","id_usuario","id_doc","comentario_persona","imagen ", "usuario", "fecha_formato", "info_boton", "info_comentario", "es_usuario"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "id_guia"
                ],
                "columnas_actualizables" =>  [
                    "id_usuario","id_doc","comentario_persona"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "elementos_form" =>  [
                    "id_guia"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Comentario:',
                    'placeholder' => 'Codigo Comentario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "id_usuario"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'N',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Usuario:',
                    'placeholder' => 'Codigo Usuario',
                    'disabled' => 'disabled',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '4',
                    'style' => "text-align: right; width: 100%;"
                    ],
                    "id_doc"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Codigo del Topic:',
                    'placeholder' => 'Topico',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '60',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ],
                    "comentario_persona"=>[
                    'tipo' => 'input',
                    'grabar_formato' => 'S',
                    'id' => '',//se configura automaticamente con el nombre de la tabla y la key de este mismo array
                    'name' => '',//se configura automaticamente con la key de este mismo array
                    'label' => 'Descripción del Topico:',
                    'placeholder' => 'Tema',
                    'fila' => 'ini-fin',
                    'class' => 'form-control',
                    'maxlength' => '3000',
                    'dimension_input' => '6',
                    'style' => "text-align: left; width: 100%;"
                    ]
                ],
                "update_table" => "guia_informativo",
                "join" => "pr_guia_info",
                "where" => "(:topic,:limite,:pag,:id_usuario)",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "S",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['N','N','N','N']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [""],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini',
                'columna' => 'ini-fin',
                'dimension_tabla' => '12',
                'titulo' => 'Guia Informativa',
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
            $valor_decodificado=$this->funciones->caracteres_especiales_decodificar($this->manejador->getdatos($manejador,$datos),['comentario_persona']);
            return json_encode($valor_decodificado);
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
            if($opcion=='count'){
            return $this->manejador->getcount($manejador,$datos);
            }
	}



        
        
	public function index()
	{   
            $pila=$this->ejecucion_primaria();
            //echo $this->session->userdata('id_usuario');
            
            
            
            //$paginacion['base_url'] = base_url().$this->router->fetch_class().'/index/topic2/';
            //$paginacion['total_rows'] = 3;
            //$paginacion['per_page'] = 2;
            //echo substr($this->uri->segment(3),5);
            //echo var_dump($paginacion);
            
            $exite_favorito=$this->config($this->tabla1,'sqlmanual',array("select count(1) as contador from favoritos_informativo where id_usuario=".$this->session->userdata('id_usuario')." and id_doc=".substr($this->uri->segment(3),5).""));
            
            $this->config($this->tabla1,'sqlmanual',array("UPDATE documento_informativo SET contador_ingreso=COALESCE( contador_ingreso , 0 )+1 WHERE id_doc=".substr($this->uri->segment(3),5).""));
            
            $this->tabla1[0]['titulo']=$this->tabla1[0]['titulo'].' '.'<button onclick="opciones_favorito(this)" type="button" class="btn btn-default btn-xs">'.((1 == $exite_favorito->row()->contador) ? '<i class="fa fa-fw fa-thumbs-o-up"></i>' : 'Favorito').'</button>';
            $this->paginacion = [
                    'base_url' => base_url().$this->router->fetch_class().'/index/'.$this->uri->segment(3).'/',
                    'total_rows' => $this->config($this->tabla1,'count','where id_doc = '.substr($this->uri->segment(3),5)),
                    'per_page' => $this->limite_paginacion,
                    'use_page_numbers' => true,
                    'first_link' => 'Primero',
                    'last_link' => 'Ultimo',
                    'next_link' => 'Siguente',
                    'prev_link' => 'Anterior',
                    'cur_tag_open' => '<li class="paginate_button">',
                    'cur_tag_close' => '</li>',
                    'full_tag_open' => '<ul class="pagination">',
                    'full_tag_close' => '</ul>'
                ];
            //echo $this->config('count');
                    
            $this->pagination->initialize($this->paginacion);
            $botones='<div id="grabar_marco_fin_'.$this->config($this->tabla1,'configname')[0]['update_table'].'" style="display: inline">
                <button id="grabar_dato_fin_'.$this->config($this->tabla1,'configname')[0]['update_table'].'" type="button" class="btn btn-default" data-dismiss="modal">Grabar</button>
            </div>
            <br>';
            
//============================================================================================================================================
// SE CREA LA TABLA CON SU NOMBRE PARA LA VISTA                                                                                              3
//============================================================================================================================================
            $tablas_estructuras='';
            foreach ($this->nombres_config as $value) {
                $tablas_estructuras .= $this->config($this->$value,'table');
            }
            
            $estructura = [
                "dato" => '<div align="center">'.$this->pagination->create_links().'</div>'.$tablas_estructuras.'<div class="row"><div id="guia_info1" class="col-xs-12"><textarea name="" id="editor1" cols="30" rows="10"></textarea>'.$botones.'</div></div>'.'<div align="center">'.$this->pagination->create_links().'</div>',
                "titulo_general" => "Infome Elavorado",
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
                    //echo var_dump($this->funciones->verificar_array($valores,['3']));
                    $this->config($this->$value,'update',$this->funciones->verificar_array($valores,['3']));
                    //var_dump($this->funciones->verificar_array($valores));
                }

            }
	}

        
        public function borrardatos()
	{
            foreach ($this->nombres_config as $value) {
                
                if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("delete from guia_informativo where id_usuario=".$this->session->userdata('id_usuario')." and id_guia=".$this->input->post('id_guia',true).""));
                    
                    echo $this->input->post('id_guia',true);
                    
                    //$valores= array_values($this->input->post('parametros'));
                    //$this->config($this->$value,'delete',$this->funciones->verificar_array($valores));
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
                    
                    $new_param=array_merge($this->input->post('parametros'),[':limite' =>$this->limite_paginacion,':id_usuario' => $this->session->userdata('id_usuario')]);
                    //$jsonvar=$this->$value('result',' where id_topico = '.array_values($this->input->post('parametros'))[1].' order by id_comentario asc limit '.$this->limite_paginacion.' OFFSET '.($this->limite_paginacion*(array_values($this->input->post('parametros'))[0] - 1)));
                    //echo $this->funciones->strReplaceAssoc($new_param,$this->{$value}[0]['where']);
                    echo $this->config($this->$value,'result',  $this->funciones->strReplaceAssoc_from($new_param,$this->{$value}[0]['where']));
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
        
        
        public function opciones_valoracion()
	{   
            //foreach ($this->nombres_config as $value) {
                //$this->input->post('parametros',true)[1]
                //if ($this->config($this->$value,'configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $datos_agregados=$this->input->post('parametros');
                    $datos_agregados[':id_usuario']=$this->session->userdata('id_usuario');
                    $valores= $datos_agregados;
                    
                    //echo $this->config($this->tabla1,'sqlmanual',array("select * from from get_mensajes(2,1) "))->result();
                    
                    //if ($this->input->post('opcion',true)=='Me gusta'){
                    //$array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into valoraciones_comentarios (id_usuario,id_guia) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_guia',true).")"));
                    
                    //echo $array_mensaje;
                    //}  else {
                    //$array_mensaje=$this->config($this->tabla1,'sqlmanual',array("delete from valoraciones_comentarios where id_usuario=".$this->session->userdata('id_usuario')." and id_guia=".$this->input->post('id_guia',true).""));
                    
                    //echo $array_mensaje;
                    
                    //};
                    
                //}

            //}
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
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("insert into favoritos_informativo (id_usuario,id_doc) values (".$this->session->userdata('id_usuario').",".$this->input->post('id_doc',true).")"));
                    
                    echo $array_mensaje;
                    }  else {
                    $array_mensaje=$this->config($this->tabla1,'sqlmanual',array("delete from favoritos_informativo where id_usuario=".$this->session->userdata('id_usuario')." and id_doc=".$this->input->post('id_doc',true).""));
                    
                    echo $array_mensaje;
                    
                    };
                    
                //}

            //}
	}
        
        public function get_info_comentario()
	{
            
             $query2 = $this->db->query('
            select get_info_comentario('.$this->input->post('id_guia',true).') as comen');
            $row = $query2->row();

            if (isset($row))
            {
                    echo $row->comen;
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

            
            return $pila;
	}
        
}
