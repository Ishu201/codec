
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$status = $_REQUEST['stat'];



if($status == 'updateInfo'){
  $projectID = $_REQUEST['projectID'];

  $project_name = $_POST['project_name'];
  $industry = $_POST['industry'];
  $project_type = $_POST['project_type'];
  $project_status = $_POST['project_status'];
  $empID = $_POST['empID'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $description = $_POST['description'];

  $webLink = $_POST['webLink'];
  $webun = $_POST['webun'];
  $webpwd = $_POST['webpwd'];
  $serverLink = $_POST['serverLink'];
  $serverun = $_POST['serverun'];
  $serverpwd = $_POST['serverpwd'];

  $prevleader = $_POST['prevleader'];

  $sql2 = "UPDATE `projects` SET `project_name`='$project_name', `industry`='$industry', `project_type`='$project_type', `project_status`='$project_status', `startDate`='$startDate',
  `endDate`='$endDate', `empID`='$empID',  `description`='$description' , `webLink`='$webLink', `webun`='$webun', `webpwd`='$webpwd', `serverLink`='$serverLink', `serverun`='$serverun', `serverpwd`='$serverpwd' WHERE projectID='$projectID'";
  $result2 = $con->query($sql2);

  $sql3 = "UPDATE project_members SET `projectName`='$project_name' WHERE projectID='$projectID'";
  $result3 = $con->query($sql3);

  if ($prevleader != $empID) {
    $date = date('Y-m-d');

    $sql2 = "INSERT INTO project_members( `projectID`, `empID`, `projectName`, `fromdate`,`memberType`) VALUES ('$projectID','$empID','$project_name','$date','Maintenance Developing')";
    $result2 = $con->query($sql2);

  }

  $nmsg = 'Project Data is Updated';
  $msg = base64_encode($nmsg);
  header("Location:../editCProject.php?projectID=$projectID&msg=$msg");

}




if($status == 'addDeveloper'){
  $projectID = $_REQUEST['projectID'];

  $empID = $_POST['empID'];
  $projectName = $_POST['projectName'];
  $date = date('Y-m-d');

  $sql2 = "INSERT INTO project_members( `projectID`, `empID`, `projectName`, `fromdate` ,`memberType`) VALUES ('$projectID','$empID','$projectName','$date','Maintenance Developing')";
  $result2 = $con->query($sql2);

  $nmsg = 'New Developer is Assigned';
  $msg = base64_encode($nmsg);
  header("Location:../editCProject.php?projectID=$projectID&msg=$msg");

}


  if($status == 'addDoc'){
    $projectID = $_REQUEST['projectID'];

    $Doctitle = $_POST['Doctitle'];

    // File upload path
    $targetDir = "../../res/projectsDoc/";
    $fileName = basename($_FILES["myfile"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg','docx','xlsx','pdf');

      if(in_array($fileType, $allowTypes)){
       move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetFilePath);

       $sql = "INSERT INTO project_documents(projectID,title,doc,type)
       VALUES('$projectID','$Doctitle','$fileName','$fileType')";
       $con->query($sql) or die($con->error);

      $nmsg = 'Project Document is Added';
      $msg = base64_encode($nmsg);
      header("Location:../editCProject.php?projectID=$projectID&msg=$msg");
    }
  }


  if($status == 'priviliges'){
    $projectID = $_REQUEST['projectID'];

    $empID = $_REQUEST['empID'];
    $docID = $_REQUEST['docID'];
    $priviligeStat = $_POST['priviligeStat'];

    if ($priviligeStat == 'yes') {
      $sql = "DELETE FROM member_permissions WHERE projectID='$projectID' AND empID='$empID' AND documentID='$docID'";
      $con->query($sql) or die($con->error);

     $nmsg = 'Project Permission is Denied';
     $msg = base64_encode($nmsg);
     header("Location:../editCProject.php?projectID=$projectID&msg=$msg");

   } else{
     $sql = "INSERT INTO member_permissions(projectID,empID,documentID)
     VALUES('$projectID','$empID','$docID')";
     $con->query($sql) or die($con->error);

    $nmsg = 'Project Permission is Granted';
    $msg = base64_encode($nmsg);
    header("Location:../editCProject.php?projectID=$projectID&msg=$msg");
   }

  }


  if($status == 'addLDoc'){
    $projectID = $_REQUEST['projectID'];

    $Doctitle = $_POST['Ltitle'];

    $date = date('Y-m-d');

    // File upload path
    $targetDir = "../../res/projectLDoc/";
    $fileName = basename($_FILES["myfile2"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg','docx','xlsx','pdf');

      if(in_array($fileType, $allowTypes)){
       move_uploaded_file($_FILES["myfile2"]["tmp_name"], $targetFilePath);

       $sql = "INSERT INTO project_legal_documents(projectID,title,doc,type,date)
       VALUES('$projectID','$Doctitle','$fileName','$fileType','$date')";
       $con->query($sql) or die($con->error);

      $nmsg = 'Project Legal Document is Added';
      $msg = base64_encode($nmsg);
      header("Location:../editCProject.php?projectID=$projectID&msg=$msg");
    }
  }


  if($status == 'addnote'){
    $projectID = $_REQUEST['projectID'];

    $empname = $_REQUEST['empname'];
    $note = $_REQUEST['note'];
    $date = date('Y-m-d');


     $sql = "INSERT INTO `project_notes`( `projectID`, `employee`, `note`, `date`)
     VALUES ('$projectID','$empname','$note','$date')";
     $con->query($sql) or die($con->error);

    $nmsg = 'Project Note is Created';
    $msg = base64_encode($nmsg);
    if (isset($_REQUEST['user'])) {
      header("Location:../empeditCProject.php?projectID=$projectID&msg=$msg");
    } else{
      header("Location:../editCProject.php?projectID=$projectID&msg=$msg");
    }


  }

  if($status == 'addMtask'){
    $projectID = $_REQUEST['projectID'];

    $empID = $_REQUEST['developerID'];
    $Mtask = $_REQUEST['Mtask'];
    $type = $_REQUEST['type'];
    $dueDate = $_REQUEST['dueDate'];
    $priority = $_REQUEST['priority'];
    $date = date('Y-m-d');


     $sql = "INSERT INTO `project_maintenance`(  `projectID`, `empID`, `type`, `Mtask`, `priority`, `date`, `dueDate`)
     VALUES ('$projectID','$empID','$type','$Mtask','$priority' ,'$date','$dueDate')";
     $con->query($sql) or die($con->error);

    $nmsg = 'New Project Task is Created';
    $msg = base64_encode($nmsg);
    header("Location:../editCProject.php?projectID=$projectID&msg=$msg");


  }

?>
