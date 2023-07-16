<?php
$col = $_REQUEST['col'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

if ($col == 'add') {
  $title = $_REQUEST['title'];
  $start = $_REQUEST['start'];
  $end = $_REQUEST['end'];
  $classname = $_REQUEST['classname'];

  $sql_drop = "INSERT INTO company_events(start,title,className,end) VALUES('$start','$title','$classname','$end')";
  $result_drop = $con->query($sql_drop);
  	echo 'ok';
  	$con->close();
}


else if ($col == 'drop') {
  // $title = $_REQUEST['title'];
  $start = $_REQUEST['start'];
  // $end = $_REQUEST['end'];

  $sql_drop = "DELETE FROM company_events WHERE start='$start'";
  $result_drop = $con->query($sql_drop);
  	echo 'ok';
  	$con->close();
}

else if ($col == 'edit') {
  $title = $_REQUEST['title'];
  $start = $_REQUEST['start'];

  $sql_drop = "UPDATE company_events SET title='$title' WHERE start='$start'";
  $result_drop = $con->query($sql_drop);
  	echo 'ok';
  	$con->close();
}



?>
