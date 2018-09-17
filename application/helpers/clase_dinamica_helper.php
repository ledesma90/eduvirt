<?php


class clase_dinamica {
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }

    public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments); // Note: method argument 0 will always referred to the main class ($this).
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
}


    set_error_handler('exceptions_error_handler');

    function exceptions_error_handler($severity, $message, $filename, $lineno) {
      if (error_reporting() == 0) {
        return;
      }
      if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
      }
    }

class administrador {

    var $config;
    var $iSelect='';
    
    public function __construct($config=null) {
        $this->config=$config;
    }

    
    
    public function crearObjeto($valores=null){
        $obj = new clase_dinamica();

        $countValores=0;
        foreach ($this->config[0]["select"] as &$valor) {
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
            try {
            
            $obj->{$var}=$valores[$countValores];
            } catch (Exception $e) {
                //echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
            $countValores++;
        }
        
        
        
        // Create dynamic method. Here i'm generating getter and setter dynimically
        // Beware: Method name are case sensitive.
        foreach ($obj as $func_name => $value) {
            if (!$value instanceOf Closure) {

                $obj->{"set" . ucfirst($func_name)} = function( $stdObject, $value ) use ( $func_name ) {  // Note: you can also use keyword 'use' to bind parent variables.
                    $stdObject->{$func_name} = $value;
                };
                
                $obj->{"get" . ucfirst($func_name)} = function($stdObject) use ($func_name) {  // Note: you can also use keyword 'use' to bind parent variables.
                    return $stdObject->{$func_name};
                };

            }
        }
        
        
        $func2 = "getid";
        $obj->{$func2} = function($stdObject, $retorno=null, $gbd=null) { // $age is the first parameter passed when calling this method.
            $sql=$this->armarselect('getid',$retorno);
            
            try {
            
            $count=$gbd->query($sql)->num_rows();
            } catch (Exception $e) {
                return 0;
            }
            
            //print_r($count);
            if ($count>0) {
                //echo "Encontro el id";
            } else {
                //echo "No encontro el id ";
            }
            return $count;
            
            
            
        };
        
        $func3 = "update";
        $obj->{$func3} = function($stdObject, $retorno=null, $gbd=null) use ( $func2 ) { // $age is the first parameter passed when calling this method.
            $count=$stdObject->{$func2}($retorno,$gbd);
            $sql=$this->armarselect('update',$retorno,$count);
            //echo $sql;
            
            try {
              $gbd->query($sql);
              //If the exception is thrown, this text will not be shown
              //return 'El registro se ha actualizado';
            }

            //catch exception
            catch(Exception $e) {
              //return "- Usted ya envio una respuesta, este valor no sera registrado";
                $mensaje=$e->getMessage();
                
                if (preg_match("/«fk_/i", $mensaje)) {
                    return "El registro no se puede borrar porque esta siendo usado";
                }
                
                $pos = strpos($mensaje, '*')+1;

                if ($pos === false) {
                    return 'Accion no completada';//$e->getMessage();
                } else {
                    $mensaje=substr($mensaje,$pos);
                    
                    $pos = strpos($mensaje, '*');
                    
                    if ($pos === false) {
                        return 'Accion no completada';//$e->getMessage();
                    } else {
                        $mensaje=substr($mensaje,0,$pos);
                        return $mensaje;
                    }
                    
                }
            }
            
            
            
            //if ($gbd->query($sql) == TRUE) {
                //echo "Actualizado correctamente";
            //} else {
                //echo "Error al actualizar ";
            //}
            //return $sql;
        };
        
        $func4 = "delete";
        $obj->{$func4} = function($stdObject, $retorno=null, $gbd=null) use ( $func2 ) { // $age is the first parameter passed when calling this method.
            //$count=$stdObject->{$func2}($retorno,$gbd);
            $sql=$this->armarselect('delete',$retorno);
            //echo $sql;
            
            try {
              $gbd->query($sql);
              //If the exception is thrown, this text will not be shown
              //return 'El registro se ha borrado';
            }

            //catch exception
            catch(Exception $e) {
                $mensaje=$e->getMessage();
                
                if (preg_match("/«fk_/i", $mensaje)) {
                    return "El registro no se puede borrar porque esta siendo usado";
                }
                
                $pos = strpos($mensaje, '*')+1;

                if ($pos === false) {
                    return 'Accion no completada';//$e->getMessage();
                } else {
                    $mensaje=substr($mensaje,$pos);
                    
                    $pos = strpos($mensaje, '*');
                    
                    if ($pos === false) {
                        return 'Accion no completada';//$e->getMessage();
                    } else {
                        $mensaje=substr($mensaje,0,$pos);
                        return $mensaje;
                    }
                    
                }
              
            }
            
            
                    
            //if ($gbd->affected_rows() > 0) {
                //echo "Borrado correctamente";
            //} else {
                //return "Error al borrar ";
            //}
            //return $count;
        };
        
        
        
        $obj->getinfo = function($stdObject) use ( $valores ) { // $stdObject referred to this object (stdObject).
            $lconcatenacion='';
            $lemperajamiento=[];
            $lcolumanasprimordiales=[];
            $lparametros="'".'{';
            $lcontador=0;
            foreach ($stdObject as $func_name => $value) {
                if (!$value instanceOf Closure) {
                    $lconcatenacion=$lconcatenacion . "<td>".$stdObject->{$func_name}."</td>". "\n";
                    $lemperajamiento[$func_name]=$stdObject->{$func_name};
                    if ($this->config[0]["tipo_parametros_ajax"]=="completo"){
                        $lparametros = $lparametros ."\'". $func_name . "\':\'".$stdObject->{$func_name}."\',";
                    }
                }
            }
            

            //var_dump($lemperajamiento);
            if ($this->config[0]["tipo_parametros_ajax"]=="clave_primaria"){
                foreach ($this->config[0]["clave_primaria"] as &$valor) {
                    $lparametros = $lparametros ."\'". $valor . "\':\'".$lemperajamiento[$valor]."\',";
                }
            }
            
            if ($this->config[0]["tipo_parametros_ajax"]=="columna_primaria_actualizables"){
                $lcolumanasprimordiales=array_merge(array_slice($this->config[0]["clave_primaria"], 0),array_slice($this->config[0]["columnas_actualizables"], 0));

                //var_dump($lcolumanasprimordiales);
                foreach ($lcolumanasprimordiales as &$valor) {
                    $lparametros = $lparametros ."\'". $valor . "\':\'". $valores[$lcontador] ."\',";
                    $lcontador++;
                }
            }
            
            
            
            $lparametros= substr($lparametros, 0, -1) .'}'."'";
            //echo $lparametros;
            $lconcatenacion.='<td><button ng-click="myFunction('.$lparametros.')" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">Edit</button></td>'. "\n";
            //$lconcatenacion.='<td><button ng-click="myFunction('.$lparametros.')" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">Del</button></td>'. "\n";
            //$lconcatenacion.='<td><button type="button" onclick="alert(\'Hello world!\')">Click Me!</button></td>'. "\n";
            //$lconcatenacion.='<td><a class="btn btn-default" href ng-click="show()">Show a Modal</a></td>'. "\n";
            return "\n". "<tr>"."\n".$lconcatenacion."</tr>". "\n";
        };
        
        
        /*$obj->setId(1);
        $obj->setNombre('Jose');
        $obj->setApellido('Ledesma');*/
        return $obj;
        

    }
        
    public function armarselect($tipo=null,$objeto=null,$existeid=null){
        $lselect='';
        $where='';
        $insert1='';
        $insert2='';
        $insertdatos1='';
        $insertdatos2='';
        $countcomillas=0;
        if ($tipo==null){
            foreach ($this->config[0]["select"] as &$valor) {
                $lselect = $lselect . "".$valor.",";
            }
            if (is_array($existeid)) {
                if ($objeto==null){
                    $lselect='SELECT '.$this->strReplaceAssoc_select($existeid,substr($lselect, 0, -1)). ' FROM '. $this->config[0]["join"];
                    return $lselect;
                }else{
                    $lselect='SELECT '.$this->strReplaceAssoc_select($existeid,substr($lselect, 0, -1)). ' FROM '. $this->config[0]["join"].' '.$objeto;
                    return $lselect;
                }
            }else{
                
                if ($objeto==null){
                    $lselect='SELECT '.substr($lselect, 0, -1). ' FROM '. $this->config[0]["join"];
                    return $lselect;
                }else{
                    $lselect='SELECT '.substr($lselect, 0, -1). ' FROM '. $this->config[0]["join"].' '.$objeto;
                    return $lselect;
                }
            }
            
        }
        if ($tipo=='update'){
            foreach ($this->config[0]["columnas_actualizables"] as &$valor) {
                
                
                $insert1 = $insert1 . "".$valor.",";
                //if ($this->config[0]["comillas_actualizables"][$countcomillas]=='S') {
                //    $insertdatos1 = $insertdatos1 ."'". $objeto->{$valor} . "',";
                //    $lselect = $lselect . " ".$valor." = " . "'" .$objeto->{$valor} . "'" . " ,";
                //}  else {
                    if($objeto->{$valor}=='\'\'' or is_null($objeto->{$valor})){
                        $insertdatos1 = $insertdatos1 ."null,";
                        $lselect = $lselect . " ".$valor." = null ,";
                    }else{
                        $insertdatos1 = $insertdatos1 ."". $objeto->{$valor} . ",";
                        $lselect = $lselect . " ".$valor." = " . "" .$objeto->{$valor} . "" . " ,";
                    }
                //}
                $countcomillas++;
            }
            
            foreach ($this->config[0]["clave_primaria"] as &$valor) {
                $where = $where . "".$valor." =" . $objeto->{$valor} . ",";
                $insert2 = $insert2 . "".$valor.",";
                if ($objeto->{$valor}=='default'){
                $insertdatos2 = $insertdatos2 ."". $objeto->{$valor} . ",";
                }else{
                $insertdatos2 = $insertdatos2 ."'". $objeto->{$valor} . "',";
                }
            }
            
            if ($existeid==1){
                if ($this->config[0]["tipo_actualizacion"]=='update') {
                    $lselect='UPDATE '. $this->config[0]["update_table"].' SET '.substr($lselect, 0, -1). ' WHERE '.' '.substr($where, 0, -1);
                    return $lselect;
                }else{
                    $lselect='DELETE FROM '. $this->config[0]["update_table"]. ' WHERE '.' '.substr($where, 0, -1)."; ";
                    $lselect=$lselect.'INSERT INTO '. $this->config[0]["update_table"].' ( '.substr($insert1, 0, -1). ' ) VALUES ( ' . substr($insertdatos1, 0, -1) . ' );';
                    return $lselect;
                }
            }else{
                $lselect='INSERT INTO '. $this->config[0]["update_table"].' ( '.substr($insert1, 0, -1). ' ) VALUES ( ' . substr($insertdatos1, 0, -1) . ' )';
                return $lselect;
            }
        }
        if ($tipo=='delete'){
            foreach ($this->config[0]["clave_primaria"] as &$valor) {
                $where = $where . "".$valor." =" . $objeto->{$valor} . " and ";
            }
            $lselect='DELETE FROM '. $this->config[0]["update_table"]. ' WHERE '.' '.substr($where, 0, -5)."; ";
            return $lselect;
        }
        if ($tipo=='getid'){
            foreach ($this->config[0]["clave_primaria"] as &$valor) {
                $where = $where . "".$valor." =" . $objeto->{$valor} . ",";
            }
            $lselect='SELECT 1 as existe FROM '. $this->config[0]["update_table"].' WHERE '.substr($where, 0, -1);
            return $lselect;
        }
        if ($tipo=='contador'){
            if ($objeto==null){
                $lselect='SELECT count(1) as contador FROM '. $this->config[0]["update_table"];
                return $lselect;
            }else{
                $lselect='SELECT count(1) as contador FROM '. $this->config[0]["update_table"].' '.$objeto;
                return $lselect;
            }
        }
        
    }
    
    public function getdatos($gbd,$parametros=null,$select=null){
            $sql = $this->armarselect(null,$parametros,$select);
            return $gbd->query($sql)->result();
    }
    
    public function getdatossql($gbd,$parametros=null){
            $sql = $this->armarselect(null,$parametros);
            return $sql;
    }
    
    public function getcount($gbd,$parametros=null){
            $sql = $this->armarselect('contador',$parametros);
            return $gbd->query($sql)->row()->contador;
    }
    
    public function sqlmanual($gbd,$parametros=null){
            $sql = $parametros[0];
            if (array_key_exists(1, $parametros)){
                return $gbd->query($sql)->row()->{$parametros[1]};
            }else{
                return $gbd->query($sql);
            }
    }
    
    public function strReplaceAssoc_select($replace, $subject) { 
        $tmp = array();
        
        
        foreach ($replace as $clave => $valor) {
            $tmp[$clave] = $valor;
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
        
}