<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Registro extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();

        }



        
        
	public function index()
	{   
            
            $this->load->view('registro/registro');  
            $this->load->view('registro/funciones',["segmento" => base_url().$this->router->fetch_class().'/',"base_url" => base_url()]);
            
	}

       


      
        
        
        public function result()
	{    
            
            $mensaje='';
            
            $this->db->select('email');
            $this->db->from('personas');
            $this->db->where('email',$this->input->post('email',true));
            $count_correo = $this->db->get()->num_rows();
            
            
            $this->db->select('usuario');
            $this->db->from('usuarios');
            $this->db->where('usuario',$this->input->post('usuario',true));
            $count_usuario = $this->db->get()->num_rows();
            
            
            if (strlen($this->input->post('password',true))==0) {
                $mensaje= 'No ha ingresado una Contraseña';
            }elseif ($this->input->post('check',true)!='on') {
                $mensaje= 'No ha aceptado los terminos';
            }elseif (strlen($this->input->post('email',true))==0) {
                $mensaje= 'No ha ingresado un Correo';
            }elseif ($count_correo>0) {
                $mensaje= 'El correo ingresado ya existe';
            
            }elseif (strlen($this->input->post('usuario',true))==0) {
                $mensaje= 'No ha ingresado un Usuario';
            }elseif ($count_usuario>0) {
                $mensaje= 'El usuario se encuentra registrado';
            }elseif ($this->input->post('password',true)<>$this->input->post('password2',true)){
                $mensaje= 'Las contraseñas ingresadas no coinciden';
            }else{
                            $data = array(
                                    'nombre' => $this->input->post('nombre',true),
                                    'apellido'  => $this->input->post('apellido',true),
                                    'email'  => $this->input->post('email',true),
                                    'genero'  => $this->input->post('genero',true),
                            );


                            $sql = $this->db->set($data)->get_compiled_insert('personas');

                            $query = $this->db->query($sql);
                            
                                if ($query){
                                    $data = array(
                                            'usuario' => $this->input->post('usuario',true),
                                            'password'  => $this->input->post('password',true),
                                            'id_usuario'  => $this->db->insert_id(),
                                            'estado' => 'I'
                                    );


                                    $sql = $this->db->set($data)->get_compiled_insert('usuarios');

                                    $query = $this->db->query($sql);
                                    
                                    if ($query){
                                        $mensaje= 'Registro concretado!. Le llegará un correo cuando Activación sea realizada';
                                    }else {
                                        $mensaje= 'Error al insertar el Usuario';
                                    }
                                    
                                }
                                else {
                                    $mensaje= 'Error al insertar la Persona';
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
