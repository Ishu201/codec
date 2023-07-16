
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$status = $_REQUEST['stat'];

if($status == 'add'){

  $project_name = $_POST['project_name'];
  $industry = $_POST['industry'];
  $project_type = $_POST['project_type'];
  $project_status = $_POST['project_status'];
  $empID = $_POST['empID'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $description = $_POST['description'];
  $customer_name = $_POST['customer_name'];
  $customer_company = $_POST['customer_company'];
  $customer_address = $_POST['customer_address'];
  $customer_contact = $_POST['customer_contact'];
  $customer_email = $_POST['customer_email'];

  $getID = $_POST['getID'];

    $sql2 = "INSERT INTO `projects`( `project_name`, `industry`, `project_type`, `project_status`, `startDate`, `endDate`, `empID`, `progress`, `description`, `status`, `customer_name`, `customer_company`, `customer_address`, `customer_contact`, `customer_email`)
    VALUES ('$project_name','$industry','$project_type','$project_status','$startDate','$endDate','$empID','0','$description','ongoing','$customer_name','$customer_company','$customer_address','$customer_contact','$customer_email')";
    $result2 = $con->query($sql2);


    $sql2 = "INSERT INTO project_members( `projectID`, `empID`, `projectName`, `fromdate`) VALUES ('$getID','$empID','$project_name','$startDate')";
    $result2 = $con->query($sql2);

    $nmsg = 'New Project is Started ..!';
    $msg = base64_encode($nmsg);
    header("Location:../projectList.php?msg=$msg&code=success");
}


if($status == 'updateInfo'){
  $projectID = $_REQUEST['projectID'];

  $progress = $_POST['progress'];
  $project_name = $_POST['project_name'];
  $industry = $_POST['industry'];
  $project_type = $_POST['project_type'];
  $project_status = $_POST['project_status'];
  $empID = $_POST['empID'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $description = $_POST['description'];
  $customer_name = $_POST['customer_name'];
  $customer_company = $_POST['customer_company'];
  $customer_address = $_POST['customer_address'];
  $customer_contact = $_POST['customer_contact'];
  $customer_email = $_POST['customer_email'];

  $webLink = $_POST['webLink'];
  $webun = $_POST['webun'];
  $webpwd = $_POST['webpwd'];
  $serverLink = $_POST['serverLink'];
  $serverun = $_POST['serverun'];
  $serverpwd = $_POST['serverpwd'];

  $prevleader = $_POST['prevleader'];

  $sql2 = "UPDATE `projects` SET `project_name`='$project_name', `industry`='$industry', `project_type`='$project_type', `project_status`='$project_status', `startDate`='$startDate',
  `endDate`='$endDate', `empID`='$empID', `progress`='$progress', `description`='$description', `webLink`='$webLink', `webun`='$webun', `webpwd`='$webpwd', `serverLink`='$serverLink', `serverun`='$serverun', `serverpwd`='$serverpwd',
    `customer_name`='$customer_name', `customer_company`='$customer_company', `customer_address`='$customer_address', `customer_contact`='$customer_contact', `customer_email`='$customer_email' WHERE projectID='$projectID'";
  $result2 = $con->query($sql2);

  $sql3 = "UPDATE project_members SET `projectName`='$project_name' WHERE projectID='$projectID'";
  $result3 = $con->query($sql3);

  if ($prevleader != $empID) {
    $date = date('Y-m-d');

    $sql2 = "INSERT INTO project_members( `projectID`, `empID`, `projectName`, `fromdate`) VALUES ('$projectID','$empID','$project_name','$date')";
    $result2 = $con->query($sql2);

  }

  $nmsg = 'Project Data is Updated';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");

}



if($status == 'completeproj'){
  $projectID = $_REQUEST['projectID'];

  $date = date('Y-m-d');

  $prevleader = $_POST['prevleader'];

  $sql2 = "UPDATE `projects` SET  `real_enddate`='$date', `progress`='$progress', `status`='Completed' WHERE projectID='$projectID'";
  $result2 = $con->query($sql2);

  $sql3 = "UPDATE project_members SET `stat`='off', `todate`='$date' WHERE projectID='$projectID' AND stat='on'";
  $result3 = $con->query($sql3);


  $nmsg = 'Project is Fully Developed';
  $msg = base64_encode($nmsg);
  header("Location:../projectList.php?msg=$msg");

}



if($status == 'addDeveloper'){
  $projectID = $_REQUEST['projectID'];

  $empID = $_POST['empID'];
  $projectName = $_POST['projectName'];
  $date = date('Y-m-d');

  $sql2 = "INSERT INTO project_members( `projectID`, `empID`, `projectName`, `fromdate`) VALUES ('$projectID','$empID','$projectName','$date')";
  $result2 = $con->query($sql2);

  $nmsg = 'New Developer is Assigned';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");

}


if($status == 'mainTaskt'){
  $projectID = $_REQUEST['projectID'];

  $main_task = $_POST['main_task'];

  $sql2 = "INSERT INTO `project_timeline`( `projectID`, `task`, `task_cat`) VALUES ('$projectID','$main_task','main')";
  $result2 = $con->query($sql2);

  $nmsg = 'New Main Task is Created';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
}


if($status == 'subTaskt'){
  $projectID = $_REQUEST['projectID'];
  $mainID = $_REQUEST['mainID'];

  $sub_task = $_POST['sub_task'];

  $sql2 = "INSERT INTO `project_timeline`( `projectID`, `task`, `task_cat`,`maincat_id`) VALUES ('$projectID','$sub_task','sub','$mainID')";
  $result2 = $con->query($sql2);

  $nmsg = 'New Sub Task is Created';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
}

if($status == 'save_mainTask'){
  $projectID = $_REQUEST['projectID'];
  $numb = $_REQUEST['numb'];

  $p_taskID = 'p_taskID'.$numb;
  $M_sdate = 'M_sdate'.$numb;
  $M_edate = 'M_edate'.$numb;

  $p_taskID = $_POST[$p_taskID];
  $M_sdate = $_POST[$M_sdate];
  $M_edate = $_POST[$M_edate];

  $sql2 = "UPDATE `project_timeline` SET startDate='$M_sdate', endDate='$M_edate' WHERE p_taskID='$p_taskID'";
  $result2 = $con->query($sql2);

  $nmsg = 'Task Timeline is Updated';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
}


if($status == 'save_subTask'){
  $projectID = $_REQUEST['projectID'];
  $numb = $_REQUEST['numb'];
  $mainID = $_REQUEST['mainID'];


  $p_taskID = $mainID.'ps_taskID'.$numb;
  $M_sdate = $mainID.'S_sdate'.$numb;
  $M_edate = $mainID.'S_edate'.$numb;

  $p_taskID = $_POST[$p_taskID];
  $M_sdate = $_POST[$M_sdate];
  $M_edate = $_POST[$M_edate];

  $sql2 = "UPDATE `project_timeline` SET startDate='$M_sdate', endDate='$M_edate' WHERE p_taskID='$p_taskID'";
  // echo $sql2;
  $result2 = $con->query($sql2);

  $nmsg = 'Task Timeline is Updated';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
}


if($status == 'save_subTask'){
  $projectID = $_REQUEST['projectID'];
  $numb = $_REQUEST['numb'];
  $mainID = $_REQUEST['mainID'];


  $p_taskID = $mainID.'ps_taskID'.$numb;
  $M_sdate = $mainID.'S_sdate'.$numb;
  $M_edate = $mainID.'S_edate'.$numb;

  $p_taskID = $_POST[$p_taskID];
  $M_sdate = $_POST[$M_sdate];
  $M_edate = $_POST[$M_edate];

  $sql2 = "UPDATE `project_timeline` SET startDate='$M_sdate', endDate='$M_edate' WHERE p_taskID='$p_taskID'";
  // echo $sql2;
  $result2 = $con->query($sql2);

  $nmsg = 'Task Timeline is Updated';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
}


if($status == 'remove_mainTask'){
  $projectID = $_REQUEST['projectID'];
  $id = $_REQUEST['id'];

  $sql2 = "DELETE FROM project_timeline WHERE p_taskID = '$id'";
  $result2 = $con->query($sql2);

  $sql3 = "DELETE FROM project_timeline WHERE maincat_id = '$id'";
  $result3 = $con->query($sql3);

  $nmsg = 'Project Task is Removed';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
}

if($status == 'remove_subTask'){
  $projectID = $_REQUEST['projectID'];
  $id = $_REQUEST['id'];

  $sql2 = "DELETE FROM project_timeline WHERE p_taskID = '$id'";
  $result2 = $con->query($sql2);

  $nmsg = 'Project Task is Removed';
  $msg = base64_encode($nmsg);
  header("Location:../editProject.php?projectID=$projectID&msg=$msg");
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
      header("Location:../editProject.php?projectID=$projectID&msg=$msg");
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
     header("Location:../editProject.php?projectID=$projectID&msg=$msg");

   } else{
     $sql = "INSERT INTO member_permissions(projectID,empID,documentID)
     VALUES('$projectID','$empID','$docID')";
     $con->query($sql) or die($con->error);

    $nmsg = 'Project Permission is Granted';
    $msg = base64_encode($nmsg);
    header("Location:../editProject.php?projectID=$projectID&msg=$msg");
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
      header("Location:../editProject.php?projectID=$projectID&msg=$msg");
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
      header("Location:../empeditProject.php?projectID=$projectID&msg=$msg");
    } else{
      header("Location:../editProject.php?projectID=$projectID&msg=$msg");
    }



  }

?>
