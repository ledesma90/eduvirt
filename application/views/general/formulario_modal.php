<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>  
<!-- Modal -->
  <div class="modal fade" id="myModal_<?= $dato[0]['update_table'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Inserción de datos </h4>
        </div>
          <form action="" onsubmit="return false">
        <div class="modal-body">
            
            <?php  
                $contador=0;
                foreach ($dato[0]['elementos_form'] as $clave => $valor) {
                    $atributos_permitidos=array_diff_key($valor, array_flip($dato[0]['elementos_atributo_prohibidos']));
                    if ($atributos_permitidos['id']==''){
                    $atributos_permitidos=array_replace($atributos_permitidos,['id'=>$dato[0]['update_table'].$clave]);
                    }
                    if ($atributos_permitidos['name']==''){
                    $atributos_permitidos=array_replace($atributos_permitidos,['name'=>$clave]);
                    }
                    //var_dump($atributos_permitidos);
                    try {
                    $atributos_permitidos=array_replace($atributos_permitidos,['data-inputmask'=>array_map('htmlspecialchars', array_map('stripslashes', $valor))['data-inputmask']]);
                    }

                    //catch exception
                    catch(Exception $e) {
                    //  echo 'Message: ' .$e->getMessage();
                    }
                    if (in_array($atributos_permitidos['name'], $dato[0]['columnas_actualizables']) || substr($atributos_permitidos['name'], 0, -1)=='bloque'){
                            if ('ini'===$valor['fila'] || 'ini-fin'===$valor['fila']){
                                echo '<div class="row">';
                            }

                            echo '<div class="col-xs-'.$valor['dimension_input'].'"> ';
                            if (strlen($valor['label'])>0){
                                echo form_label($valor['label'],$atributos_permitidos['id']).'<div id="requerido_'.$atributos_permitidos['id'].'" style="color:#FF0000;display:none;";>*</div>';
                            }
                            if ($valor['tipo']=='input' || $valor['tipo']=='bloque'){
                            echo form_input($atributos_permitidos);
                            }
                            if ($valor['tipo']=='textarea'){
                            echo form_textarea($atributos_permitidos);
                            }
                            if ($valor['tipo']=='password'){
                            echo form_password($atributos_permitidos);
                            }
                            if ($valor['tipo']=='select'){
                                if (is_array($valor['select_dato'])){
                                    $tmp1=$valor['select_dato'];
                                }else{
                                    $tmp0=$this->db->query($valor['select_dato'])->result();
                                    
                                            $tmp1 = array();
        
                                            foreach ($tmp0 as $clave) {
                                                $tmp1[$clave->id] = $clave->valor;
                                            }

                                            $tmp1;
                                            
                                    
                                    
                                }
                            echo form_dropdown($atributos_permitidos,$tmp1);
                            }
                            echo '</div>';
                            if ('fin'===$valor['fila'] || 'ini-fin'===$valor['fila']){
                                echo '</div>';
                            }
                            $contador++;
                    }
                }
            ?>
              
        </div>
        <div class="modal-footer">
            <div id="grabar_marco_<?= $dato[0]['update_table'] ?>" style="display: none">
                <button id="grabar_dato_<?= $dato[0]['update_table'] ?>" type="button" class="btn btn-default" >Grabar</button>
            </div>
            <div id="borrar_marco_<?= $dato[0]['update_table'] ?>" style="display: none">
                <button id="borrar_dato_<?= $dato[0]['update_table'] ?>" type="button" class="btn btn-default" >Borrar</button>
            </div>
        </div>
          </form>
      </div>
    </div>
  </div>




    

