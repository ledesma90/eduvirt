<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Sin_permiso extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();


        }

	public function index()
	{   
            
            $this->load->view('examen/mensaje',['mensaje'=>'Usted no tiene permiso para acceder a esta ventana']);

	}

        
}
