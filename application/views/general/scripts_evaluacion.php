<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?= base_url('/bower_components/jquery/dist/jquery.min.js');?>"></script>
<script src="<?= base_url('/assets/js/Chart.bundle.js');?>"></script>
<script src="<?= base_url('/assets/js/utils.js');?>"></script>
<!-- <script src="base_url('/assets/js/loader.js');"></script> -->
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- Select2 -->
<script src="<?= base_url('/bower_components/select2/dist/js/select2.full.min.js');?>"></script>
<!-- InputMask -->
<script src="<?= base_url('/bower_components/inputmask/dist/rawgit.js');?>"></script>

<!-- date-range-picker -->
<script src="<?= base_url('/bower_components/moment/min/moment.min.js');?>"></script>
<script src="<?= base_url('/bower_components/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<!-- bootstrap datepicker -->
<script src="<?= base_url('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<!-- bootstrap color picker -->
<script src="<?= base_url('/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js');?>"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url('/plugins/timepicker/bootstrap-timepicker.min.js');?>"></script>
<!-- SlimScroll -->
<script src="<?= base_url('/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url('/plugins/iCheck/icheck.min.js');?>"></script>
<!-- FastClick -->
<script src="<?= base_url('/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- PACE -->
<script src="<?= base_url('/bower_components/PACE/pace.min.js');?>"></script>











<!-- DataTables -->
<script src="<?= base_url('/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?= base_url('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
<script src="<?= base_url('/bower_components/buttons/dataTables.buttons.min.js');?>"></script>
<script src="<?= base_url('/bower_components/buttons/buttons.print.min.js');?>"></script>


<!-- AdminLTE App -->
<script src="<?= base_url('/dist/js/adminlte.min.js');?>"></script>

<script src="<?= base_url('/assets/ckeditor/ckeditor.js');?>"></script>
<script src="<?= base_url('/assets/ckfinder/ckfinder.js');?>"></script>
<script type="text/javascript" > var numero=1; 
    $('[data-inputmask-decimal]').inputmask("decimal", { radixPoint: ",", autoGroup: true, groupSeparator: ".", groupSize: 3 });
    $('[data-inputmask-integer]').inputmask("decimal", { radixPoint: "", autoGroup: true, groupSeparator: ".", groupSize: 3 });
    $('[data-inputmask-phone]').inputmask("(9{1,4})9{1,3}-9{1,3}");
    $('[data-inputmask]').inputmask();
    
    $('[data-select]').select2({
    placeholder: "Selecciona"
    }).val(null).trigger('change');
    
    $('[datepicker]').datepicker({
      autoclose: true,
      language: 'es',
      orientation: 'bottom auto'
    });
    
    $('#salir').click( function () {
    
        $.ajax({
                data:  '',
                url:   'http://www.eduvirt.com/salir',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                   document.location.href = document.location.href;
                }
        });
    
    } );
    
    function post(path, params, method) {
        method = method || "post"; // Set method to post by default if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    };
    

    


var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};




if( isMobile.any() ) {
    $('body > div.wrapper > div.content-wrapper > section.content > div > div').attr("class","col-xs-12");
}else{
};


var id_contacto=0;
//mostrar_mensajes();

    $("#mensaje_enviar").click(function(){
        
        
        insert_mensajes();
        
        
    });




function mostrar_mensajes(contacto) {
    
    id_contacto=contacto;
    $.ajax({
        method: "POST",
        url: 'http://www.eduvirt.com/conversaciones/resultmensaje',
    //============================================================================================================================================
    // DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
    //============================================================================================================================================
        data: {"mensaje":"","tipo":"leer","contacto":id_contacto}
    //============================================================================================================================================
    // FIN                                                                                                                                       1
    //============================================================================================================================================
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

          $(".direct-chat-messages").replaceWith(msg);
          $(".direct-chat-messages").scrollTop($(".direct-chat-messages").prop('scrollHeight'));
      });
}


function mostrar_contactos() {
    $.ajax({
        method: "POST",
        url: 'http://www.eduvirt.com/conversaciones/resultcontactos',
    //============================================================================================================================================
    // DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
    //============================================================================================================================================
        data: {}
    //============================================================================================================================================
    // FIN                                                                                                                                       1
    //============================================================================================================================================
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

          $(".contacts-list").replaceWith(msg);
      });
}

function insert_mensajes() {
    $.ajax({
        method: "POST",
        url: 'http://www.eduvirt.com/conversaciones/resultmensaje',
    //============================================================================================================================================
    // DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
    //============================================================================================================================================
        data: {"mensaje":$('#id_mensaje').val(),"tipo":"insertar","contacto":id_contacto}
    //============================================================================================================================================
    // FIN                                                                                                                                       1
    //============================================================================================================================================
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

          $(".direct-chat-messages").replaceWith(msg);
          $(".direct-chat-messages").scrollTop($(".direct-chat-messages").prop('scrollHeight'));
          $('#id_mensaje').val("");
          $('#id_mensaje').focus();
      });
}

    function existe_nuevo_mensaje() {
    $.ajax({
        method: "POST",
        url: 'http://www.eduvirt.com/conversaciones/nuevomensaje',
    //============================================================================================================================================
    // DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
    //============================================================================================================================================
        data: {}
    //============================================================================================================================================
    // FIN                                                                                                                                       1
    //============================================================================================================================================
      })
        .done(function( msg ) {
          //alert( "Data Saved: " + msg );

          if (msg>0){
            $('#mennuevo').text(msg);
            if (id_contacto>0){
                mostrar_mensajes(id_contacto);  
            };
         }else{
            $('#mennuevo').text('0');
          };
          
      });
    }



</script>
<?php
try {
  echo '<script src="'.$segmento.'axtis"></script>';
}

//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
?>

<script>

mostrar_contactos();


</script>


<script>
		var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre'];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
			datasets: [{
				label: 'Participación %',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
					10,
					20,
					30,
					40,
					50,
					60,
					70
				]
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Progreso'
					}
				}
			});

		};



		document.getElementById('addData').addEventListener('click', function() {
			if (barChartData.datasets.length > 0) {
				var month = MONTHS[barChartData.labels.length % MONTHS.length];
				barChartData.labels.push(month);

				for (var index = 0; index < barChartData.datasets.length; ++index) {
					// window.myBar.addData(randomScalingFactor(), index);
					barChartData.datasets[index].data.push(40);
				}

				window.myBar.update();
			}
		});



		document.getElementById('removeData').addEventListener('click', function() {
			barChartData.labels.splice(-1, 1); // remove the label first

			barChartData.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myBar.update();
		});
                
                
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Curso 1',11],
          ['Curso 2',2],
          ['Curso 3',2],
          ['Curso 4',2],
          ['Curso 5',7]
        ]);

        var options = {
          title: 'Cursos de Cursos'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
                
	</script>

</body>
</html>

