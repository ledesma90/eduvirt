<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $titulo_general ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a id='direccion' ><i class="fa fa-dashboard"></i> </a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        
        <div id="piechart" style="width: 900px; height: 500px;"></div>
        
        <div id="container" style="width: 900px; height: 500px;">
		<canvas id="canvas"></canvas>
	</div>
	<button id="addData">Insertar barra</button>
	<button id="removeData">Remover barra</button>
          
              <?= $dato ?>
               
            
          <!-- /.box -->

          <!--<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>

            <div class="box-body">
              
            </div>

          </div>-->
          <!-- /.box -->

        <!-- /.col -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

