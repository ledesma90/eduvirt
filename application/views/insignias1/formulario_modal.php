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

                $nombre = [
                    'name' => $dato[0]['update_table'].'nombre',
                    'placeholder' => 'descripcion',
                    'id' => $dato[0]['update_table'].'descripcion'
                ];

                $pass = [
                    'name' => $dato[0]['update_table'].'insignia',
                    'placeholder' => 'numero insignia',
                    'id' => $dato[0]['update_table'].'nivel'
                ];
             ?>
            <label>
                <?= form_label('Descripcion','descripcion') ?>
                <?= form_input($nombre) ?>
            </label>

            <label>
                <?= form_label('Nivel','nivel') ?>
                <?= form_input($pass) ?>
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




    

