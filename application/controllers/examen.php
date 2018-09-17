<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Examen extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->database();
          $this->load->model('manejador');
          $this->load->helper('clase_dinamica');

        }


var $tabla1 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "respuesta_tutor", "id_test", "id_usuario", "respuesta", "nombre_respuesta"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "respuesta_tutor"
                ],
                "columnas_actualizables" =>  [
                    "id_test", "id_usuario", "respuesta", "nombre_respuesta"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "update_table" => "respuesta_tutor",
                "join" => "respuesta_tutor",
                "where" => "",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini-fin',
                'columna' => 'ini-fin',
                'dimension_tabla' => '12',
                'titulo' => 'Examenes',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];



var $tabla2 = [0=>[
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => [
                    "respuesta_alumno", "id_test", "id_usuario", "respuesta", "nombre_respuesta"
                ],
                "calculado" =>  [
                    
                ],
                "clave_primaria" =>  [
                    "respuesta_alumno"
                ],
                "columnas_actualizables" =>  [
                    "id_test", "id_usuario", "respuesta", "nombre_respuesta"
                ],
                "elementos_atributo_prohibidos" =>  [
                    "fila","dimension_input","label","tipo","select_dato","select_default","grabar_formato"
                ],
                "update_table" => "respuestas_alumno",
                "join" => "respuesta_tutor",
                "where" => "",
                "lectura_where_variables" => ['' =>['','']],//P significa que busca la variable del padre
                "lectura_inicial" => "N",//S significa que lee del principio, caso contrario espera que se apriete el boton de leer
                "action" => ['visible'=>'N','opciones' =>['S','S','S','S']],//activar el boton de accion||insertar||mofificar||borrar||leer
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
                "padre" => ["",""],//tabla padre/clave primaria del padre
                "hijos" => [],//hijos de esta tabla para la lectura automatica al seleccionar
                'fila' => 'ini-fin',
                'columna' => 'ini-fin',
                'dimension_tabla' => '12',
                'titulo' => 'Examenes',
                'class_tabla' => 'table no-margin compact nowrap',//opciones display/cell-border/compact/hover/nowrap/order-column/row-border/stripe
            ]
           ];
        
        
	public function index()
	{   
            
            $manejador=$this->manejador->transaccion($this->tabla1);
            
            $estutor= $this->manejador->sqlmanual($manejador,['select count(1) as existe from tests inner join cursos on (tests.id_curso=cursos.id_curso) where id_usuario='.$this->session->userdata('id_usuario').' and id_test='.$this->session->userdata('id_test'),'existe']);
            if ($estutor==1){
            
                $this->manejador->sqlmanual($manejador,['delete from respuesta_tutor where id_usuario='.$this->session->userdata('id_usuario').' and id_test='.$this->session->userdata('id_test')]);

                $objeto=$manejador->crearObjeto(['',$this->session->userdata('id_test'),$this->session->userdata('id_usuario'),null,null]);



                //var_dump($_POST);
                $mensaje='';
                $contador=1;
                $value_aux;

                $mensaje.='Resultados Insertados <br />';
                foreach( $_POST as $name => $value ) {
                    $value_aux=(empty($value)?"no envio respuesta":$value);



                    if (is_array($value_aux)){
                        $contadorsub=1;
                        foreach( $value_aux as $valuesub1 ) {
                            $mensaje.= "$contador-$contadorsub) Campo: $name, valor: $valuesub1<br />";
                                        $objeto->setRespuesta("'".$valuesub1."'");
                                        $objeto->setNombre_respuesta("'".$name."'");
                                        $this->manejador->update($objeto);
                            $contadorsub+=1;
                        }
                    }else{
                        $mensaje.= "$contador-) Campo: $name, valor: $value_aux<br />";
                                    $objeto->setRespuesta("'".$value_aux."'");
                                    $objeto->setNombre_respuesta("'".$name."'");
                                    $this->manejador->update($objeto);
                        $contador+=1;
                    }
                }  
                //print_r($this->input->post('mensaje',true));
                $this->load->view('examen/mensaje',['mensaje'=>$mensaje]);
            }else{
                
                $manejador=$this->manejador->transaccion($this->tabla2);
                //$this->manejador->sqlmanual($manejador,['delete from respuestas_alumno where id_usuario='.$this->session->userdata('id_usuario').' and id_test='.$this->session->userdata('id_test')]);

                $objeto=$manejador->crearObjeto(['',$this->session->userdata('id_test'),$this->session->userdata('id_usuario'),null,null]);



                //var_dump($_POST);
                $mensaje='';
                $contador=1;
                $value_aux;

                $mensaje.='Resultados Insertados <br />';
                foreach( $_POST as $name => $value ) {
                    $value_aux=(empty($value)?"no envio respuesta":$value);



                    if (is_array($value_aux)){
                        $contadorsub=1;
                        foreach( $value_aux as $valuesub1 ) {
                            $mensaje.= "$contador-$contadorsub) Campo: $name, valor: $valuesub1";
                                        $objeto->setRespuesta("'".$valuesub1."'");
                                        $objeto->setNombre_respuesta("'".$name."'");
                            $mensaje.=  $this->manejador->update($objeto)."<br />";
                            $contadorsub+=1;
                        }
                    }else{
                        $mensaje.= "$contador-) Campo: $name, valor: $value_aux";
                                    $objeto->setRespuesta("'".$value_aux."'");
                                    $objeto->setNombre_respuesta("'".$name."'");
                        $mensaje.=  $this->manejador->update($objeto)."<br />";
                        $contador+=1;
                    }
                }  
                //print_r($this->input->post('mensaje',true));
                
                $this->manejador->sqlmanual($manejador,['SELECT public.pr_corregir_examen('.$this->session->userdata('id_test').','.$this->session->userdata('id_usuario').');']);
                $this->load->view('examen/mensaje',['mensaje'=>$mensaje]);
            }
            
            
	}

       


      
        
        
       
        
        
}
