<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Login extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();

        }



        
        
	public function index()
	{   
            
            $this->load->view('login/login');  
            $this->load->view('login/funciones',["segmento" => base_url().$this->router->fetch_class().'/',"base_url" => base_url()]);
            
	}

       


      
        
        
        public function result()
	{    
            
            
                $query = $this->db->query('
                select usuario_out as usuario, existe_usuario_out as existe_usuario, id_usuario_out as id_usuario, imagen_out as imagen
                from get_usuario(\''.$this->input->post('parametros',true)[1].'\',\''.$this->input->post('parametros',true)[2].'\')    
                ');
                
                
                
                
                
            /*$query = $this->db->query('
                SELECT 
                \''.$this->input->post('parametros',true)[1].'\' as usuario,
                \''.$this->input->post('parametros',true)[2].'\' as password,
                \'S\' as existe_usuario, 
                \'192.168.1.110\' as ip
                    FROM dummy');*/

            //echo $query->num_rows();
            
            //$row = $query->row();
            //if (isset($row))
            //{
            //    
            //    if ($row->existe_usuario=='S'){
            //        redirect('/ruoti/index', 'refresh');
            //    };
            //
            //};
            
            $resultado=json_encode($query->result());
                
                        $newdata = array(
                                'id_usuario'    => $query->row()->id_usuario,
                                'logged_in'     => $query->row()->existe_usuario,
                                'usuario'       => $query->row()->usuario,
                                'imagen'        => $query->row()->imagen
                        );

                        $this->session->set_userdata($newdata);
                
                        //echo (in_array(1,$this->session->userdata('tipo'))? 'Administrador':'no admin');
            
            echo json_encode(["login"=>$query->row()->existe_usuario]);
            
             //echo $this->input->post('parametros',true)[1];
             //echo $this->input->post('parametros',true)[2];

	}
        
        
}
