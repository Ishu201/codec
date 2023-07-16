<?php

class employee {

// view all employees
  public function viewEmp() {
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM employee ORDER BY empID DESC";
      $result = $con->query($sql);
      return $result;
  }

// view data of a selected employee
  public function viewEmp_selected($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM employee WHERE empID='$id'";
    $result = $con->query($sql);
    return $result;
  }

// view desciplinary records of a selected employee
  public function viewDesc_selected($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM disciplinary WHERE status='On' AND empID='$id'";
    $result = $con->query($sql);
    return $result;
  }


// basic view list functions
  function addEmp() {
     $con = $GLOBALS['con'];
    $deptID = $_POST['deptID'];
    $desigID = $_POST['desigID'];
    $empName = $_POST['empName'];
    $empContact = $_POST['empContact'];
    $empEmail = $_POST['empEmail'];
    $empAddress = $_POST['empAddress'];
    $empNIC = $_POST['empNIC'];
    $empGender = $_POST['empGender'];
    $dateOfJoin = $_POST['empJoin'];
    $epfState = $_POST['epfState'];
    $machineID = $_POST['machineID'];
    $empType = $_POST['empType'];
    $shiftStart = $_POST['shiftStart'];
    $shiftEnd = $_POST['shiftEnd'];
    $epfNo = 'No';

      if ($epfState == 'yes') {
        $epfNo = $_POST['empEpf'];
      }

    if (!empty($_FILES["image"]["name"])) {
        // Get file info
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg','webp');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
        }
    }

        $sql_contact = "SELECT * FROM employee WHERE empContact='$empContact'";
        $result_contact = $con->query($sql_contact);
        $count_contact = $result_contact->num_rows;

        $sql_email = "SELECT * FROM employee WHERE empEmail='$empEmail'";
        $result_email = $con->query($sql_email);
        $count_email = $result_email->num_rows;

        $sql_nic = "SELECT * FROM employee WHERE empNIC='$empNIC' ";
        $result_nic = $con->query($sql_nic);
        $count_nic = $result_nic->num_rows;

        $count_epf = 0;
        if ($epfNo != 'No') {
          $sql_epf = "SELECT * FROM employee WHERE epfNo='$epfNo'";
          $result_epf = $con->query($sql_epf);
          $count_epf = $result_epf->num_rows;
        }

