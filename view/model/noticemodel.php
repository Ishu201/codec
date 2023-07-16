<?php

class notice {

    public function viewNotice($role) {
        $con = $GLOBALS['con'];
        if ($role == 1) {
          $sql = "SELECT * FROM notice ORDER BY date DESC";
          $result = $con->query($sql);
          return $result;
        } else{
          $sql = "SELECT * FROM notice WHERE type='allcompany' OR type='all' OR type='$role' ORDER BY date DESC";
          $result = $con->query($sql);
          return $result;
        }

    }


    function addNotice() {
        $con = $GLOBALS['con'];
        $notice_text = $_POST['notice_text'];
        $sender = $_POST['empID'];
        date_default_timezone_set('Asia/Calcutta');
        $date = date('Y-m-d h:i:sa');
        $type = $_POST['type'];

        if ($sender == 1) {
          $sql = "INSERT INTO notice (date,type,sender,notice_text,Admin) VALUES('$date','$type','$sender','$notice_text','off')";
        } else if ($sender == 2) {
          $sql = "INSERT INTO notice (date,type,sender,notice_text,ACC) VALUES('$date','$type','$sender','$notice_text','off')";
        } else if ($sender == 3) {
          $sql = "INSERT INTO notice (date,type,sender,notice_text,HR) VALUES('$date','$type','$sender','$notice_text','off')";
        } else if ($sender == 4) {
          $sql = "INSERT INTO notice (date,type,sender,notice_text,IT) VALUES('$date','$type','$sender','$notice_text','off')";
        }

        $result = $con->query($sql) or die($con->error);
        $msg = 'New Notice is Published';
        return $msg;
    }



}
