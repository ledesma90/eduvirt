<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    
<style>
@page 
    {
        size:  auto;   /* auto es el valor inicial */
        margin: 0mm;  /* afecta el margen en la configuración de impresión */
        padding: 0mm; 
        size: landscape;
    }
</style>



<div style="position: relative;
    display: inline-block;
    text-align: center;">
  <img style="width:1200px; height:770px;" src="imagenes/TEMPLATE_CERTIFICADO.jpg" />
  <div style="position: absolute;
    top: 58%;
    left: 46%;
    transform: translate(-45%, -46%);
    font-size: 35px;"><?= $curso ?></div>
  <div style="position: absolute;
    top: 43%;
    left: 46%;
    transform: translate(-45%, -46%);
    font-size: 35px;"><?= $alumno ?></div>
  <div style="position: absolute;
    top: 73%;
    left: 46%;
    transform: translate(-45%, -46%);
    font-size: 35px;"><?= $fecha ?></div>
</div>

