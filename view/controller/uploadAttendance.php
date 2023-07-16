
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
//

if(isset($_POST["submit"]))
{
  $date = $_POST['upload_date'];

  $sql = "SELECT * FROM attendance_exported_table WHERE date='$date'";
  $result = $con->query($sql);
  $rowcount= mysqli_num_rows($result);

  if ($rowcount > 0) {
    $nmsg = $date.' Attendance Data are Already Uploaded';
    $msg = base64_encode($nmsg);
    header("Location:../addAttendance.php?msg=$msg&code=error");
  } else{

  if($_FILES['attFile']['name'])
  {
    $filename = explode(".", $_FILES['attFile']['name']);
    if($filename[1] == 'csv'){
      $handle = fopen($_FILES['attFile']['tmp_name'], "r");
      $first = 1;
      while($data = fgetcsv($handle)){
        $item1 = $data[0];
        $item2 = $data[1];
        $item3 = $data[2];
        $item4 = $data[3];
        $item5 = $data[4];
        $item6 = $data[5];
        $item7 = $data[6];
        //insert data from CSV file
        if($first != 1){
        $query = "INSERT into attendance_exported_table(`date`, `machineID`, `DayIn`, `DayOut`, `workingHrs`, `OThrs`, `late`, `status`)
        values('$date','$item1','$item2','$item3','$item4','$item5','$item6','$item7')";
        $con->query($query);
      }
      $first++;
      }
      fclose($handle);
      $msg = base64_encode('Attendance data Successfully Updated');
      header("Location:../attendance.php?msg=$msg&code=success");
    } else{
      $msg = base64_encode('Please Upload the .csv file');
      header("Location:../addAttendance.php?msg=$msg&code=error");
    }
  }

  }
}

?>
