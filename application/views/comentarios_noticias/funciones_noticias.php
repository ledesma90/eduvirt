<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
//<script type="text/javascript" >

var <?= $dato[0]['update_table'] ?>;
var <?= $dato[0]['update_table'] ?>id_curso=$(location).attr('href').split( '/' )[5];

    var <?= $dato[0]['update_table'] ?>descripcion = CKEDITOR.replace("<?= $dato[0]['update_table'] ?>descripcion", {
    });

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
                        $parametros .= ($dato[0]['elementos_form'][$value1]['tipo']=='textarea'?  "$value1:"."CKEDITOR".".instances.".$dato[0]['update_table'].$value1.".getData()".","    :($dato[0]['elementos_form'][$value1]['grabar_formato']=='N'? "$value1: $( \"#".$dato[0]['update_table']."$value1\" )."."inputmask('unmaskedvalue')":"$value1: $( \"#".$dato[0]['update_table']."$value1\" ).".'val()').",");
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

            var id_noticia=$(location).attr('href').split( '/' )[5];
                var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{<?= ( $cadena_parametros==""? "'':''" : $cadena_parametros) ?>
                    , ':id_noticia':id_noticia
                    }};
<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
        "bLengthChange": false,
        "pageLength": 15,
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
            { "data": "id_noticia","visible": false,"searchable": false,"sTitle": "Id","sWidth": "70%" },
            { "data": "id_usuario","visible": false,"searchable": false,"sTitle": "Curso"/*,"sWidth": "30%"*/ },
            { "data": "descripcion","visible": false,"searchable": false,"sTitle": "Grupo","sWidth": "10%" },
            { "data": "titulo","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "estado","visible": true,"searchable": true,"sTitle": "Nombre de la clase"/*,"sWidth": "30%"*/ },
            { "data": "foto","visible": false,"searchable": true,"sTitle": "Grupo","sWidth": "10%" },
            { "data": "imagen","visible": false,"searchable": true,"sTitle": "Grupo","sWidth": "10%" },
            { "data": "usuario","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "fecha_formato","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "info_boton","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "info_noticia","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
        ],
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        "columnDefs": [
            {
                "targets": [ 4 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    
                        return '<div class="box box-widget">\n\
            <div class="box-header with-border">\n\
              <div class="user-block">\n\
                <img class="direct-chat-img" src="data:image/jpg; base64 ,'+row.imagen+'"  alt="Imagen"><!-- /.direct-chat-img -->\n\
                <span class="username"><a href="file:///C:/Users/Jos%C3%A9Miguel/Desktop/AdminLTE-2.4.0-rc/AdminLTE-2.4.0-rc/pages/widgets.html#">'+row.usuario+'</a></span>\n\
                <span class="description">'+row.titulo+' - '+row.fecha_formato+'</span>\n\
              </div>\n\
              <!-- /.user-block -->\n\
            <!-- /.box-header -->\n\
            <div class="box-body">\n\
              '+row.descripcion+'\n\
              <button id="ext_me_gusta" onclick="opciones_valoracion(this,'+row.id_noticia+')" type="button" class="btn btn-default btn-xs">'+row.info_boton+'</button>\n\
              <span id="info_noticia'+row.id_noticia+'" class="pull-right text-muted">'+row.info_noticia+'</span>\n\
            </div>\n\
            <!-- /.box-footer -->\n\
          </div>'
                      
                        


                  }
                
            }
        ],
        "order": [[0,'desc']],
        "fnDrawCallback": function( oSettings ) {
            $(oSettings.nTHead).hide();
            $(oSettings.nTFoot).hide();
 

            

            
          },
         "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                $('th', nRow).attr('width','100px');
                $('td:eq(0)', nRow).attr('style','width:70%;');
                $('td:eq(1)', nRow).attr('style','width:10%;text-align: center;');
                $('td:eq(2)', nRow).attr('style','width:10%;text-align: center;');
                $('td:eq(3)', nRow).attr('style','width:10%;text-align: center;');

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
      if (msg.trim()!=''){
          alert( msg.trim() );
      }
      <?= $dato[0]['update_table'] ?>.ajax.reload();
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
    
    
    $('#<?= $dato[0]['update_table'] ?> tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            <?= $dato[0]['update_table'] ?>.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            <?php  
            foreach ($dato[0]['hijos'] as $value) {
            echo "leer".$value."();";
            }
            ?>
            
        }
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
                
            CKEDITOR.instances.<?= $dato[0]['update_table'] ?>descripcion.setData("");
            $( "#<?= $dato[0]['update_table'] ?>id_curso").val(<?= $dato[0]['update_table'] ?>id_curso);
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
                    CKEDITOR.instances.<?= $dato[0]['update_table'] ?>descripcion.setData(<?= $dato[0]['update_table'] ?>.row('.selected').data().<?= $dato[0]['columnas_actualizables'][2] ?>);
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


function opciones_valoracion(objeto,id_noticia){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>opciones_valoracion',
        data: {'id_noticia':id_noticia,'opcion':objeto.innerHTML}
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

        if (msg==1){
            if(objeto.innerHTML== 'Me gusta'){
                objeto.innerHTML = '<i class="fa fa-fw fa-thumbs-o-up"></i>';
            }
                                else{
                objeto.innerHTML = 'Me gusta';
            };
            get_info_noticia(id_noticia);
        }else{
            
        };
          
      });
        
        
        

        
    };
    
    
    function get_info_noticia(id_noticia){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>get_info_noticia',
        data: {'id_noticia':id_noticia}
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

            $('#info_noticia'+id_noticia).html(msg.trim());
          
      });
        
        
        

        
    };

//</script>