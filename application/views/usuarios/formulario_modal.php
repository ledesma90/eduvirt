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
        <div class="modal-body">
            <?php 

                $param1 = [
                    'name' => $dato[0]['update_table'].'nombre',
                    'placeholder' => 'nombre',
                    'id' => $dato[0]['update_table'].$dato[0]['columnas_actualizables'][1]
                ];

                $param2 = [
                    'name' => $dato[0]['update_table'].'pass',
                    'placeholder' => 'contraseña',
                    'id' => $dato[0]['update_table'].$dato[0]['columnas_actualizables'][2]
                ];
                
                $param3 = [
                    'name' => $dato[0]['update_table'].'id_usuario',
                    'placeholder' => 'usuario',
                    'id' => $dato[0]['update_table'].$dato[0]['columnas_actualizables'][0]
                ];
             ?>
            <label>
                <?= form_label('Usuario','nombre') ?>
                <?= form_input($param3) ?>
            </label>
            
            <label>
                <?= form_label('Nombre','nombre') ?>
                <?= form_input($param1) ?>
            </label>

            <label>
                <?= form_label('Contraseña','pass') ?>
                <?= form_input($param2) ?>
            </label>
              
        </div>
        <div class="modal-footer">
            <div id="grabar_marco_<?= $dato[0]['update_table'] ?>" style="display: none">
                <button id="grabar_dato_<?= $dato[0]['update_table'] ?>" type="button" class="btn btn-default" data-dismiss="modal">Grabar</button>
            </div>
            <div id="borrar_marco_<?= $dato[0]['update_table'] ?>" style="display: none">
                <button id="borrar_dato_<?= $dato[0]['update_table'] ?>" type="button" class="btn btn-default" data-dismiss="modal">Borrar</button>
            </div>
        </div>
      </div>
    </div>
  </div>




    

