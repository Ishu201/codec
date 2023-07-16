    <?php
    if (isset($_REQUEST['msg'])) {
      $msg = $_REQUEST['msg'];
      //if the code is an error
      if ($msg == 'Rejected') {
    ?>
    <script type="text/javascript">
      $(document).ready(function() {
        alert('Rejected')
      });
    </script>

    <?php
  } else {
    ?>

    <script type="text/javascript">
      $(document).ready(function() {
        alert('Approved')
      });
    </script>

    <?php
      } }
    ?>
