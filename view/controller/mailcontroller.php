<?php

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

if(isset($_POST["draft"])) {

  date_default_timezone_set('Asia/Calcutta');

  $mail_sender = $_POST['mail_sender'];
  $mail_receiver = $_POST['mail_receiver'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $date = date('Y-m-d h:i a');

    $sql2 = "INSERT INTO `mail`(`date`, `mail_sender`, `mail_receiver`, `subject`, `message`, `process`, `stat`) VALUES
            ('$date','$mail_sender','$mail_receiver','$subject','$message','draft','On')";
    $result2 = $con->query($sql2);


    $nmsg = 'Mail Sent Successfully..!';
    $msg = base64_encode($nmsg);
    header("Location:../mail.php?msg=$msg");
}

if(isset($_POST["send"])) {

  date_default_timezone_set('Asia/Calcutta');

  $mail_sender = $_POST['mail_sender'];
  $mail_receiver = $_POST['mail_receiver'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $date = date('Y-m-d h:i a');

    $sql2 = "INSERT INTO `mail`(`date`, `mail_sender`, `mail_receiver`, `subject`, `message`, `process`, `stat`) VALUES
            ('$date','$mail_sender','$mail_receiver','$subject','$message','send','On')";
    $result2 = $con->query($sql2);


    $nmsg = 'Mail Sent Successfully..!';
    $msg = base64_encode($nmsg);
    header("Location:../mail.php?msg=$msg");
}

?>
