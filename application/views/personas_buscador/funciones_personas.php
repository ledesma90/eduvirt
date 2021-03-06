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
        borrar_dato_<?= $dato[0]['update_table'] ?>();
        $('#myModal_<?= $dato[0]['update_table'] ?>').modal('hide');
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
                
                
            //var id_usuario=$(location).attr('href').split( '/' )[5];

            var url = new URL($(location).attr('href'));
            var id_buscador = url.searchParams.get("buscador");
            
                var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{<?= ( $cadena_parametros==""? "'':''" : $cadena_parametros) ?>
                    , ':id_buscador':id_buscador
                    }};
<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
        "bLengthChange": false,
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
        "searching": true,
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
            { "data": "id_usuario","visible": true,"searchable": true,"sTitle": "Usuario","sWidth": "5%" },
            { "data": "nombre","visible": true,"searchable": true,"sTitle": "Nombre","sWidth": "20%" },
            { "data": "apellido","visible": true,"searchable": true,"sTitle": "Apellido","sWidth": "20%" },
            { "data": "ruc","visible": false,"searchable": true,"sTitle": "Ruc","className": "colmanas_numeros","sWidth": "10%" },
            { "data": "documento_identidad","visible": false,"searchable": true,"sTitle": "C.I.","className": "colmanas_numeros","sWidth": "10%" },
            { "data": "email","visible": true,"searchable": true,"sTitle": "Email","sWidth": "20%" },
            { "data": "genero","visible": true,"searchable": true,"sTitle": "Genero","sWidth": "5%" },
            { "data": "fecha_nacimiento","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros","sWidth": "10%" },
            { "data": "estado","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros","sWidth": "10%" },
            { "data": "nombre_usuario","visible": false,"searchable": true,"sTitle": "F. Nac.","className": "colmanas_numeros","sWidth": "10%" },
            { "data": "imagen","visible": false,"searchable": false,"sTitle": "F. Nac.","className": "colmanas_numeros","sWidth": "10%" },
        ],
        "columnDefs": [
            {
                "targets": [ 0 ], 
                "render" : function( data, type, row ) {

                    var l_imagen='';
                    if (!row.imagen){
                        l_imagen='http://www.eduvirt.com/dist/img/generic-user-purple.png';
                    }else{
                        l_imagen='data:image/jpg; base64 ,'+row.imagen+'';
                    }
                    
                  
                  return '<div class="direct-chat-msg right"> \n\
                    <!-- /.direct-chat-info -->\n\
                    <img class="direct-chat-img" src="'+l_imagen+'"  alt="Imagen"><!-- /.direct-chat-img -->\n\
                    <a href="http://www.eduvirt.com/perfil/index/'+row.id_usuario+'"  >\n\
                    <div class="direct-chat-text">\n\
                      '+row.nombre_usuario+'\n\
                    </div>\n\
                    </a>\n\
                    <!-- /.direct-chat-text -->\n\
                  </div>';
                  
                  }
                
            },
            {
                "targets": [ 6 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==='F'){
                        data='Femenino';
                    }else if(data==='M'){
                        data='Masculino';
                    }
                    
                    
                        return data;
                  }
                
            }
        ],
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        "fnDrawCallback": function( oSettings ) {
            //$(oSettings.nTHead).hide();
            //$(oSettings.nTFoot).hide();
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

