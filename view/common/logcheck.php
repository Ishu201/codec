
<?php
if($_SESSION['roleID'] == ''){
  $msg = base64_encode('Please Log in to the system..!');
  header("Location:../index.php?msg=$msg");
}
?>
