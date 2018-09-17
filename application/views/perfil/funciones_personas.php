<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
//<script type="text/javascript" >

var <?= $dato[0]['update_table'] ?>;

<?php if($dato[0]['action']['visible']=='S'){ ?>
    $( "#grabar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
        grabar_dato_<?= $dato[0]['update_table'] ?>()
    });

    $('#leer<?= $dato[0]['update_table'] ?>').click( function () {
        leer<?= $dato[0]['update_table'] ?>();
    } );

    $( "#borrar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
        borrar_dato_<?= $dato[0]['update_table'] ?>()
    });
<?php } ?>
    
function grabar_dato_<?= $dato[0]['update_table'] ?>() {
    var id;
    try {
        id=<?= $dato[0]['update_table'] ?>.row('.selected').data().<?= $dato[0]['clave_primaria'][0] ?>;
    }
    catch(err) {
        
       id=$( "#<?= $dato[0]['update_table'] ?><?= $dato[0]['clave_primaria'][0] ?>" ).val();
       if (id==null || id==''){
           id="default";
       }
        
    }
    
    var id_padre;
    try {
        id_padre=<?= ( $dato[0]['padre'][0] == "" ? $dato[0]['update_table'] : $dato[0]['padre'][0] ) ?>.row('.selected').data().<?= ( $dato[0]['padre'][1] == "" ? $dato[0]['clave_primaria'][0] : $dato[0]['padre'][1] ) ?>;
    }
    catch(err) {
        <?php  
        if ($dato[0]['padre'][0] != "" ){
            echo "alert('No ha seleccionado la fila del padre para insertar un nuevo registro');";
        }
        ?>
        
    }
    
    
    var parametros_grabar = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{  
                <?php  
                $parametros='';
                foreach ($dato[1] as $value1) {
                    
                    
                    if ($value1 == $dato[0]['padre'][1]){
                        $parametros .= "$value1: id_padre,";
                    }elseif (in_array($value1, $dato[0]['clave_primaria'])){
                        $parametros .= "$value1: id,";
                    }elseif (in_array($value1, $dato[0]['columnas_actualizables'])) {
                        $parametros .= "$value1: $( \"#".$dato[0]['update_table']."$value1\" ).".($dato[0]['elementos_form'][$value1]['grabar_formato']=='N'? "inputmask('unmaskedvalue')":'val()').",";
                    }else {
                        $parametros .= "$value1: \"\",";
                    }
                    
                }
                echo substr($parametros, 0, -1);
                ?>

                    }};
  $.ajax({
    method: "POST",
    url: '<?= $segmento ?>grabardatos',
//============================================================================================================================================
// DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
//============================================================================================================================================
    data: parametros_grabar
//============================================================================================================================================
// FIN                                                                                                                                       1
//============================================================================================================================================
  })
    .done(function( msg ) {
      //alert( "Data Saved: " + msg );
        
      <?= $dato[0]['update_table'] ?>.ajax.reload();
  });


};
    
    
function leer<?= $dato[0]['update_table'] ?>() { 


        <?php         
       $cadena_parametros='';
            if ($dato[0]['padre'][0] != ""){
                echo "if ( ".( $dato[0]['padre'][0] == "" ? $dato[0]['update_table'] : $dato[0]['padre'][0] ).".rows( '.selected' ).any() ){";
 
                    foreach ($dato[0]['lectura_where_variables'] as $clave => $valor) {
                        if ($clave!=''){
                            if ($valor[1]='P'){
                                $cadena_parametros.= "'".$clave."':".$dato[0]['padre'][0].".row('.selected').data().".$valor[0].",";
                            }
                        }
                    }
                    
                echo "}else{";
                echo "    alert('no selecciono'); return;";
                echo "}";
            }else{
                    foreach ($dato[0]['lectura_where_variables'] as $clave => $valor) {
                        if ($clave!=''){
                            if ($valor[1]='E'){
                                $cadena_parametros.= "'".$clave."': $( \"#".$dato[0]['update_table'].$dato[0]['clave_primaria'][0]." ).val(),";
                            }
                        }
                    }
            }
            $cadena_parametros= substr($cadena_parametros, 0, -1);
            
        ?>

            <?= $dato[0]['update_table'] ?>.destroy();

            var id_usuario=$(location).attr('href').split( '/' )[5];
                    
                var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{<?= ( $cadena_parametros==""? "'':''" : $cadena_parametros) ?>
                    , ':id_usuario':id_usuario
                    }};
