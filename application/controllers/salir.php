<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Salir extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();


        }

	public function index()
	{   
            
            $this->session->sess_destroy();
            
            echo'salida';

	}

        
}
