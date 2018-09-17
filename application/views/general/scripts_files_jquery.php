<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?= base_url('/bower_components/jquery/dist/jquery.min.js');?>"></script>
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

<!-- AdminLTE App -->
<script src="<?= base_url('/dist/js/adminlte.min.js');?>"></script>

<script src="<?= base_url('/assets/ckeditor/ckeditor.js');?>"></script>
<script src="<?= base_url('/assets/ckfinder/ckfinder.js');?>"></script>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?"data-gallery":""%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields="{"withCredentials":true}"{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>






<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="http://www.eduvirt.com/assets/jfu/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="http://www.eduvirt.com/assets/jfu/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="http://www.eduvirt.com/assets/jfu/js/main.js"></script>






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

</body>
</html>