<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No hay resultados",
            "info": "Pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "decimal": ",",
            "thousands": ".",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Busqueda:",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Posterior"
            }
        },
        "paging":   false,
        "ordering": true,
        "info":     false,
        "searching": false,
        "ajax": {"url":'<?= $segmento ?>result',
        "type":"POST",
//============================================================================================================================================
// POR SI SE QUIERA PASAR UN DATO PARA FILTAR EL RESUL_SET                                                                                   3
//============================================================================================================================================
        "data":parametros_inicial,
//============================================================================================================================================
// FIN                                                                                                                                       3
//============================================================================================================================================
        "dataSrc": ''/*function(data){
            alert(data[data.length - 1].id_usuario);
            return data;
        }*/
        },
//============================================================================================================================================
// CONFIGURACION DE COLUMNAS A VISUALIZARCE Y FORMATEO DE LOS MISMOS                                                                         4
//============================================================================================================================================
        "columns": [
            { "data": "id_usuario","visible": true,"searchable": true,"sTitle": "Id","sWidth": "100%" },
            { "data": "nombre","visible": false,"searchable": true,"sTitle": "Nombre" },
            { "data": "apellido","visible": false,"searchable": true,"sTitle": "Apellido" },
            { "data": "ruc","visible": false,"searchable": true,"sTitle": "Ruc","className": "colmanas_numeros" },
            { "data": "documento_identidad","visible": false,"searchable": true,"sTitle": "C.I.","className": "colmanas_numeros" },
            { "data": "email","visible": false,"searchable": true,"sTitle": "Email" },
            { "data": "genero","visible": false,"searchable": true,"sTitle": "Genero" },
            { "data": "fecha_nacimiento","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "educacion","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "habilidades","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "info","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "user_nombre","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "imagen","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "ubicacion","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "count_contactos","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "es_contacto","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
            { "data": "insignaia_curso","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros" },
        ],
        "columnDefs": [
            {
                "targets": [ 0 ], 
                "render" : function( data, type, row, meta ) {
                    var l_genero='';
                    if (row.genero==='F'){
                        l_genero='Femenino';
                    }else if(row.genero==='M'){
                        l_genero='Masculino';
                    }
                    
                    var l_es_contacto='';
                    if (row.es_contacto==0){
                        l_es_contacto='<b>Agregar Contacto</b>';
                    }else if(row.es_contacto==1){
                        l_es_contacto='<b>Eliminar Contacto</b>';
                    }
                    
                    var l_imagen='';
                    if (!row.imagen){
                        l_imagen='http://www.eduvirt.com/dist/img/generic-user-purple.png';
                    }else{
                        l_imagen='data:image/jpg; base64 ,'+row.imagen+'';
                    }
                    
                    
                    return '<div class="box-body box-profile">\n\
              <img class="profile-user-img img-responsive img-circle" src="'+l_imagen+'" alt="'+data+'">\n\
              <h3 class="profile-username text-center">'+row.nombre+' '+row.apellido+'</h3>\n\
              <p class="text-muted text-center">'+row.user_nombre+'</p>\n\
              <ul class="list-group list-group-unbordered">\n\
                <li class="list-group-item">\n\
                  <b>Contactos</b> <a class="pull-right">'+row.count_contactos+'</a>\n\
                </li>\n\
                <li class="list-group-item">\n\
                  <b>Genero</b> <a class="pull-right">'+l_genero+'</a>\n\
                </li>\n\
                <li class="list-group-item">\n\
                  <b>Email</b> <a class="pull-right">'+(row.email===null?'':row.email)+'</a>\n\
                </li>\n\
                <li class="list-group-item">\n\
                  <b>Insignia</b> <a class="pull-right">'+(row.insignaia_curso===null?'':row.insignaia_curso)+' <img src="../../dist/img/'+row.insignaia_curso+'.png" alt="insignia" height="25" width="25"></a>\n\
                </li>\n\
              </ul>\n\
            </div>\n\
              <button onclick="add_contacto(this,'+data+')" class="btn btn-primary btn-block">'+l_es_contacto+'</button>\n\
                    <div class="box-body">\n\
              <strong><i class="fa fa-book margin-r-5"></i> Educación</strong>\n\
              <p class="text-muted">\n\
                '+(row.educacion===null?'':row.educacion)+'\n\
              </p>\n\
              <hr>\n\
              <strong><i class="fa fa-map-marker margin-r-5"></i> Ubicación</strong>\n\
              <p class="text-muted">'+(row.ubicacion===null?'':row.ubicacion)+'</p>\n\
              <hr>\n\
              <strong><i class="fa fa-pencil margin-r-5"></i> Habilidades</strong>\n\
              <p>\n\
                '+(row.habilidades===null?'':row.habilidades)+'\n\
              </p>\n\
              <hr>\n\
              <strong><i class="fa fa-pencil margin-r-5"></i> Información</strong>\n\
              <p>\n\
                '+(row.info===null?'':row.info)+'\n\
              </p>\n\
            </div>';
                    
                    
                    
                    return '<div class="box box-widget widget-user-2">\n\
                    <!-- Add the bg color to the header using any of the bg-* classes -->\n\
                    <div class="widget-user-header bg-aqua-active">\n\
                      <!-- /.widget-user-image -->\n\
                      <h3 class="widget-user-username">'+row.nombre+' '+row.apellido+'</h3>\n\
                    </div>\n\
                    <div class="box-footer no-padding">\n\
                      <ul class="nav nav-stacked">\n\
                        <li><a href="#">Documento <span class="pull-right badge bg-blue">'+row.documento_identidad+'</span></a></li>\n\
                        <li><a href="#">Ruc <span class="pull-right badge bg-aqua">'+row.ruc+'</span></a></li>\n\
                        <li><a href="#">Email <span class="pull-right badge bg-green">'+row.email+'</span></a></li>\n\
                        <li><a href="#">Genero <span class="pull-right badge bg-red">'+l_genero+'</span></a></li>\n\
                        <li><a href="#">Nacimiento <span class="pull-right badge bg-red">'+row.fecha_nacimiento+'</span></a></li>\n\
                      </ul>\n\
                    </div>\n\
                  </div>';

                  }
                
            }
        ],
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        "fnDrawCallback": function( oSettings ) {
            $(oSettings.nTHead).hide();
            $(oSettings.nTFoot).hide();
          },
         "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                $('th', nRow).attr('width','100px');
                return nRow;
          }
    } );
                     
         
};


