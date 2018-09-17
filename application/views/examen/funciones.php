<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" >

  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

  });


  $(document).ready(function() {
      
      
      
    $( "#ingreso" ).click(function() {
        //alert($( "#usuario" ).val());
        //alert($( "#password" ).val());
        
        
        var parametros_lectura = {
        tipo        :'ver',
        parametros  :{1:$( "#usuario" ).val(),
                      2:$( "#password" ).val()
                    }};
         
        $.ajax({
                data:  parametros_lectura,
                url:   '<?= $segmento ?>result',
                type:  'post',
                dataType: "json",
                beforeSend: function () {

                },
                success:  function (response) {
                    if (response['login']=='S'){
                        window.location.replace("<?= $base_url ?>insignias");
                    }
                    else{
                        $( "#usuario" ).val('')
                        $( "#password" ).val('');
                        $('.ajax-content').html('<h3 >Datos incorrectos...</h3>');
                    }

                                
                }
        });
        
        
        
    });
    
    
    
  } );

</script>
                    