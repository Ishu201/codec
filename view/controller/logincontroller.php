<?php

//To start the session
if (!isset($_SESSION)) {
    session_start();
}

////To set default time zone
// date_default_timezone_set("Asia/colombo");
$msg = base64_encode("Incorrect Email address or Password");

//If feilds are empty
if ($_POST['username'] == "" || $_POST['password'] == "") {
    header("Location:../../index.php?msg=$msg");
    exit();
}


include '../common/dbconnection.php';
include '../model/loginmodel.php';

//Get the db connection
$ob = new dbconnection();
$con = $ob->connection();

//Get the values
$email = trim($_POST['username']);
$pass = trim($_POST['password']);

//Get login details for given user
$obj = new login();
$result = $obj->loginvalidate($email, $pass);
$row = $result->fetch_array();
$userName = $row['username'];
$password = $row['password'];
$approval = $row['permission'];

  if (($email == "admin") && ($pass == "123")) {
    $_SESSION['username'] = 'Admin';
    $_SESSION['roleID'] = 2;
    $_SESSION['empID'] = 1;
    header("Location:../adminDashboard.php");
  }


  else if (($email == "Accounts@CDC") && ($pass == "06dd8e17e622ce2a78e6bec805a7f64f6492ab56")) {
    $_SESSION['username'] = 'Accounts';
    $_SESSION['roleID'] = 2;
    $_SESSION['empID'] = 2;
    header("Location:../accDashboard.php");
  }


  else if (($email == "HumanR@CDC") && ($pass == "06dd8e17e622ce2a78e6bec805a7f64f6492ab56")) {
    $_SESSION['username'] = 'HR';
    $_SESSION['roleID'] = 2;
    $_SESSION['empID'] = 3;
    header("Location:../hrDashboard.php");
  }

  else if (($email == "DevOp@CDC") && ($pass == "06dd8e17e622ce2a78e6bec805a7f64f6492ab56")) {
    $_SESSION['username'] = 'Development';
    $_SESSION['roleID'] = 2;
    $_SESSION['empID'] = 4;
    header("Location:../devopDashboard.php");
  }

  else {
       if (($result->num_rows == 1) && ($approval == 'Approved')) {
         $sql_usertype = "SELECT * FROM employee WHERE empEmail='$userName' ";
         $result_usertype = $con->query($sql_usertype);
         $row_usertype = $result_usertype->fetch_array();
         $userType = $row_usertype['userType'];
         $empID = $row_usertype['empID'];

           // if ($userType == 'Tech Lead') {
             $_SESSION['roleID'] = 1;
             $_SESSION['username'] = $userName;
             $_SESSION['empID'] = $empID;
             header("Location:../empDashboard.php");
           // }
           // else if ($userType == 'Team') {
           //   $_SESSION['roleID'] = 2;
           //   $_SESSION['username'] = $userName;
           //   $_SESSION['empID'] = $empID;
           //     header("Location:../empDashboard.php");
           // }
           // else if ($userType == 'Employee') {
           //   $_SESSION['roleID'] = 3;
           //   $_SESSION['username'] = $userName;
           //   $_SESSION['empID'] = $empID;
           //   header("Location:../empDashboard.php");
           // }
       }

       else if (($result->num_rows == 1) && ($approval == 'Not')) {
         $msg = base64_encode('Your Account is not still Approved..!');
         header("Location:../../index.php?msg=$msg");
       }

       else {
           header("Location:../../index.php?msg=$msg");
       }
     }

?>