function borrar_dato_<?= $dato[0]['update_table'] ?>() {
    var id;
    try {
        id=<?= $dato[0]['update_table'] ?>.row('.selected').data().<?= $dato[0]['clave_primaria'][0] ?>;
    }
    catch(err) {
        alert('Seleccione una fila para borrar, por favor');
    }
    
    var parametros_borrar = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{  1:id 
                    }};
  $.ajax({
    method: "POST",
    url: '<?= $segmento ?>borrardatos',
//============================================================================================================================================
// SE PASA LA CLAVE PRIMARIA/S PARA EL BORRADO DEL REGISTRO                                                                                  2
//============================================================================================================================================
    data: parametros_borrar
//============================================================================================================================================
// FIN                                                                                                                                       2
//============================================================================================================================================
  })
    .done(function( msg ) {
      //alert( "Data Saved: " + msg );
      <?= $dato[0]['update_table'] ?>.ajax.reload();
  });


};

    function add_contacto(objeto,id_contacto){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>add_contacto',
        data: {'id_contacto':id_contacto,'opcion':objeto.innerHTML}
      })
        .done(function( msg ) {
        if (msg==1){
            if(objeto.innerHTML== '<b>Agregar Contacto</b>'){
                objeto.innerHTML = '<b>Eliminar Contacto</b>';
            }
            else{
                objeto.innerHTML = '<b>Agregar Contacto</b>';
            };
        }else{
            
        };
          
      });
        
        
    };


