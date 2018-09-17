<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//============================================================================================================================================
// 1- CONFIGURAR EL CONTROLADOR
// 2- CONFIGURAR LAS FUNCIONES PARA LA DATATABLE
// 3- CREAR Y CONFIGURAR EL MODAL CON EL FORMULARIO CORRESPONDIENTE                                                                                                  1
//============================================================================================================================================
class Plantilla extends CI_Controller {


	 function __construct()
        {
             
          parent::__construct();
          $this->load->model('manejador');
          $this->load->helper('clase_dinamica');
          $this->load->library('table');
          $this->load->library('funciones');
          $this->load->helper('form');

        }
 
//============================================================================================================================================
// Nombre de las funciones de configuraciones                                                                                                1
//============================================================================================================================================
    var $nombres_config=array('config');
//============================================================================================================================================
// Fin de los nombres de las funciones de configuraciones                                                                                    1
//============================================================================================================================================
    var $arraynuevo = array(0=>array(
                //los arrays (select y calculado) deben ser igualmente proporcional a las columnoas configuradas en la datatable
                "select" => array(
                    "id_pais","nombre","gentilicio"
                ),
                "calculado" =>  array(
                    
                ),
                "clave_primaria" =>  array(
                    "id_pais"
                ),
                "columnas_actualizables" =>  array(
                    "nombre","gentilicio"
                ),
                "comillas_actualizables" =>  array(
                    "S","S"
                ),
                "update_table" => "paises",
                "join" => "paises",
                "tipo_actualizacion" => "update",//delete/insert or update
                "tipo_parametros_ajax" => "completo",//completo or clave_primaria or columna_primaria_actualizables (son las variables que se pasan en la funcion con ajax)
            ));
        
        
//============================================================================================================================================
// CONFIGURACION DEL MANEJADOR DE LA TABLA                                                                                                   2-2
//============================================================================================================================================
        public function config($array,$opcion=null,$datos=null)
	{
            return $this->opraciones_basicas($opcion,$datos,$array);
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
                $estructura_tabla  = '<button id="insertar'.$config[0]['update_table'].'" type="button">Insertar</button>';
                $estructura_tabla .= '<button id="modificar'.$config[0]['update_table'].'" type="button">Modificar</button>';
                $estructura_tabla .= '<button id="borrar'.$config[0]['update_table'].'" type="button">Borrar</button>';
                return $estructura_tabla .= $this->manejador->gettable($config[0]['update_table'], array_merge($config[0]["select"],$config[0]["calculado"]));
            }
            if($opcion=='configname'){
                return $this->manejador->getselectname($config);
            }
            if($opcion=='selectname'){
                return $this->manejador->getselectname($config);
            }
	}



        
        
	public function index()
	{   
            
            
            
//============================================================================================================================================
// SE CREA LA TABLA CON SU NOMBRE PARA LA VISTA                                                                                              3
//============================================================================================================================================
            //$estructura = [
            //    "dato" => $this->config('table'),
            //    "titulo_tabla" => "ABM de Paises",
            //    "titulo_general" => "Paises"
            //];
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
            echo CI_VERSION;
            echo $this->funciones->getMacAddr();
            echo '<br>';
            
            //$this->load->view('plantilla/select');  
            echo var_dump($this->config($this->arraynuevo,'table'));
            //echo var_dump($this->arraynuevo);
            //$this->load->view('general/cabecera');  

            echo '<br/>    <img id="barcode" src="http://www.eduvirt.com/dist/img/Captura.jpg"/>
    <br/>
    <button onclick="alert(getBarcodeFromImage(\'barcode\'))">Scan</button>';
            
            echo '
<script type="text/javascript" >                
/*
 *    Copyright (c) 2010 Tobias Schneider
 *    This script is freely distributable under the terms of the MIT license.
 */

(function(){
    var UPC_SET = {
        "3211": \'0\',
        "2221": \'1\',
        "2122": \'2\',
        "1411": \'3\',
        "1132": \'4\',
        "1231": \'5\',
        "1114": \'6\',
        "1312": \'7\',
        "1213": \'8\',
        "3112": \'9\'
    };
    
    getBarcodeFromImage = function(imgOrId){
        var doc = document,
            img = "object" == typeof imgOrId ? imgOrId : doc.getElementById(imgOrId),
            canvas = doc.createElement("canvas"),
            ctx = canvas.getContext("2d"),
            width = img.width,
            height = img.height,
            spoints = [1, 9, 2, 8, 3, 7, 4, 6, 5],
            numLines = spoints.length,
            slineStep = height / (numLines + 1);
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0);
        while(numLines--){
            console.log(spoints[numLines]);
            var pxLine = ctx.getImageData(0, slineStep * spoints[numLines], width, 2).data,
                sum = [],
                min = 0,
                max = 0;
            for(var row = 0; row < 2; row++){
                for(var col = 0; col < width; col++){
                    var i = ((row * width) + col) * 4,
                        g = ((pxLine[i] * 3) + (pxLine[i + 1] * 4) + (pxLine[i + 2] * 2)) / 9,
                        s = sum[col];
                    pxLine[i] = pxLine[i + 1] = pxLine[i + 2] = g;
                    sum[col] = g + (undefined == s ? 0 : s);
                }
            }
            for(var i = 0; i < width; i++){
                var s = sum[i] = sum[i] / 2;
                if(s < min){ min = s; }
                if(s > max){ max = s; }
            }
            var pivot = min + ((max - min) / 2),
                bmp = [];
            for(var col = 0; col < width; col++){
                var matches = 0;
                for(var row = 0; row < 2; row++){
                    if(pxLine[((row * width) + col) * 4] > pivot){ matches++; }
                }
                bmp.push(matches > 1);
            }
            var curr = bmp[0],
                count = 1,
                lines = [];
            for(var col = 0; col < width; col++){
                if(bmp[col] == curr){ count++; }
                else{
                    lines.push(count);
                    count = 1;
                    curr = bmp[col];
                }
            }
            var code = \'\',
                bar = ~~((lines[1] + lines[2] + lines[3]) / 3),
                u = UPC_SET;
            for(var i = 1, l = lines.length; i < l; i++){
                if(code.length < 6){ var group = lines.slice(i * 4, (i * 4) + 4); }
                else{ var group = lines.slice((i * 4 ) + 5, (i * 4) + 9); }
                var digits = [
                    Math.round(group[0] / bar),
                    Math.round(group[1] / bar),
                    Math.round(group[2] / bar),
                    Math.round(group[3] / bar)
                ];
                code += u[digits.join(\'\')] || u[digits.reverse().join(\'\')] || \'X\';
                if(12 == code.length){ return code; break; }
            }
            if(-1 == code.indexOf(\'X\')){ return code || false; }
        }
        return false;
    }
})();
</script>
';
            //$this->load->view('general/menu');//funciona
            //$this->load->view('general/menu_izquierdo');//funciona
            //$this->load->view('general/contenido',$estructura);
            //$this->load->view('general/vista_tabla',$estructura);
            //$this->load->view('paises/formulario_modal',["dato" => $this->config('configname')]);
            //$this->load->view('general/pie');
            //$this->load->view('general/menu_derecho');//parece funcionar
            //$this->load->view('general/scripts');
//============================================================================================================================================
// Misma cantidad de vistas de funciones por cantidad de tablas configuradas echas                                                           4
//============================================================================================================================================
            //$this->load->view('paises/funciones',["dato" => $this->config('configname'),"segmento" => base_url().$this->router->fetch_class().'/']);
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
            foreach ($this->nombres_config as $value) {
                
                if ($this->$value('configname')[0]['update_table']==$this->input->post('tipo',true)){
                    echo $this->$value('result');
                }

            }
	}
        
        
}
