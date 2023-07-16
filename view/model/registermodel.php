<?php

class register {

    public function registerUser($email,$password){
      $con = $GLOBALS['con'];
      $msg = '';
      // check if the usermail is in the database
      $sql = "SELECT * FROM employee WHERE empEmail='$email' ";
      $result = $con->query($sql);
      if ($result->num_rows == 0) {
        $msg = 'Your Email Addres is not Registered';
      } else{
        $row = $result->fetch_array();
        $emp = $row['empID'];
        $sql_checkuser = "SELECT * FROM users WHERE username='$email' ";
        $result_checkuser = $con->query($sql_checkuser);
        $row_checkuser = $result_checkuser->fetch_array();

        if ($result_checkuser->num_rows == 0) {
          $sql2 = "INSERT INTO  users(empID,username,password) VALUES ('$emp','$email','$password') ";
          $con->query($sql2);
          $msg = 'Wait Until Your Account is Activated';
        } else{
          $msg = 'You Already have an User Account';
        }

      }
      return $msg;
    }

}

?>
