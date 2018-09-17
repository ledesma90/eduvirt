<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>







<!-- jQuery 3 -->
<script src="<?= base_url('/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('/bower_components/jquery-ui/jquery-ui.min.js');?>"></script>
<!-- Slimscroll -->
<script src="<?= base_url('/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<!-- FastClick -->
<script src="<?= base_url('/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('/dist/js/demo.js');?>"></script>
<!-- fullCalendar -->
<script src="<?= base_url('/bower_components/moment/moment.js');?>"></script>
<script src="<?= base_url('/bower_components/fullcalendar/dist/fullcalendar.min.js');?>"></script>
<script src='<?= base_url('/bower_components/fullcalendar/dist/locale/es.js');?>'></script>
<!-- Page specific script -->





<!-- DataTables -->
<script src="<?= base_url('/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?= base_url('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>

<!-- AdminLTE App -->
<script src="<?= base_url('/dist/js/adminlte.min.js');?>"></script>

<script src="<?= base_url('/assets/ckeditor/ckeditor.js');?>"></script>
<script src="<?= base_url('/assets/ckfinder/ckfinder.js');?>"></script>
<script type="text/javascript" > var numero=1; 

    


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




  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week : 'Semana',
        day  : 'Día'
      },
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      },
        events: function(start, end, timezone, callback) {
        $.ajax({
          method: "POST",
          url: '<?= $segmento ?>getcalendario',
          dataType: 'json',
          data: {
            // our hypothetical feed requires UNIX timestamps
            start: start.unix(),
            end: end.unix()
          },
          success: function(doc) {
              
            callback(Object.keys(doc).map(function(k) { return doc[k] }));
          }
        });
      },
        eventDragStop: function(event,jsEvent) {

            var trashEl = $('#calendarTrash');
            var ofs = trashEl.offset();

            var x1 = ofs.left;
            var x2 = ofs.left + trashEl.outerWidth(true);
            var y1 = ofs.top;
            var y2 = ofs.top + trashEl.outerHeight(true);

            if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
                jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                
                var con = confirm('Esta seguro de quere borrarlo?');
                if(con == true) {
                    
                    $.ajax({
                        method: "POST",
                        url: '<?= $segmento ?>deletecalendario',
                        dataType: 'json',
                        data: {'id_recordatorio':event.id
                        },
                        success: function(doc) {
                          $('#calendar').fullCalendar('removeEvents', event.id);
                        }
                    }); 
                }
            }
        }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
  
  $( "#grabar" ).click(function() {
  
  
  $.each( $('#calendar').fullCalendar('clientEvents'), function( key, value ) {

    
    
    if(value.id == null){
          l_titulo=value.title;
          l_fecha_ini=value.start.format();
          l_color_fondo=value.backgroundColor;
          l_color_borde=value.borderColor;

          try {
           l_fecha_fin=value.end.format();
          }
          catch(err) {
           l_fecha_fin='vacio';
          };
          
          $.ajax({
          method: "POST",
          url: '<?= $segmento ?>grabarcalendario',
          dataType: 'json',
          data: {
            title: l_titulo,
            start: l_fecha_ini,
            end: l_fecha_fin,
            backgroundColor: l_color_fondo,
            borderColor: l_color_borde
          },
          success: function(doc) {
              
            callback(Object.keys(doc).map(function(k) { return doc[k] }));
          }
        });
          
          
          
          
          
          
    };

  
});
  location.reload();
  
});







</script>


</body>
</html>

