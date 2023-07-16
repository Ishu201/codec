    <?php
    if (isset($_REQUEST['msg'])) {
      $msg = base64_decode($_REQUEST['msg']);
      $nomsg = $_REQUEST['msg'];

      if ($_REQUEST['code'] == 'error') {
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

            window.history.replaceState({}, document.title, "/" + "codec/view/attendance.php");
          });

        </script>

        <?php
      } else{
      //if the code is an error
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

        window.history.replaceState({}, document.title, "/" + "codec/view/attendance.php");
      });

    </script>

    <?php
  } }
    ?>
