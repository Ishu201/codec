<?php

class designation {

  public function viewDesig() {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM designation WHERE stat='ok'";
      $result = $con->query($sql);
      return $result;
  }



  public function updateDesig() {
      $con = $GLOBALS['con'];
      $desigID = $_POST['desigID'];
      $salary = $_POST['salary'];
          $sql = "UPDATE designation SET basic_salary = '$salary' WHERE desigID ='$desigID'";
          $result = $con->query($sql) or die($con->error);
          $msg = 'Basic Salary is Updated to Rs. '.$salary.'';

          $sql2 = "SELECT * FROM employee WHERE desigID ='$desigID'";
          $result2 = $con->query($sql2) or die($con->error);

          while ($row = $result2->fetch_array()) {
            $id = $row['empID'];
            $sql3 = "UPDATE employee_salary SET basic_salary = '$salary' WHERE empID ='$id'";
            $result3 = $con->query($sql3) or die($con->error);
          }

          $msg = 'Basic Salary is Updated to Rs. '.$salary.'';

      return $msg;
  }


  function addDesig() {
      $designation = $_POST['designation'];
      $deptID = $_POST['deptID'];
      $salary = $_POST['salary'];
      $con = $GLOBALS['con'];
        $sql_getDesig = "SELECT * FROM designation WHERE designation='$designation' and deptID='$deptID'";
        $result_getDesig = $con->query($sql_getDesig);
        $count = $result_getDesig->num_rows;

        if($count != 0){
          $msg = '1';
        }
        else{
          $sql = "INSERT INTO designation (deptID,designation,basic_salary) VALUES('$deptID','$designation','$salary')";
          $result = $con->query($sql) or die($con->error);
          $msg = '2';
        }
      return $msg;
  }


  public function viewDesig_selected($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM designation WHERE desigID='$id'";
    $result = $con->query($sql);
    return $result;
  }

  public function viewDesig_dept($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM designation WHERE deptID='$id'";
    $result = $con->query($sql);
    return $result;
  }

}

 ?>
