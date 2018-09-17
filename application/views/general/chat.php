<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="chat">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary collapsed-box direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Chat</h3>

              <div class="box-tools pull-right">
                <span data-toggle="tooltip" id="mennuevo" title="" class="badge bg-light-blue" >0</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                  <i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->

              <!-- Contacts are loaded here -->
              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  
                  <!-- End Contact Item -->
                </ul>
                <!-- /.contatcts-list -->
              </div>
              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="">
              <form action="file:///C:/Users/Jos%C3%A9Miguel/Desktop/AdminLTE-2.4.0-rc/AdminLTE-2.4.0-rc/pages/widgets.html#" method="post">
                <div class="input-group">
                  <input id="id_mensaje" type="text" name="message" placeholder="Escribe un mensaje ..." class="form-control">
                      <span class="input-group-btn">
                        <button id="mensaje_enviar" type="submit" class="btn btn-primary btn-flat">Enviar</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
		  
		  
		  
        </div>