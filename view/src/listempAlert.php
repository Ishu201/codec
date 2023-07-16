    <?php
    if ((isset($_REQUEST['msg'])) or (isset($_REQUEST['code']))) {
      $msg = base64_decode($_REQUEST['msg']);
      $code = $_REQUEST['code'];
      //if the code is an error
      if ($code == 'error') {
    ?>
    <script type="text/javascript">
      $(document).ready(function() {
        toastr.error('<?php echo $msg; ?>','Try Again.. !!!',{
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
    } else if($_REQUEST['msg'] == "suspend"){
  ?>
    <script type="text/javascript">
    $(document).ready(function() {
      jQuery.noConflict();
        $('#suspendemployee').modal('show');
    });
    </script>

    <?php
  }  else if ($code == 'success'){
      ?>

    <script type="text/javascript">
      $(document).ready(function() {
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
      } }
    ?>
