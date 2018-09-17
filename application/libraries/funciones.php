<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Funciones extends CI_Model {
        
    function __constructor(){
        parent::__construct();
    }
    
    public function strReplaceAssoc($replace, $subject) { 
        $tmp = array();
        
        $replace = $this->security->xss_clean($replace);
        foreach ($replace as $clave => $valor) {
            $tmp[$clave] = $this->test_input($valor);
        }
        //var_dump($tmp);
        $var = str_replace(array_keys($replace), array_values($tmp), $subject);    
        //$var = $this->db->escape($var);
        //echo $var;
        if ($subject!=''){
            $var='where '.$var;
        }
        return $var;
    }
    
    public function strReplaceAssoc_from($replace, $subject) { 
        $tmp = array();
        
        $replace = $this->security->xss_clean($replace);
        foreach ($replace as $clave => $valor) {
            $tmp[$clave] = $this->test_input($valor);
        }
        //var_dump($tmp);
        $var = str_replace(array_keys($replace), array_values($tmp), $subject);    
        //$var = $this->db->escape($var);
        //echo $var;
        if ($subject!=''){
            $var=''.$var;
        }
        return $var;
    }
    
    public function verificar_array($replace,$dato_codificado='') { 
        $tmp = array();
        
        if (is_array($dato_codificado)){
            $replace=$this->caracteres_especiales_codificar($replace,$dato_codificado);
        }
        
        $replace = $this->security->xss_clean($replace);
        foreach ($replace as $clave => $valor) {
            $tmp[$clave] = $this->test_input($valor);
        }

        return $tmp;
    } 
    
    public function caracteres_especiales_codificar($replace,$dato_dec) { 
        $tmp = array();
        
        
        foreach ($replace as $clave => $valor) {
            if (in_array($clave,$dato_dec)){
                $replace[$clave]=base64_encode($valor);
            }
        }

        return $replace;
    } 
    
    public function caracteres_especiales_decodificar($replace,$dato_dec) { 
        $tmp = array();
        
        
        foreach ($replace as $clave => $valor) {
            foreach ($dato_dec as $columna) {
                $valor->$columna=base64_decode($valor->$columna);
            }
            $tmp[$clave] = $valor;
        }

        return $tmp;
    } 
        
    public function test_input($data) {
        $data = $this->db->escape($data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    public function getMacAddr() {
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom=utf8_encode(ob_get_contents()); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer

        $findme = "Direcci¢n";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac=substr($mycom,($pmac+46),17); // Get Physical Address
        //return $mac;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        echo var_dump($_SERVER);
    }
    
    public function array_x_hijos($replace) { 
        $tmp = array();
        
        foreach ($replace as $clave) {
            $tmp[$clave['id_insignia']] = $clave['descripcion'];
        }
        
        return $tmp;
    } 
    
    public function salir() { 
        if ( is_null($this->session->userdata('id_usuario') ) ){
            redirect('/login', 'refresh');
        };
        
        $query2 = $this->db->query('
            select distinct id_rol as id_rol
            from roles_x_usuarios where id_usuario='.$this->session->userdata('id_usuario').'');
            $pila = array();
            foreach ($query2->result() as $row)
            {
                array_push($pila, $row->id_rol);
            }
          
        if (in_array(1,$pila)) {
            return 'vacio';
        };
        
        if (in_array(3,$pila)) {
            $tutor=array('proyectos_x_personas','instituciones','proyectos','persona','mensajes','parametros_ubicacion','noticias','categoria_topicos','topicos','comentarios','calendario','cursos_alumnos','cursos_x_clases','lecciones','tareas','cursos','personas_buscador','perfil','cursos_categoria','test','cursos_resultados','estadistica','comentarios_noticias','certificado','categoria_informativo','documento_informativo','guia_informativo');
            if (in_array($this->router->fetch_class(),$tutor)){
                return 'vacio';
            };
        };
        
        if (in_array(2,$pila)) {
            $tutor=array('proyectos_x_personas','instituciones','proyectos','persona','mensajes','parametros_ubicacion','noticias','categoria_topicos','topicos','comentarios','calendario','cursos_alumnos','cursos_x_clases','lecciones','tareas','personas_buscador','perfil','test','cursos_resultados','estadistica','comentarios_noticias','certificado','categoria_informativo','documento_informativo','guia_informativo');
            if (in_array($this->router->fetch_class(),$tutor)){
                return 'vacio';
            };
        };
        
          
        redirect('/sin_permiso', 'refresh');
        
          
        return 'vacio';
    }
    
}


?>


