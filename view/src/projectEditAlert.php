    <?php
    if (isset($_REQUEST['msg'])) {
      $msg = base64_decode($_REQUEST['msg']);
    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        jQuery.noConflict();
        toastr.success('<?php echo $msg; ?>','Successfull.. !!!',{
            "positionClass": "toast-top-right",
            timeOut: 5000,
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "500",
            "extendedTimeOut": "500",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false
        })
      });
    </script>

    <?php
       }
    ?>
