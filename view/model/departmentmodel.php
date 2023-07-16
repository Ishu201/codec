<?php

class department {

  public function viewDept() {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM department WHERE stat='ok'";
      $result = $con->query($sql);
      return $result;
  }


  public function updateDept() {
      $con = $GLOBALS['con'];
      $deptID = $_POST['deptID'];
      $empID = $_POST['empID'];
      $deptName = $_POST['deptName'];
        $sql_getHOD = "SELECT * FROM department WHERE empID='$empID'";
        $result_getHOD = $con->query($sql_getHOD);
        $count = $result_getHOD->num_rows;

        if($count != 0){
          $msg = '1';
        } else{
          $sql = "UPDATE department SET empID = '$empID' WHERE deptID ='$deptID'";
          $result = $con->query($sql) or die($con->error);
          $msg = 'New HOD is Assigned to '.$deptName.'';
        }
      return $msg;
  }


  function addDept() {
      $deptName = $_POST['deptName'];
      $empID = $_POST['empID'];
      $con = $GLOBALS['con'];
        $sql_getHOD = "SELECT * FROM department WHERE empID='$empID'";
        $result_getHOD = $con->query($sql_getHOD);
        $count = $result_getHOD->num_rows;

        $sql_getdeptName = "SELECT * FROM department WHERE deptName='$deptName'";
        $result_getdeptName = $con->query($sql_getdeptName);
        $count_dept = $result_getdeptName->num_rows;

        if($count != 0){
          $msg = '1';
        }
        else if($count_dept != 0) {
          $msg = '2';
        }
        else{
          $sql = "INSERT INTO department (deptName,empID) VALUES('$deptName','$empID')";
          $result = $con->query($sql) or die($con->error);

          $last_id = $con->insert_id;

          $sql2 = "UPDATE employee SET deptID='$last_id', desigID='0' WHERE empID='$empID'";
          $result2 = $con->query($sql2) or die($con->error);

          $msg = '3';
        }
      return $msg;
  }


  public function viewDept_selected($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM department WHERE deptID='$id'";
    $result = $con->query($sql);
    return $result;
  }

}

 ?>
