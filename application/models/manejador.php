<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Manejador extends CI_Model
{
 function __constructor(){
     parent::__construct();
     $this->load->database();
 }
    
 function transaccion($data)
 {
    return new administrador($data);
 }
 
 function getid($data)
 {  
    return $data->getid($data,$this->db);
 }
 
 function update($data)
 {  
    return $data->update($data,$this->db);
 }
  
 function delete($data)
 {    
    return $data->delete($data,$this->db);    
 }
 
 function getdatos($data,$parametros=null,$select=null)
 {    
    return $data->getdatos($this->db,$parametros,$select);
 }
 
 function getdatossql($data,$parametros=null)
 {    
    return $data->getdatossql($this->db,$parametros);
 }
 
 function getcount($data,$parametros=null)
 {    
    return $data->getcount($this->db,$parametros);
 }
 
  function sqlmanual($data,$parametros=null)
 {    
    return $data->sqlmanual($this->db,$parametros);
 }
 
 function gettable($id,$data)
 {
    $template = array(
    'table_open'            => '<table id="'.$id['update_table'].'" class="'.$id['class_tabla'].'" cellspacing="0" width="100%">'
    );

    $this->table->set_template($template);   
    
    $pila = array();
    foreach ($data as $clave => &$valor) {
            $pos=strpos($valor, ' as ');
            if ($pos>0){
                $var =trim(substr($valor, $pos+3 ));
            }else {
                $pos=strpos($valor, '.');
                if ($pos===false){
                    $var =trim($valor);
                }else{
                    $var =trim(substr($valor, $pos+1 ));
                }
                
            }
    
            array_push($pila, $var);
    }
    
    
    $this->table->set_heading($pila);
     
    return $this->table->generate();
 }
 
 function getselectname($data)
 {    
    $pila = array();
    foreach ($data[0]['select'] as &$valor) {
            $pos=strpos($valor, ' as ');
            if ($pos>0){
                $var =trim(substr($valor, $pos+3 ));
            }else {
                $pos=strpos($valor, '.');
                if ($pos===false){
                    $var =trim($valor);
                }else{
                    $var =trim(substr($valor, $pos+1 ));
                }
                
            }
    
            array_push($pila, $var);
    }
    array_push($data,$pila);
    return $data;
 }
 
 
 
}
?>
