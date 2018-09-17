<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Certificado extends CI_Controller {


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


        
        
	public function index()
	{   
            
//============================================================================================================================================
// SE CREA LA TABLA CON SU NOMBRE PARA LA VISTA                                                                                              3
//============================================================================================================================================
            //$pila=$this->ejecucion_primaria();
            		$data = [];

		$hoy = date("dmyhis");

        //load the view and saved it into $html variable
        $html = 
        '<style>@page 
    {
        size:  auto;   /* auto es el valor inicial */
        margin: 0mm;  /* afecta el margen en la configuración de impresión */
        padding: 0mm; 
        size: landscape;
    }
			</style>".
        "<body>

<div style="width:100%; height:750px; padding:20px; text-align:center; border: 10px solid #787878">
<div style="width:100%; height:700px; padding:20px; text-align:center; border: 5px solid #787878">
       <span style="font-size:50px; font-weight:bold" >Eduvirt</span>
       <br><br>
       <span style="font-size:50px; font-weight:bold">Certificado de Culminación</span>
       <br><br>
       <span style="font-size:25px"><i>Este documento certifica que</i></span>
       <br><br>
       <span style="font-size:30px"><b>'.$this->input->post('nombre',true).'</b></span><br/><br/>
       <span style="font-size:25px"><i>ha completado el curso</i></span> <br/><br/>
       <span style="font-size:30px">'.$this->input->post('curso',true).'</span> <br/><br/>
       <span style="font-size:20px">Con el Puntaje del <b>'.$this->input->post('nota',true).'</b></span> <br/><br/><br/><br/>
       <span style="font-size:25px"><i>Fecha</i></span><br>
      '.$this->input->post('fecha',true).'
      <span style="font-size:30px"></span>
</div>
</div>

        </body>';

        // $html = $this->load->view('v_dpdf',$date,true);
 		
 		//$html="asdf";
        //this the the PDF filename that user will get to download
        $pdfFilePath = "cipdf_".$hoy.".pdf";
 
        //load mPDF library
        $this->load->library('M_pdf');
        $mpdf = new mPDF('c', 'A4-L'); 
 		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath, "D");
                
            //$this->load->view('certificado/plantilla',['fecha'=>'fecha 22/09/2018 con la nota 4','alumno'=>'José Miguel Ledesma Ibarra','curso'=>'Curso de excelencia en PHP']);
            

	}

        
        
        
       
       

        
        
        
        
        
        
        
        
        
        
        public function salir()
	{   
            $this->session->sess_destroy();
            
            echo'salida';
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
