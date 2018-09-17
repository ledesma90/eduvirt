<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="/ruoti" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Edu</b>V</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Edu</b>virt</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            
           <li class="dropdown messages-menu">
<form action="http://www.eduvirt.com/personas_buscador/" method="get" style="margin-top:10px" >
        <div class="input-group">
          <input type="text" name="buscador" class="form-control" placeholder="Persona...">
              <span class="input-group-btn" style="width:0%">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
</li>
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= (strlen($imagen)>0)?"data:image/jpg; base64 ,$imagen":base_url('/dist/img/generic-user-purple.png') ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $usuario ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= (strlen($imagen)>0)?"data:image/jpg; base64 ,$imagen":base_url('/dist/img/generic-user-purple.png') ?>" class="img-circle" alt="User Image">

                <p>
                  <?= $usuario ?>
                  <small>Miembro de Eduvirt</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>

              </li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                </div>
                <div class="pull-right">
                  <a id="salir" class="btn btn-default btn-flat">Desconectarse</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa fa-folder"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
