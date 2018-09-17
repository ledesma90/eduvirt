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

    var ckeditor1 = CKEDITOR.replace("editor1", {
        toolbarGroups: [
		{name: "document", groups: ["mode", "document", "doctools"]},
                {name: "clipboard", groups: ["clipboard", "undo"]},
                {name: "editing", groups: ["find", "selection", "spellchecker"]},
                "/",
                {name: "basicstyles", groups: ["basicstyles", "cleanup"]},
                {name: "paragraph", groups: ["list", "indent", "blocks", "align", "bidi"]},
                {name: "links"},
                {name: "insert"},
                "/",
                {name: "styles"},
                {name: "colors"},
                {name: "tools"},
                {name: "others"},
                {name: "about"}
	]
    });
    var idsegmento=$(location).attr('href').split( '/' )[6];
    if (idsegmento===''){
    idsegmento=1;
    }

    var idtopic=$(location).attr('href').split( '/' )[5].substr(5);


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

            
                var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{<?= ( $cadena_parametros==""? "'':''" : $cadena_parametros) ?>
                    }};
                    
                var idsegmento=$(location).attr('href').split( '/' )[6];
    if (idsegmento===''){
    idsegmento=1;
    }

    var idtopic=$(location).attr('href').split( '/' )[5].substr(5);
    var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{':pag':idsegmento, ':topic':idtopic
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
        "ordering": false,
        "info":     false,
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
            { "data": "id_comentario","visible": true,"searchable": false,"sTitle": "Id","className": "arriba_datos"/*,"sWidth": "30%"*/ },
            { "data": "id_usuario","visible": false,"searchable": false,"sTitle": "Usuario","sWidth": "10%" },
            { "data": "id_topico","visible": false,"searchable": false,"sTitle": "Topic"/*,"sWidth": "30%"*/ },
            { "data": "comentario_persona","visible": false,"searchable": true,"sTitle": "Comentario"/*,"sWidth": "30%"*/ },
            { "data": "imagen","visible": false,"searchable": false,"sTitle": "Comentario"/*,"sWidth": "30%"*/ },
            { "data": "usuario","visible": false,"searchable": true,"sTitle": "Comentario"/*,"sWidth": "30%"*/ },
            { "data": "fecha_formato","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "info_boton","visible": false,"searchable": false,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "info_comentario","visible": false,"searchable": false,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "es_usuario","visible": false,"searchable": false,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    var l_data='';
                        l_data= '<div class="box box-widget">\n\
            <div class="box-header with-border">\n\
              <div class="user-block">\n\
                <img class="direct-chat-img" src="data:image/jpg; base64 ,'+row.imagen+'"  alt="Imagen"><!-- /.direct-chat-img -->\n\
                <span class="username"><a href="file:///C:/Users/Jos%C3%A9Miguel/Desktop/AdminLTE-2.4.0-rc/AdminLTE-2.4.0-rc/pages/widgets.html#">'+row.usuario+'</a></span>\n\
                <span class="description">'+row.fecha_formato+'</span>\n\
              </div>\n\
              <!-- /.user-block -->\n\
            <!-- /.box-header -->\n\
            <div class="box-body">\n\
              '+row.comentario_persona+'\n\
              <button onclick="opciones_valoracion(this,'+row.id_comentario+')" type="button" class="btn btn-default btn-xs">'+row.info_boton+'</button>';
                  if (row.es_usuario=='S'){  
           l_data+='<button onclick="modificarregistro('+meta.row+')" type="button" class="btn btn-default btn-xs">Editar</button>\n\
           <button onclick="borrarregistro('+row.id_comentario+')" type="button" class="btn btn-default btn-xs">Eliminar</button>';
                    }
              l_data+='<span id="info_comentario'+row.id_comentario+'" class="pull-right text-muted">'+row.info_comentario+'</span>\n\
            </div>\n\
            <!-- /.box-footer -->\n\
          </div>';
                  
                  return l_data;
                  }
                
            }
        ],
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        "fnDrawCallback": function( oSettings ) {
            $(oSettings.nTHead).hide();
            //$(oSettings.nTFoot).hide();
          },
         "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                $('th', nRow).attr('width','100px');
                $('td:eq(0)', nRow).attr('class','arriba_datos');
                $('td:eq(3)', nRow).attr('class','arriba_datos');
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
        "paging":   false,
        "ordering": false,
        "info":     false,
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
    $( "#grabar_dato_fin_<?= $dato[0]['update_table'] ?>" ).click(function() {
    var id;
    try { 
       id=<?= $dato[0]['update_table'] ?>.row('.selected').data().<?= $dato[0]['clave_primaria'][0] ?>;
    }
    catch(err) {

       if (id==null){
           id="default";
       }

    }
    
    var idsegmento=$(location).attr('href').split( '/' )[6];
    if (idsegmento===''){
    idsegmento=1;
    }

    var idtopic=$(location).attr('href').split( '/' )[5].substr(5);
    
    
    var parametros_grabar = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{  
                        1: id, 
                        2: <?= $this->session->userdata('id_usuario') ?>,
                        3: idtopic,
                        4: CKEDITOR.instances.editor1.getData()
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
      window.location.reload(); 

  });


});
    
    
    
    
    
    
    
} );

    function modificarregistro(data) {
                CKEDITOR.instances.editor1.setData(<?= $dato[0]['update_table'] ?>.row(data).data().<?= $dato[0]['columnas_actualizables'][2] ?>);
                
                    
    };
    
    function borrarregistro(data) {
            var id;

                id=data;


            var parametros_borrar = {
                tipo        :'<?= $dato[0]['update_table'] ?>',
                "id_comentario":id};
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
              document.location.href = document.location.href;

          });
         
    };
    
    function opciones_valoracion(objeto,id_comentario){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>opciones_valoracion',
        data: {'id_comentario':id_comentario,'opcion':objeto.innerHTML}
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
            get_info_comentario(id_comentario);
        }else{
            
        };
          
      });
        
        
        

        
    };
    
    function get_info_comentario(id_comentario){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>get_info_comentario',
        data: {'id_comentario':id_comentario}
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

            $('#info_comentario'+id_comentario).html(msg.trim());
          
      });
        
        
        

        
    };
    
    
    
    function opciones_favorito(objeto){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>opciones_favorito',
        data: {'id_topico':$(location).attr('href').split( '/' )[5].substr(5),'opcion':objeto.innerHTML}
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

        if (msg==1){
            if(objeto.innerHTML== 'Favorito'){
                objeto.innerHTML = '<i class="fa fa-fw fa-thumbs-o-up"></i>';
            }
                                else{
                objeto.innerHTML = 'Favorito';
            };
        }else{
            
        };
          
      });
        
        
        

        
    };
    
    
//</script>