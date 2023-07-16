<?php

class login {

    public function loginvalidate($email, $pass) {
        $con = $GLOBALS['con'];
        $sql = "SELECT * FROM users WHERE username='$email' AND password='$pass' ";
        $result = $con->query($sql);
        return $result;
    }

}

?>
