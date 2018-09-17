<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
//<script type="text/javascript" >

var <?= $dato[0]['update_table'] ?>;
var <?= $dato[0]['update_table'] ?>id_curso=$(location).attr('href').split( '/' )[5];



<?php if($dato[0]['action']['visible']=='S'){ ?>
    $( "#grabar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
        if (verificacion_formulario_<?= $dato[0]['update_table'] ?>() == -1) {
        }else{
            grabar_dato_<?= $dato[0]['update_table'] ?>();
            $('#myModal_<?= $dato[0]['update_table'] ?>').modal('hide');
        }
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
      if (msg.trim()!=''){
          alert( msg.trim() );
      }
        
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

            var idcurso=$(location).attr('href').split( '/' )[5];
                var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{<?= ( $cadena_parametros==""? "'':''" : $cadena_parametros) ?>
                    , ':id_curso':idcurso
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
            { "data": "id_clase","visible": true,"searchable": true,"sTitle": "Id","sWidth": "70%" },
            { "data": "id_curso","visible": false,"searchable": true,"sTitle": "Curso"/*,"sWidth": "30%"*/ },
            { "data": "grupo","visible": false,"searchable": true,"sTitle": "Grupo","sWidth": "10%" },
            { "data": "numero_clase","visible": false,"searchable": true,"sTitle": "Numero de la clase"/*,"sWidth": "30%"*/ },
            { "data": "nombre_clase","visible": false,"searchable": true,"sTitle": "Nombre de la clase"/*,"sWidth": "30%"*/ },
            { "data": "contenido","visible": false,"searchable": true,"sTitle": "Descripcion"/*,"sWidth": "30%"*/ },
            { "data": "minutos","visible": true,"searchable": true,"sTitle": "Tiempo","sWidth": "10%" },
            { "data": "estado","visible": false,"searchable": true,"sTitle": "Estado","sWidth": "10%" },
            { "data": "id_curso","visible": false,"searchable": false,"sTitle": "Estado","sWidth": "10%" },
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
                    
                        return '<h5><a href="<?= $segmento_acortado ?>lecciones/index/'+row.id_clase+'" style="text-decoration:none">'+row.numero_clase+'-'+row.nombre_clase+'</a></h5>\n\
                                <h6 class="text-muted">'+row.contenido+'</h6>';

                  }
                
            },
            {
                "targets": [ 6 ], 
                "render" : function( data, type, row, meta ) {
                    if (data==null){
                        data='';
                    }
                    
                        return data+' min';

                  }
                
            }
        ],
        "order": [[2,'asc'],[3,'asc']],
        "fnDrawCallback": function( oSettings ) {
            $(oSettings.nTHead).hide();
            $(oSettings.nTFoot).hide();
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
            var totale = new Array();
            totale['Totale']= new Array();
            var groupid = -1;
            var subtotale = new Array();
 
            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                
                if ( last !== group ) {
                    groupid++;
                    $(rows).eq( i ).before(
                        '<tr class="group" style="background-color: #eaecee !important;">\n\
    <td colspan="1"><span style="padding-left: 5px;">'+group.substring(4)+'</span></td>\n\
</tr>'
                    );
 
                    last = group;
                }
                
                val = api.row(api.row($(rows).eq( i )).index()).data();      //current order index
                $.each(val,function(index2,val2){
                    
                        if (typeof subtotale[groupid] =='undefined'){
                            subtotale[groupid] = new Array();
                        }
                        if (typeof subtotale[groupid][index2] =='undefined'){
                            subtotale[groupid][index2] = 0;
                        }
                        if (typeof totale['Totale'][index2] =='undefined'){ totale['Totale'][index2] = 0; }
                        
                        valore = Number(val2.replace('min',"").replace('.',"").replace(',',"."));
                        subtotale[groupid][index2] += valore;
                        totale['Totale'][index2] += valore;
                        
                });
                
            } );
            
            $('tbody').find('.group').each(function (i,v) {
                    var rowCount = $(this).nextUntil('.group').length;
        		$(this).find('td:first').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': ' ('+rowCount+')' })));
                         var subtd = ''; 
                         
                        var hours = Math.floor( subtotale[i]['minutos'] / 60 );  
                        var minutes = Math.floor( (subtotale[i]['minutos'] % 60) );

                        //Anteponiendo un 0 a los minutos si son menos de 10 
                        minutes = minutes < 10 ? '0' + minutes : minutes;


                        var result = hours + ":" + minutes;
                        
                        var hours_total = Math.floor( totale['Totale']['minutos'] / 60 );  
                        var minutes_total = Math.floor( (totale['Totale']['minutos'] % 60) );

                        //Anteponiendo un 0 a los minutos si son menos de 10 
                        minutes_total = minutes_total < 10 ? '0' + minutes_total : minutes_total;


                        var result_total = hours_total + ":" + minutes_total;
                         
                         
                         
                            subtd += '<td>'+result+' horas de '+result_total+ ' ('+ Math.round(subtotale[i]['minutos']*100/totale['Totale']['minutos'],2) +'%) '+'</td>';
                        $(this).append(subtd);
            });
            
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
            echo "if (".$dato[0]['update_table'].".row('.selected').data().id_usuario==".$id_usuario."){ $( '#borrar".$dato[0]['update_table']."' ).show(); $( '#modificar".$dato[0]['update_table']."' ).show(); $( '#insertar".$dato[0]['update_table']."' ).show();}";
            echo "if (".$dato[0]['update_table'].".row('.selected').data().id_usuario!=".$id_usuario."){ $( '#borrar".$dato[0]['update_table']."' ).hide(); $( '#modificar".$dato[0]['update_table']."' ).hide(); $( '#insertar".$dato[0]['update_table']."' ).hide();}";
            ?>
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
          $.ajax({
            method: "POST",
            url: '<?= $segmento ?>verificar_duenho',
        //============================================================================================================================================
        // DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
        //============================================================================================================================================
            data: {'id_curso':<?= $dato[0]['update_table'] ?>id_curso}
        //============================================================================================================================================
        // FIN                                                                                                                                       1
        //============================================================================================================================================
          })
            .done(function( msg ) {
                if (msg.trim()=='S'){
                    <?php
                    echo "$( '#opcion".$dato[0]['update_table']."' ).show();";
                    ?>
                }
                <?php
                echo "$( '#opcioncurso_x_comentarios' ).show();";
                ?>
          });
    
} );


    function opciones_favorito(objeto){
        
        $.ajax({
        method: "POST",
        url: '<?= $segmento ?>opciones_favorito',
        data: {'id_curso':$(location).attr('href').split( '/' )[5],'opcion':objeto.innerHTML}
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


    function verificacion_formulario_<?= $dato[0]['update_table'] ?>() {
        <?php  
                $parametros='var resultado=0;';
                foreach ($dato[1] as $value1) {
                    
                    
                    if (in_array($value1, $dato[0]['columnas_actualizables'])) {
                        //$parametros .= " if (1=="."$( \"#".$dato[0]['update_table']."$value1\" ).".($dato[0]['elementos_form'][$value1]['grabar_formato']=='N'? "inputmask('unmaskedvalue')":'val()')."){ alert('chichis')}";
                        if (array_key_exists($value1, $dato[0]['elementos_form'])) {
                            if (array_key_exists('required', $dato[0]['elementos_form'][$value1])) {
                                $parametros .= "resultado= null==".($dato[0]['elementos_form'][$value1]['tipo']=='textarea'?  "CKEDITOR".".instances.".$dato[0]['update_table'].$value1.".getData()"    :($dato[0]['elementos_form'][$value1]['grabar_formato']=='N'? " $( \"#".$dato[0]['update_table']."$value1\" )."."inputmask('unmaskedvalue')":" $( \"#".$dato[0]['update_table']."$value1\" ).".'val()'))." || ''==".($dato[0]['elementos_form'][$value1]['tipo']=='textarea'?  "CKEDITOR".".instances.".$dato[0]['update_table'].$value1.".getData()"    :($dato[0]['elementos_form'][$value1]['grabar_formato']=='N'? " $( \"#".$dato[0]['update_table']."$value1\" )."."inputmask('unmaskedvalue')":" $( \"#".$dato[0]['update_table']."$value1\" ).".'val()'))."? -1 : 0 ;";        
                                $parametros .= "if(resultado === -1) { $('#requerido_".$dato[0]['update_table'].$value1."').show(); return -1 ; } else { $('#requerido_".$dato[0]['update_table'].$value1."').hide(); }";
                            }
                        }
                    }
                    
                }
                $parametros .= "return 0;";
                echo $parametros;
                ?>
    }
//</script>