        if($count_contact != 0){
          $msg = '1';
        } elseif($count_email != 0){
          $msg = '2';
        } elseif($count_nic != 0){
          $msg = '3';
        } elseif($count_epf != 0){
          $msg = '4';
        }
        else{
          $sql = "INSERT INTO employee (deptID,desigID,epfNo,epfState,machineID,empType,image,empName,empContact,empEmail,empAddress,empNIC,empGender,dateOfJoin,shiftStart,shiftEnd)
          VALUES('$deptID','$desigID','$epfNo','$epfState','$machineID','$empType','$imgContent','$empName','$empContact','$empEmail','$empAddress','$empNIC','$empGender','$dateOfJoin','$shiftStart','$shiftEnd')";
          $result = $con->query($sql) or die($con->error);
          $msg = $empName;
        }
      return $msg;
  }

  function suspend_emp(){
    $con = $GLOBALS['con'];
    $empID = $_POST['empID'];
   $type = $_POST['w_no'];
   $stat = $_POST['update_stat'];

    if ($stat == 'v1') {
      $title = $_POST['title'];
      $desc = $_POST['description'];
      $date = date('Y-m-d');

      $update_emp = "UPDATE employee SET desciplinary='$type' WHERE empID='$empID'";
      $result_emp = $con->query($update_emp) or die($con->error);

      $sql_suspend = "INSERT INTO disciplinary(empID,title,description,date,v1) VALUES ('$empID','$title','$desc','$date','1')";
      $suspend_emp = $con->query($sql_suspend) or die($con->error);
        $msg = 'Verbal Warning';
    }

    else if (($stat == 'v2') or ($stat == 'v3')) {
      $title = $_POST['title'];
      $desc = $_POST['description'];
      $desc_id = $_POST['desc_id'];
      $date = date('Y-m-d');

        if ($stat == 'v2') {
          $dc = 'date2';
        }else{
          $dc = 'date3';
        }

      $update_emp = "UPDATE employee SET desciplinary='$type' WHERE empID='$empID'";
      $result_emp = $con->query($update_emp) or die($con->error);

      $sql_suspend = "UPDATE disciplinary SET title='$title', description='$desc', $stat='1',$dc='$date' WHERE disID='$desc_id'";
      $suspend_emp = $con->query($sql_suspend) or die($con->error);
        $msg = 'Verbal Warning';
    }

    else if (($stat == 'w1') or ($stat == 'w2')) {
      $warning = $_POST['warning'];
      $desc_id = $_POST['desc_id'];
      $date = date('Y-m-d');

      if ($stat == 'w1') {
        $dc = 'date4';
        $wc = 'warning1';
      }else{
        $dc = 'date5';
        $wc = 'warning2';
      }

      $update_emp = "UPDATE employee SET desciplinary='$type' WHERE empID='$empID'";
      $result_emp = $con->query($update_emp) or die($con->error);

      $sql_suspend = "UPDATE disciplinary SET $stat='1',$dc='$date',$wc='$warning' WHERE disID='$desc_id'";
      $suspend_emp = $con->query($sql_suspend) or die($con->error);
        $msg = 'Written Warning';
    }

    else if ($stat == 'dem') {
      $warning = $_POST['warning'];
      $desc_id = $_POST['desc_id'];
      $date = date('Y-m-d');

      $update_emp = "UPDATE employee SET desciplinary='$type' WHERE empID='$empID'";
      $result_emp = $con->query($update_emp) or die($con->error);

      $sql_suspend = "UPDATE disciplinary SET dem='1', date6='$date',demMsg='$warning' WHERE disID='$desc_id'";
      $suspend_emp = $con->query($sql_suspend) or die($con->error);
        $msg = 'Final Demotion';
    }

    else if ($stat == 'sus') {
      $warning = $_POST['warning'];
      $desc_id = $_POST['desc_id'];
      $date = date('Y-m-d');

      $update_emp = "UPDATE employee SET desciplinary='$type' WHERE empID='$empID'";
      $result_emp = $con->query($update_emp) or die($con->error);

      $sql_suspend = "UPDATE disciplinary SET sus='1', date7='$date', suspension='$warning' WHERE disID='$desc_id'";
      $suspend_emp = $con->query($sql_suspend) or die($con->error);
        $msg = 'Employee is Now Suspended';
    }

     return $msg;
  }



// update personal details tab
  function personalUpdate() {
     $con = $GLOBALS['con'];
     $empID = $_POST['empID'];
    $deptID = $_POST['deptID'];
    $desigID = $_POST['desigID'];
    $empContact = $_POST['empContact'];
    $empEmail = $_POST['empEmail'];
    $empAddress = $_POST['empAddress'];
    $dateOfResign = $_POST['dateOfResign'];
    $userType = $_POST['userType'];
    $empDOB = $_POST['empDOB'];
    $empMarital = $_POST['empMarital'];
    $empBlood = $_POST['empBlood'];
    $empSpecial = $_POST['empSpecial'];
    $epfState = $_POST['epfState'];
    $machineID = $_POST['machineID'];
    $empType = $_POST['empType'];
    $epfNo = $_POST['epfNO'];
    $shiftStart = $_POST['shiftStart'];
    $shiftEnd = $_POST['shiftEnd'];

        $sql_contact = "SELECT * FROM employee WHERE empContact='$empContact' AND empID !='$empID'";
        $result_contact = $con->query($sql_contact);
        $count_contact = $result_contact->num_rows;

        $sql_email = "SELECT * FROM employee WHERE empEmail='$empEmail' AND empID !='$empID'";
        $result_email = $con->query($sql_email);
        $count_email = $result_email->num_rows;



        if($count_contact != 0){
          $msg = '1';
        } elseif($count_email != 0){
          $msg = '2';
        }
        else{
          $sql = "UPDATE employee SET deptID='$deptID',desigID='$desigID',epfNo='$epfNo',epfState='$epfState',machineID='$machineID',empType='$empType',empContact='$empContact',empEmail='$empEmail',empAddress='$empAddress',dateOfResign='$dateOfResign',userType='$userType',empDOB='$empDOB',empMarital='$empMarital',empBlood='$empBlood',empSpecial='$empSpecial',shiftStart='$shiftStart',shiftEnd='$shiftEnd' WHERE empID='$empID' ";
          $result = $con->query($sql) or die($con->error);
          $msg = $empID;
        }
      return $msg;
  }



