<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
//<script type="text/javascript" >

var <?= $dato[0]['update_table'] ?>;
var dataSet = <?= $array_datos ?>;

$select1=$('#cursoscategoria').select2({
    placeholder: "Selecciona"
    });;

rellenarselect();

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
    
<?php if($dato[0]['opcciones_funcion']['opcion_grabar']=='S'){ ?>

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
<?php } ?>
    
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
                                $cadena_parametros.= "'".$clave."': $( \"#cursoscategoria\" ).val()==null ? 0:$( \"#cursoscategoria\" ).val(),";
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
<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
        "stateSave": true,
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
        "paging":   true,
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
            { "data": "curso1_out","visible": true,"searchable": true,"sTitle": "Curso 1","sWidth": "25px" },
            { "data": "curso2_out","visible": true,"searchable": true,"sTitle": "Curso 2","sWidth": "25px" },
            { "data": "curso3_out","visible": true,"searchable": true,"sTitle": "Curso 3","sWidth": "25px" },
            { "data": "curso4_out","visible": true,"searchable": true,"sTitle": "Curso 4","sWidth": "25px" },
            { "data": "curso1_out_info","visible": false,"searchable": true,"sTitle": "Curso 1 info","sWidth": "25px" },
            { "data": "curso2_out_info","visible": false,"searchable": true,"sTitle": "Curso 2 info","sWidth": "25px" },
            { "data": "curso3_out_info","visible": false,"searchable": true,"sTitle": "Curso 3 info","sWidth": "25px" },
            { "data": "curso4_out_info","visible": false,"searchable": true,"sTitle": "Curso 4 info","sWidth": "25px" }
            
        ],
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        "columnDefs": [
            {
                "targets": [ 0 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    
                        return row.curso1_out_info;

                  }
                
            },
            {
                "targets": [ 1 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    
                        return row.curso2_out_info;

                  }
                
            },
            {
                "targets": [ 2 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    
                        return row.curso3_out_info;

                  }
                
            },
            {
                "targets": [ 3 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    
                        return row.curso4_out_info;

                  }
                
            }
        ],
        "fnDrawCallback": function( oSettings ) {
            $(oSettings.nTHead).hide();
            $(oSettings.nTFoot).hide();
            
          },
         "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                $('th', nRow).attr('width','100%');
                $('td:eq(0)', nRow).attr('style','width:25%');
                $('td:eq(1)', nRow).attr('style','width:25%;');
                $('td:eq(2)', nRow).attr('style','width:25%;');
                $('td:eq(3)', nRow).attr('style','width:25%;');

                return nRow;
          }
    } );
                     
         
};

<?php if($dato[0]['opcciones_funcion']['opcion_borrar']=='S'){ ?>
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
<?php } ?>

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
    
<?php if($dato[0]['opcciones_funcion']['seleccionar_fila']=='S'){ ?>
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
<?php } ?>
 
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

function rellenarselect() {


                    

                          
                        $("#cursoscategoria option").remove();

                        $.each(dataSet, function (i, item) {
                            if (item.disabled=='false'){
                                $select1.append($('<option>', { 
                                    value: item.id,
                                    text : item.text,
                                    disabled: false
                                }));
                            }
                            else{
                                $select1.append($('<option>', { 
                                    value: item.id,
                                    text : item.text,
                                    disabled: true
                                }));
                            };
                            
                        
                        });

                        $select1.val(0).trigger('change');//.val(null) para que no seleccione nada

                           

    
};

$( "#cursoscategoria" )
    .change(function () {
      leer<?= $dato[0]['update_table'] ?>();
      
    })
    .change();
    
    function opciones_valoracion(objeto,curso){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>opciones_valoracion',
        data: {'id_curso':curso,'opcion':objeto.innerHTML}
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
        }else{
            
        };
          
      });
        
        
        

        
    };
    
    function opciones_inscripcion(objeto,curso){
    
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>opciones_inscripcion',
        data: {'id_curso':curso,'opcion':objeto.innerHTML}
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

        if (msg==1){
            if(objeto.innerHTML== 'Inscribirse'){
                objeto.innerHTML = 'Desinscribirse';
            }
            else{
                objeto.innerHTML = 'Inscribirse';
            };
        }else{
            alert('No puede Inscribirse al Curso, usted se encuentra fuera rango de fecha del curso');
        };
          
      });
    
    
    
    

        
    }; 
        
    function fn_validad_incripcion(curso){
    
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>existe_inscripcion',
        data: {'id_curso':curso}
      })
        .done(function( response ) {

                    if (response.trim()=='S'){
                        location.href ="http://www.eduvirt.com/cursos_x_clases/index/"+curso;
                    }
                    if (response.trim()=='N'){
                        alert('No puede ingresar al curso, por que no se ha inscripto');
                    }
          
      });
    
    
    //cursos_x_clases/index/
    

        
    };

//</script>