<?php
defined('BASEPATH') OR exit('No direct script access allowed');


//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Ruoti extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->model('manejador');
          $this->load->helper('clase_dinamica');
          $this->load->library('table');
          $this->load->helper('form');
          
          if ( is_null($this->session->userdata('id_usuario') ) ){
            redirect('/login', 'refresh');
          };
          
        }
 
//============================================================================================================================================
// Nombre de las funciones de configuraciones                                                                                                1
//============================================================================================================================================
    var $nombres_config=array('config');
//============================================================================================================================================
// Fin de los nombres de las funciones de configuraciones                                                                                    1
//============================================================================================================================================
    
        
        
//============================================================================================================================================
// CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                                   2-2
//============================================================================================================================================
        public function config($opcion=null,$datos=null)
	{
            $config[] = array(
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => array(
                    "id","codigo","descripcion","uni_base","uni_plan","uni_comparada","diferencia_uni","diferencia_gs","gs_base","gs_plan","gs_comparada"
                ),
                "calculado" =>  array(
                    
                ),
                "web_service_columnas" =>  array(
                    "","","","","",""
                ),
                "clave_primaria" =>  array(
                    "persona"
                ),
                "columnas_actualizables" =>  array(
                    "persona","primer_nombre","segundo_nombre"
                ),
                "comillas_actualizables" =>  array(
                    "N","S","S"
                ),
                "update_table" => "dummy",
                "join" => "dummy",
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
            );
            
            return $this->opraciones_basicas($opcion,$datos,$config);
            
	}
//============================================================================================================================================
// FIN DE LA CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                         2-2
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
                $estructura_tabla  = '';
                //$estructura_tabla  = '<button id="insertar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-plus " style="margin-right: 1px; margin-top: 1px; width: 100px;"  type="button"> Insertar  </button>';
                //$estructura_tabla .= '<button id="modificar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-edit" style="margin-right: 1px; margin-top: 1px; width: 100px;"  type="button"> Modificar </button>';
                //$estructura_tabla .= '<button id="borrar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-trash-o" style="margin-right: 1px; margin-top: 1px; width: 100px;"  type="button"> Borrar    </button>';
                $estructura_tabla .= '<button id="recuperar'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul" style="margin-right: 1px; margin-top: 1px; width: 100px;"    type="button"> Recuperar      </button>';
                $estructura_tabla .= '<button id="leer'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul" style="margin-right: 1px; margin-top: 1px; width: 100px;"    type="button"> Leer      </button>';
                $estructura_tabla .= '<button id="atras'.$config[0]['update_table'].'" class="btn btn-primary fa fa-list-ul disabled" style="margin-right: 1px; margin-top: 1px; width: 100px;"    type="button"> Atras      </button>';
                
                
                
                
                
               
                
                $estructura_tabla .= ' <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Fecha Inicial:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" data-inputmask="\'alias\': \'dd/mm/yyyy\'" data-mask="" id="datepicker">
                </div>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Fecha final:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" data-inputmask="\'alias\': \'dd/mm/yyyy\'" data-mask="" id="datepicker2">
                </div>
        </div>
         <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <!-- /.form-group -->
                <div class="form-group">
                    <label>Categoria</label>
                    <select id="select_categoria" class="form-control" style="width: 100%;">

                    </select>
                </div>
        <!-- /.col -->
        
      </div>
      
