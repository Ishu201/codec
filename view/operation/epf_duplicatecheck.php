<?php
$id = $_REQUEST['val'];
$col = $_REQUEST['col'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

if ($col == 'epf') {
  $sql_epf = "SELECT * FROM employee WHERE epfNo='$id'";
  $result_epf = $con->query($sql_epf);
  $count_epf = $result_epf->num_rows;

  if ($count_epf > 0) {
    echo "This EPF number is Already Registered";
  } else{
    echo "";
  }

  	// Close the connection after using it
  	$con->close();
}

else if ($col == 'nic') {
  $sql_epf = "SELECT * FROM employee WHERE empNIC='$id'";
  $result_epf = $con->query($sql_epf);
  $count_epf = $result_epf->num_rows;

  if ($count_epf > 0) {
    echo "This NIC Number is Already Registered";
  } else{
    echo "";
  }

  	// Close the connection after using it
  	$con->close();
}

else if ($col == 'con') {
  $sql_epf = "SELECT * FROM employee WHERE empContact='$id'";
  $result_epf = $con->query($sql_epf);
  $count_epf = $result_epf->num_rows;

  if ($count_epf > 0) {
    echo "This Contact number is Already Registered";
  } else{
    echo "";
  }

  	// Close the connection after using it
  	$con->close();
}

if ($col == 'email') {
  $sql_epf = "SELECT * FROM employee WHERE empEmail='$id'";
  $result_epf = $con->query($sql_epf);
  $count_epf = $result_epf->num_rows;

  if ($count_epf > 0) {
    echo "This Email Address is Already Registered";
  } else{
    echo "";
  }

  	// Close the connection after using it
  	$con->close();
}



?>
