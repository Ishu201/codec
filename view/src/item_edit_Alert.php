    <?php
    if ((isset($_REQUEST['msg']))) {
      $msg = base64_decode($_REQUEST['msg']);
      $nomsg = $_REQUEST['msg'];
      // $code = $_REQUEST['code'];
      // if the code is an error
      if ($nomsg =='editItemData'){
         ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#editItem_data').modal('show');
      });
    </script>

  <?php } else if ($nomsg =='repairon'){ ?>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#repairOn').modal('show');
      });
    </script>

  <?php } else if ($nomsg =='repairoff'){ ?>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#repairOff').modal('show');
      });
    </script>

  <?php }else{ ?>
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