// update contact tabs
  public function view_contact($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM employee_contact WHERE empID='$id'";
    $result = $con->query($sql);
    return $result;
  }

  function updateContact($id){
   $con = $GLOBALS['con'];
   $recordID = $_POST['recordID'.$id.''];
   $contactname = $_POST['contactname'.$id.''];
   $ctcphone = $_POST['ctcphone'.$id.''];
   $ctcaddress = $_POST['ctcaddress'.$id.''];
   $ctcemail = $_POST['ctcemail'.$id.''];

     $sql = "UPDATE employee_contact SET contact='$ctcphone',address='$ctcaddress',email='$ctcemail' WHERE contactID='$recordID' ";
     $result = $con->query($sql) or die($con->error);
     $msg = $contactname;

     return $msg;
  }

  function addContact(){
   $con = $GLOBALS['con'];
   $empID = $_POST['empID'];
   $fullname = $_POST['fullname'];
   $relationship = $_POST['relation'];
   $contact = $_POST['empContact'];
   $email = $_POST['empEmail'];
   $address = $_POST['address'];

     $sql = "INSERT INTO employee_contact(empID,fullname,relationship,contact,address,email) VALUES('$empID','$fullname','$relationship','$contact','$address','$email')";
     $result = $con->query($sql) or die($con->error);
     $msg = 'New Contact is Saved';

     return $msg;
  }



// update education tabs
    public function view_education($id){
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM employee_education WHERE empID='$id'";
      $result = $con->query($sql);
      return $result;
    }

    public function count_education($id){
      $con = $GLOBALS['con'];
      $sql = "SELECT * FROM employee_education WHERE empID='$id'";
      $result = $con->query($sql);
      $count = $result->num_rows;
      return $count;
    }

    function addEducation(){
     $con = $GLOBALS['con'];
     $empID = $_POST['empID'];
     $degree = $_POST['degree'];
     $institute = $_POST['intitute'];
     $result = $_POST['result'];
     $start = $_POST['start'];
     $endDate = $_POST['end'];

       $sql = "INSERT INTO employee_education(empID,degree,institute,result,start,endDate)
       VALUES('$empID','$degree','$institute','$result','$start','$endDate')";
       $result = $con->query($sql) or die($con->error);
       $msg = 'New Education Record is Saved';

       return $msg;
    }


// update experiance tabs
        public function view_exp($id){
          $con = $GLOBALS['con'];
          $sql = "SELECT * FROM employee_experiance WHERE empID='$id'";
          $result = $con->query($sql);
          return $result;
        }

        public function count_exp($id){
          $con = $GLOBALS['con'];
          $sql = "SELECT * FROM employee_experiance WHERE empID='$id'";
          $result = $con->query($sql);
          $count = $result->num_rows;
          return $count;
        }

        function addExp(){
         $con = $GLOBALS['con'];
         $empID = $_POST['empID'];
         $company = $_POST['company'];
         $address = $_POST['address'];
         $contact = $_POST['contact'];
         $position = $_POST['position'];
         $start = $_POST['start'];
         $endDate = $_POST['end'];

           $sql = "INSERT INTO employee_experiance(empID,company,address,position,contact,start,endDate)
           VALUES('$empID','$company','$address','$position','$contact','$start','$endDate')";
           $result = $con->query($sql) or die($con->error);
           $msg = 'New Experiance Record is Saved';

           return $msg;
        }


// update bank details tabs
        public function view_bank($id){
          $con = $GLOBALS['con'];
          $sql = "SELECT * FROM employee_bank WHERE empID='$id'";
          $result = $con->query($sql);
          return $result;
        }

        function UpdateBank(){
         $con = $GLOBALS['con'];
         $empID = $_POST['empID'];
         $bankName = $_POST['bankName'];
         $AccHolder_name = $_POST['AccHolder_name'];
         $branchName = $_POST['branchName'];
         $accountNo = $_POST['accountNo'];
         $accountType = $_POST['accountType'];

         $sql_bankdata = "SELECT * FROM employee_bank WHERE empID ='$empID'";
         $result_bankdata = $con->query($sql_bankdata);
         $count_bankdata = $result_bankdata->num_rows;

         if ($count_bankdata == 0) {
           $sql = "INSERT INTO employee_bank(empID,bankName,AccHolder_name,branchName,accountNo,accountType)
           VALUES('$empID','$bankName','$AccHolder_name','$branchName','$accountNo','$accountType')";
           $result = $con->query($sql) or die($con->error);
         } else{
           $sql = "UPDATE employee_bank SET bankName='$bankName',AccHolder_name='$AccHolder_name',branchName='$branchName',accountNo='$accountNo',accountType='$accountType'
           WHERE empID='$empID'";
           $result = $con->query($sql) or die($con->error);
         }

           $msg = 'Employee Bank details are Updated';
           return $msg;
        }


