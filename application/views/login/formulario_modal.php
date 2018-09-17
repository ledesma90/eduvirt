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
                    'id' => $dato[0]['update_table'].'pais'
                ];

                $param2 = [
                    'name' => $dato[0]['update_table'].'gentilicio',
                    'placeholder' => 'gentilicio',
                    'id' => $dato[0]['update_table'].'gentilicio'
                ];
             ?>
            <label>
                <?= form_label('Nombre','nombre') ?>
                <?= form_input($param1) ?>
            </label>

            <label>
                <?= form_label('Gentilicio','gentilicio') ?>
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




    

