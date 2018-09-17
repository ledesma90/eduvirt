<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Recuperar_password extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();

        }



        
        
	public function index()
	{   
            
            $this->load->view('recuperar_password/registro');  
            $this->load->view('recuperar_password/funciones',["segmento" => base_url().$this->router->fetch_class().'/',"base_url" => base_url()]);
            
	}

       


      
        
        
        public function result()
	{    
            
            $mensaje='';

            
            
            
            if (strlen($this->input->post('email',true))==0) {
                $mensaje= 'No ha ingresado un Correo';
            }else{
                try {
                    $query1="select id_usuario as id_usuario from personas where email='".$this->input->post('email',true)."'";
                    $query1 = $this->db->query($query1)->row();
                    $query1 = $query1->id_usuario;
    
                } catch (Exception $exc) {
                    $mensaje= 'Dirección de correo invalida';
                }

                
                
                
                                if (strlen($query1)>0){
                                    try {
                                        $query2='select usuario, password from usuarios where id_usuario='.$query1->id_usuario;
                                        $query2 = $this->db->query($query2)->row();
                                        $query2 = $query2->password;
                                    } catch (Exception $exc) {
                                        $mensaje= 'Dirección de correo invalida';
                                    }
                                }else {
                                    $mensaje= 'Dirección de correo invalida';
                                }


                
                                
                            
                                if (strlen($query2)>0){

                                    mail($this->input->post('email',true),"RECUPERACION DE PASSWORD Eduvirt","RECUPERACION DE PASSWORD \r\nUsuario:".$query2->usuario." \r\nPassword: ".$query2->password,"From: eduvirt.cursos@gmail.com");
                                    
                                    $mensaje= 'Mensaje concretado!. Le llegará un correo con su información';
                                    
                                    
                                }
                                else {
                                    $mensaje= 'Dirección de correo invalida';
                                }
            }
            
            $this->load->view('registro/mensaje',['mensaje'=>$mensaje]);  
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
            
            //$resultado=json_encode($query->result());
                
                        //$newdata = array(
                        //        'id_usuario'    => $query->row()->id_usuario,
                        //        'logged_in'     => $query->row()->existe_usuario,
                        //        'usuario'   => $query->row()->usuario,
                        //        'imagen'   => $query->row()->imagen
                        //);

                        //$this->session->set_userdata($newdata);
                
            
            //echo json_encode(["login"=>$query->row()->existe_usuario]);
            
             //echo $this->input->post('parametros',true)[1];
             //echo $this->input->post('parametros',true)[2];

	}
        
        
}
