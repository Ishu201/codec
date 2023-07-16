<?php

////To set default time zone
date_default_timezone_set("Asia/colombo");


//If feilds are empty
if ($_POST['username'] == "" || $_POST['password'] == "") {
  $msg = base64_encode("Incorrect Email address or Password");
    header("Location:../../register.php?msg=$msg");
    exit();
}


include '../common/dbconnection.php';
include '../model/registermodel.php';

//Get the db connection
$ob = new dbconnection();
$con = $ob->connection();

//Get the values
$email = trim($_POST['username']);
$pass = sha1(trim($_POST['password']));

//Get login details for given user
$obj = new register();
$reg = $obj->registerUser($email,$pass);
$msg = base64_encode($reg);

header("Location:../../register.php?msg='$msg'");

?>