</div>';
                
                
                
                
                
                return $estructura_tabla .= $this->manejador->gettable($config[0]['update_table'], array_merge($config[0]["select"],$config[0]["calculado"]));
            }
            if($opcion=='configname'){
                return $this->manejador->getselectname($config);
            }
            if($opcion=='selectname'){
                return $this->manejador->getselectname($config);
            }
            if($opcion=='sqlmanual'){
                return $this->manejador->sqlmanual($config,$datos);
            }
	}



        
        
	public function index()
	{   
            
//============================================================================================================================================
// SE CREA LA TABLA CON SU NOMBRE PARA LA VISTA                                                                                              3
//============================================================================================================================================
            $estructura = [
                "dato" => $this->config('table'),
                "titulo_tabla" => "ABM de Ventas",
                "titulo_general" => "Ruoti",
                'id_usuario' => $this->session->userdata('id_usuario')
            ];
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
            
            
            //$query = $this->db->query('SELECT persona, primer_nombre FROM personas');

            //foreach ($query->result() as $row)
            //{
            //        echo $row->persona;
            //        echo $row->primer_nombre;
            //}
            
            //echo $this->config('sqlmanual','select 1 from dummy');
            
                //$url ='http://mba:terere@172.20.10.2:12345/ejemplo';
                //$json = file_get_contents($url);
                //$array = json_decode($json,true);
                //$limite_array = count($array) - 1;
                
                $dat2='[["'.implode('","',$this->config('configname')[0]['web_service_columnas']).'"]]';
                
                
                $urldatos ='http://192.168.1.110:49166/select_criterios_x_cubo';
                $dat2 = file_get_contents($urldatos);
                
                
                
                
                
                //$dat1=implode('","',$array[0]);
                //$dat1='["'.$dat1.'"]';
                //echo $dat2;
                //return var_dump($array[0]);
            
            
            
            $this->load->view('general/cabecera');  

            $this->load->view('general/menu',$estructura);//funciona
            $this->load->view('general/menu_izquierdo',$estructura);//funciona
            $this->load->view('general/contenido',$estructura);
            //$this->load->view('general/vista_tabla',$estructura);
            $this->load->view('ruoti/formulario_modal',["dato" => $this->config('configname')]);
            $this->load->view('general/pie');
            $this->load->view('general/menu_derecho');//parece funcionar
            $this->load->view('general/scripts');
//============================================================================================================================================
// Misma cantidad de vistas de funciones por cantidad de tablas configuradas echas                                                           4
//============================================================================================================================================
            $this->load->view('ruoti/funciones',["dato" => $this->config('configname'),"segmento" => base_url().$this->router->fetch_class().'/',"array_datos" => $dat2]);
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
                    echo $this->$value('update',$valores);
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
            //foreach ($this->nombres_config as $value) {
                
                //echo $this->input->post('tipo',true);
                //echo vardum$this->$value('configname');//[0]['update_table'];
                //if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
//                    echo $this->$value('result');
                //}
                
                //$date = $this->input->post('parametros',true)[2];
                //$dateInfo = date_parse_from_format('j/n/Y', $date);
                //echo $dateInfo['year'].''.$dateInfo['month'].''.$dateInfo['day'];
                
                $l_fecha_ini=$this->input->post('parametros',true)[2];
                $l_fecha_ini= substr($l_fecha_ini, -4).''.substr($l_fecha_ini, 3, 2).''.substr($l_fecha_ini, 0, 2);
                //echo $l_fecha_ini;
                
                $l_fecha_fin=$this->input->post('parametros',true)[3];
                $l_fecha_fin= substr($l_fecha_fin, -4).''.substr($l_fecha_fin, 3, 2).''.substr($l_fecha_fin, 0, 2);
                //echo $l_fecha_fin;
                
                $url3 ='http://192.168.1.110:49166/pr_cargar_ventasdetalle_aux_web?pi_fecha_ini='.$l_fecha_ini.'&pi_fecha_fin='.$l_fecha_fin.'&pi_usuario='.$this->session->userdata('id_usuario');

                //$url3 ='http://mba:terere@172.20.10.2:12345/ejemplo';
                //$url3 ='http://192.168.1.110:12345/web_service?service_parm1='.$this->input->post('parametros',true)[1];
                //$url3 ='http://192.168.1.110:49166/pr_cargar_ventasdetalle_aux_web?pi_fecha_ini=20170801&pi_fecha_fin=20170830&pi_usuario=dba';
                $json3 = file_get_contents($url3);
                //$array3 = json_decode($json3,true);
                //$limite_array3 = count($array3) - 1;
                
                
                //$dat4='[';
                //for ($x = 0; $x <= $limite_array3 ; $x++) {
                //    $dat3=implode('","',$array3[$x]);
                //    $dat3='["'.$dat3.'"]';
                //    $dat4.=$dat3;
                //    if($limite_array3<>$x){
                //        $dat4.= ',';
                //    }
                //    else{
                //        $dat4.= ']';
                //    }
                //} 
                
                    
                //$dat8='[["'.implode('","',$this->$value('configname')[0]['calculado']).'"]]';
                    
                    

                
                //echo $dat8;
                //echo $this->input->post('parametros',true)[1];
                echo $json3;

            //}
	}
        
        
        public function leer_result()
	{   
            //foreach ($this->nombres_config as $value) {
                
                //echo $this->input->post('tipo',true);
                //echo vardum$this->$value('configname');//[0]['update_table'];
                //if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
//                    echo $this->$value('result');
                //}
                
                //$date = $this->input->post('parametros',true)[2];
                //$dateInfo = date_parse_from_format('j/n/Y', $date);
                //echo $dateInfo['year'].''.$dateInfo['month'].''.$dateInfo['day'];
                $l_fecha_ini=$this->input->post('parametros',true)[2];
                $l_fecha_ini= substr($l_fecha_ini, -4).''.substr($l_fecha_ini, 3, 2).''.substr($l_fecha_ini, 0, 2);
                //echo $l_fecha_ini;
                
                $l_fecha_fin=$this->input->post('parametros',true)[3];
                $l_fecha_fin= substr($l_fecha_fin, -4).''.substr($l_fecha_fin, 3, 2).''.substr($l_fecha_fin, 0, 2);
                //echo $l_fecha_fin;
                
                $url3 ='http://192.168.1.110:49166/pr_recorrer_cubo_web?pi_cubo=2&pi_criterio_cod='.$this->input->post('parametros',true)[1].'&pi_valor='.$this->input->post('parametros',true)[4].'&pi_usuario='.$this->session->userdata('id_usuario');
                $json3 = file_get_contents($url3);

                echo $json3;

            //}
	}
        
         public function recuperar_criterio()
	{   
            //foreach ($this->nombres_config as $value) {
                
                //echo $this->input->post('tipo',true);
                //echo vardum$this->$value('configname');//[0]['update_table'];
                //if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
//                    echo $this->$value('result');
                //}
                
                //$date = $this->input->post('parametros',true)[2];
                //$dateInfo = date_parse_from_format('j/n/Y', $date);
                //echo $dateInfo['year'].''.$dateInfo['month'].''.$dateInfo['day'];
                
                
                $url3 ='http://192.168.1.110:49166/select_criterios_x_cubo';
                $json3 = file_get_contents($url3);

                echo $json3;

            //}
	}
        
                 public function salir()
	{   
            $this->session->sess_destroy();
            
            $url3 ='http://192.168.1.110:49166/pr_limpiar_ventasdetalle_aux_web?pi_usuario='.$this->session->userdata('id_usuario');
            $json3 = file_get_contents($url3);
	}
        
        
}