$(document).ready(function() {

<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No hay resultados",
            "info": "Pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "decimal": ",",
            "thousands": ".",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Busqueda:",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Posterior"
            }
        },
        "paging":   true,
        "ordering": true,
        "info":     true,
        "searching": true
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        
    } );
    
    

 
<?php if($dato[0]['lectura_inicial']=='S'){ ?>
        leer<?= $dato[0]['update_table'] ?>();
<?php } ?>
//============================================================================================================================================
// CONFIGURACION DEL MODAL Y BOTONES DEL MODAL EN BASE A LOS BOTONES POSICIONADOS ENCIMA DE LA DATATABLE                                     5
//============================================================================================================================================


    <?php if($dato[0]['action']['opciones'][0]=='S'){ ?>
        $('#insertar<?= $dato[0]['update_table'] ?>').click( function () {

        <?= $dato[0]['update_table'] ?>.$('tr.selected').removeClass('selected');
            <?php  
            foreach ($dato[0]['columnas_actualizables'] as $value) {
            echo "$( \"#".$dato[0]['update_table']."$value\" ).val('')".($dato[0]['elementos_form'][$value]['tipo']=='select'? '.trigger(\'change\')':'').";";

            if ($value==$dato[0]['padre'][1]){
                echo "$( \"#".$dato[0]['update_table']."$value\" ).val(".( $dato[0]['padre'][0] == "" ? $dato[0]['update_table'] : $dato[0]['padre'][0] ).".row('.selected').data().".( $dato[0]['padre'][1] == "" ? $dato[0]['update_table'] : $dato[0]['padre'][1] ).");";
            }

            }
            
            ?>
            $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).show();
            $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
            $("#myModal_<?= $dato[0]['update_table'] ?>").modal();       
        } );
    <?php } ?>

    <?php if($dato[0]['action']['opciones'][1]=='S'){ ?>   
        $('#modificar<?= $dato[0]['update_table'] ?>').click( function () {
                try {
                    <?php  
                    foreach ($dato[0]['columnas_actualizables'] as $value) {
                      echo "$( \"#".$dato[0]['update_table']."$value\" ).val(".$dato[0]['update_table'].".row('.selected').data().$value)".($dato[0]['elementos_form'][$value]['tipo']=='select'? '.trigger(\'change\')':'').";";
                    }
                    ?>
                    $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).show();
                    $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
                    $("#myModal_<?= $dato[0]['update_table'] ?>").modal();
                    $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
                    
                }
                catch(err) {
                    alert('Seleccione una fila para modificar, por favor');
                    //alert(err.message);
                }

        } );
    <?php } ?>

    <?php if($dato[0]['action']['opciones'][2]=='S'){ ?>   
        $('#borrar<?= $dato[0]['update_table'] ?>').click( function () {
                try {
                    <?php  
                    foreach ($dato[0]['columnas_actualizables'] as $value) {
                      echo "$( \"#".$dato[0]['update_table']."$value\" ).val(".$dato[0]['update_table'].".row('.selected').data().$value)".($dato[0]['elementos_form'][$value]['tipo']=='select'? '.trigger(\'change\')':'').";";
                    }
                    ?>
                    $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
                    $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).show();
                    $("#myModal_<?= $dato[0]['update_table'] ?>").modal();
                }
                catch(err) {
                    alert('Seleccione una fila para borrar, por favor');
                    //alert(err.message);
                }

        } );
    <?php } ?>


    
    
//============================================================================================================================================
// FIN                                                                                                                                       5
//============================================================================================================================================

    
} );

