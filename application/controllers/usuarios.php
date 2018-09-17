<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Usuarios extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();
          $this->load->model('manejador');
          $this->load->helper('clase_dinamica');
          $this->load->library('table');
          $this->load->helper('form');
          $this->funciones->salir();

        }
 
//============================================================================================================================================
// Nombre de las funciones de configuraciones                                                                                                1
//============================================================================================================================================
    var $nombres_config=array('config');
//============================================================================================================================================
// Fin de los nombres de las funciones de configuraciones                                                                                    1
//============================================================================================================================================
    
        
//============================================================================================================================================
// CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                                   2-1
//============================================================================================================================================
        public function config($opcion=null,$datos=null)
	{
            $config[] = array(
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => array(
                    "p.id_usuario","usuario","password","estado","valor","encode(imagen, 'base64') as imagen "
                ),
                "calculado" =>  array(
                    "Caccion"
                ),
                "clave_primaria" =>  array(
                    "id_usuario"
                ),
                "columnas_actualizables" =>  array(
                    "id_usuario","usuario","password"
                ),
                "comillas_actualizables" =>  array(
                    "N","S","S"
                ),
                "update_table" => "usuarios",
                "join" => "usuarios as p",
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
            );
            
            return $this->opraciones_basicas($opcion,$datos,$config);

	}
//============================================================================================================================================
// FIN DE LA CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                         2-1
//============================================================================================================================================
        
        

        public function opraciones_basicas($opcion=null,$datos=null,$config=null)
	{
            $manejador=$this->manejador->transaccion($config);
            if($opcion==null){
            return $manejador;
            }
            if($opcion=='result'){
            return json_encode($this->manejador->getdatos($manejador));
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
                $estructura_tabla  = '<button id="insertar'.$config[0]['update_table'].'" type="button">Insertar</button>';
                $estructura_tabla .= '<button id="modificar'.$config[0]['update_table'].'" type="button">Modificar</button>';
                $estructura_tabla .= '<button id="borrar'.$config[0]['update_table'].'" type="button">Borrar</button>';
                $estructura_tabla .= '<button id="grabar_imagen_'.$config[0]['update_table'].'" type="button">Grabar imagen</button>';
                return $estructura_tabla .= $this->manejador->gettable($config[0]['update_table'], array_merge($config[0]["select"],$config[0]["calculado"]));
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
            $estructura = [
                "dato" => $this->config('table'),
                "titulo_tabla" => "ABM de Usuarios",
                "titulo_general" => "Usuarios",
                "id_usuario" => $this->session->userdata('id_usuario'),
                "usuario" => $this->session->userdata('usuario')
            ];
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
            

            
  
            
            
            
            
            $this->load->view('general/cabecera');  

            $this->load->view('general/cabecera');  

            $this->load->view('general/menu',$estructura);//funciona
            $this->load->view('general/menu_izquierdo',$estructura);//funciona
            $this->load->view('general/contenido',$estructura);
            $this->load->view('usuarios/formulario_modal',["dato" => $this->config('configname')]);
            $this->load->view('general/pie');
            $this->load->view('general/menu_derecho');//parece funcionar
            $this->load->view('general/scripts');
//============================================================================================================================================
// Misma cantidad de vistas de funciones por cantidad de tablas configuradas echas                                                           4
//============================================================================================================================================
            $this->load->view('usuarios/funciones',["dato" => $this->config('configname'),"segmento" => base_url().$this->router->fetch_class().'/']);
//============================================================================================================================================
// Fin de misma cantidad de vistas de funciones por cantidad de tablas configuradas echas                                                    4
//============================================================================================================================================
	}

       
        public function grabardatos()
	{
        
            foreach ($this->nombres_config as $value) {
                
                if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $valores= array_values($this->input->post('parametros'));
                    //echo var_dump($valores);
                    $this->$value('update',$valores);
                }

            }
	}

        
        public function borrardatos()
	{
            foreach ($this->nombres_config as $value) {
                
                if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
                    $valores= array_values($this->input->post('parametros'));
                    $this->$value('delete',$valores);
                }

            }
	}
        
        
        public function result()
	{   
            foreach ($this->nombres_config as $value) {
                
                if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
                    echo $this->$value('result');
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

            
            
            
            $this->config('sqlmanual',array("update usuarios set imagen=decode('{$escaped}' , 'hex') where id_usuario=".$this->input->post('id_usuario',true)));
            redirect('/usuarios/', 'refresh');
	}
        
        
}
