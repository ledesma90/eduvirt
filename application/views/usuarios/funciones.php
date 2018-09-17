<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" >

var <?= $dato[0]['update_table'] ?>;

$( "#grabar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
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
    
    var parametros_grabar = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{  
                <?php  
                $parametros='';
                foreach ($dato[1] as $value1) {
                    
                    
                    if (in_array($value1, $dato[0]['clave_primaria'])){
                        $parametros .= "$value1: id,";
                    }elseif (in_array($value1, $dato[0]['columnas_actualizables'])) {
                        $parametros .= "$value1: $( \"#".$dato[0]['update_table']."$value1\" ).val(),";
                    }  else {
                        $parametros .= "$value1: \"\",";
                    }
                    
                }
                echo substr($parametros, 0, -1);
                ?>
                        //1:id, 
                        //2: $( "#<?= $dato[0]['update_table'].$dato[0]['columnas_actualizables'][0] ?>" ).val(), 
                        //3: $( "#<?= $dato[0]['update_table'].$dato[0]['columnas_actualizables'][1] ?>" ).val() 
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


});

$( "#borrar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
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


});


$( "#grabar_imagen_<?= $dato[0]['update_table'] ?>" ).click(function() {
    
    alert($(":file").val());
    var id;
    try {
        id=<?= $dato[0]['update_table'] ?>.row('.selected').data().<?= $dato[0]['clave_primaria'][0] ?>;
    }
    catch(err) {
        alert('Seleccione una fila para borrar, por favor');
    }
    
    var parametros_borrar = {
        id_usuario        : id,
        direccion         :'http://eduvirt/ckfinder/userfiles/images/66617_1705870246402_1198847_n.jpg'};
  $.ajax({
    method: "POST",
    url: '<?= $segmento ?>grabarimagen',
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


});


$(document).ready(function() {
    
    var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{1:numero
                    }};
<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
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
            { "data": "id_usuario","visible": true,"searchable": true,"sTitle": "Id"/*,"sWidth": "30%"*/ },
            { "data": "usuario","visible": true,"searchable": true,"sTitle": "Usuario"/*,"sWidth": "30%"*/ },
            { "data": "password","visible": true,"searchable": true,"sTitle": "Password"/*,"sWidth": "30%"*/ },
            { "data": "estado","visible": true,"searchable": true,"sTitle": "Estado"/*,"sWidth": "30%"*/ },
            { "data": "valor","visible": true,"searchable": true,"sTitle": "Valor"/*,"sWidth": "30%"*/ },
            { "data": "imagen","visible": true,"searchable": true,"sTitle": "Imagen"/*,"sWidth": "30%"*/ },
            { "orderable": false, render:function(data,type,row){
                    return  '<form enctype="multipart/form-data" action="<?= $segmento ?>grabarimagen" method="POST">\n\
                            <div style="display: none">\n\
                            <input type="text" name="id_usuario" value="'+row.id_usuario+'">\n\
                            </div>\n\
                            <input name="uploadedfile" type="file" /><input type="submit" value="Subir archivo" /></form>';
            },"sTitle": "Acción","sWidth": "12%" }
        ],
        "columnDefs": [
            {
                "targets": [ 4 ], 
                "render" : function( data, type, row ) {
                    if (data==null){
                        data='';
                    }
                        return 'Gs. '+data.replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'<br>'+row.usuario; 
                  }
                
            },
            {
                "targets": [ 5 ], 
                "render" : function( data, type, row ) {
                    if (data==null){
                        data='';
                        return data;
                    }                        
                        return '<img src="data:image/jpg; base64 ,'+data+'" alt="'+row.id_usuario+'" height="42" width="42">'; 
                  }
                
            },
        ]
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
        }
    } );
 
//============================================================================================================================================
// CONFIGURACION DEL MODAL Y BOTONES DEL MODAL EN BASE A LOS BOTONES POSICIONADOS ENCIMA DE LA DATATABLE                                     5
//============================================================================================================================================
    $('#insertar<?= $dato[0]['update_table'] ?>').click( function () {
        <?php  
        foreach ($dato[0]['columnas_actualizables'] as $value) {
        echo "$( \"#".$dato[0]['update_table']."$value\" ).val('');";
        }
        ?>
        $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).show();
        $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
        $("#myModal_<?= $dato[0]['update_table'] ?>").modal();       
    } );
    
    $('#modificar<?= $dato[0]['update_table'] ?>').click( function () {
            try {
                <?php  
                foreach ($dato[0]['columnas_actualizables'] as $value) {
                  echo "$( \"#".$dato[0]['update_table']."$value\" ).val(".$dato[0]['update_table'].".row('.selected').data().$value);";
                }
                ?>
                $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).show();
                $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
                $("#myModal_<?= $dato[0]['update_table'] ?>").modal();
            }
            catch(err) {
                alert('Seleccione una fila para modificar, por favor');
                //alert(err.message);
            }
         
    } );
    
    $('#borrar<?= $dato[0]['update_table'] ?>').click( function () {
            try {
                <?php  
                foreach ($dato[0]['columnas_actualizables'] as $value) {
                  echo "$( \"#".$dato[0]['update_table']."$value\" ).val(".$dato[0]['update_table'].".row('.selected').data().$value);";
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
//============================================================================================================================================
// FIN                                                                                                                                       5
//============================================================================================================================================
    
    
} );

</script>