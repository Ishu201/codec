    <?php
    if ((isset($_REQUEST['msh'])) or (isset($_REQUEST['stat']))) {
      $msg = base64_decode($_REQUEST['msh']);
      $stat = $_REQUEST['stat'];
      //if the code is an error
      if ($stat == 'error') {
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

    setTimeout(function(){
      var newURL = location.href.split("?")[0];
      window.history.pushState('object', document.title, newURL);
    }, 2000)

    </script>

    <?php
  } else{
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

      setTimeout(function(){
        var newURL = location.href.split("?")[0];
        window.history.pushState('object', document.title, newURL);
      }, 2000)

    </script>

    <?php
      } }
    ?>