// update bank details tabs
        public function view_doc($id){
          $con = $GLOBALS['con'];
          $sql = "SELECT * FROM employee_documents WHERE empID='$id'";
          $result = $con->query($sql);
          return $result;
        }

        public function count_doc($id){
          $con = $GLOBALS['con'];
          $sql = "SELECT * FROM employee_documents WHERE empID='$id'";
          $result = $con->query($sql);
          $count = $result->num_rows;
          return $count;
        }

        function addDoc(){
         $con = $GLOBALS['con'];
         $empID = $_POST['empID'];
         $title = $_POST['title'];

         // File upload path
         $targetDir = "../../res/employeeDoc/";
         $fileName = basename($_FILES["myfile"]["name"]);
         $targetFilePath = $targetDir . $fileName;
         $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
         $allowTypes = array('jpg', 'png', 'jpeg','docx','xlsx','pdf');

           if(in_array($fileType, $allowTypes)){
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetFilePath);

            $sql = "INSERT INTO employee_documents(empID,title,doc,type)
            VALUES('$empID','$title','$fileName','$fileType')";
            $result = $con->query($sql) or die($con->error);

            $msg = 'New Document is Added to the System';
          }else{
            $msg='Something Went Wrong..';
          }
          return $msg;
        }


//salary tabs
      public function view_salary($id){
        $con = $GLOBALS['con'];
        $sql = "SELECT * FROM employee_salary WHERE empID='$id'";
        $result = $con->query($sql);
        return $result;
      }


      function updateSalary(){
       $con = $GLOBALS['con'];
       $salaryID = $_POST['salaryID'];
       $empID = $_POST['empID'];
       $basic_salary = $_POST['basic_salary'];
       $allowance = $_POST['allowance'];
       $OTrate = $_POST['OTrate'];
       $epf = $_POST['epf'];
       $personalLoans = $_POST['personalLoans'];
       $other = $_POST['other'];

       if ($OTrate == 'No OT rate for Staff') {
         $OTrate = '';
         $DOTrate = '';
       }

       if ($salaryID == '') {
         $sql = "INSERT INTO employee_salary(empID,basic_salary,allowance,OTrate,epf,personalLoans,other)
         VALUES ('$empID', '$basic_salary', '$allowance', '$OTrate',  '$epf', '$personalLoans', '$other')";
         $result = $con->query($sql) or die($con->error);
       }else{
         $sql = "UPDATE employee_salary SET basic_salary='$basic_salary',allowance='$allowance',OTrate='$OTrate',
         epf='$epf',personalLoans='$personalLoans',other='$other' WHERE salaryID='$salaryID'";
         $result = $con->query($sql) or die($con->error);
       }

        $msg = 'Employee salary details are Updated..';
         return $msg;
      }


//leave tab
  public function view_leave($id){
    $con = $GLOBALS['con'];
    $sql = "SELECT * FROM employee_leaves WHERE empID='$id'";
    $result = $con->query($sql);
    return $result;
  }

  function updateLeave(){
   $con = $GLOBALS['con'];
   $empID = $_POST['empID'];
   $leave_type = $_POST['leave_type'];
   $total_days = $_POST['total_days'];

   if (!isset($_POST['leave'])){
     $sql = "UPDATE employee_leaves SET stat='Off' WHERE leaveID='$leave_type' AND empID='$empID'";
     $result = $con->query($sql) or die($con->error);
     $msg = $leave_type.' Leave Removed';
   } else{
     $sql5 = "SELECT * FROM employee_leaves WHERE leaveID ='$leave_type' AND empID='$empID'";
     $result5 = $con->query($sql5);
     $count5 = $result5->num_rows;
     if ($count5 == 1) {
       $sql = "UPDATE employee_leaves SET stat='On' WHERE leaveID='$leave_type' AND empID='$empID'";
       $result = $con->query($sql) or die($con->error);
       $msg = $leave_type.' Leave Assigned';
     }else{
       $sql = "INSERT INTO employee_leaves(empID,leaveID,days,used) VALUES('$empID','$leave_type','$total_days','0')";
       $result = $con->query($sql) or die($con->error);
        $msg = $leave_type.' Leave Assigned';
     }
   }
     return $msg;
  }



}

 ?>
