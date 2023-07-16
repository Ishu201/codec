<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/departmentmodel.php';
include 'model/designationmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new department;
$result = $obj->viewDept();

$desig = new designation;
?>

<?php
 if ($_SESSION['username'] == '') {
   $msg = base64_encode('Please Log in to the system..!');
   header("Location:../index.php?msg=$msg");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style media="screen">
       tr:hover{
        background-color: #e6e6e6;
        cursor: pointer;
      }
    </style>

</head>

<body>

    <?php include('common/sidebar.php') ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('organization').className = 'active open';
      document.getElementById('dept').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Manage the Organization's Structure</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Organization</a></li>
                                    <li class="breadcrumb-item myactive">Department</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                <?php include('src/departmentAlert.php') ?>

                  <div class="row">
                    <div class="col-lg-5 col-sm-12">
                      <div class="card">
                          <div class="card-title">
                              <h4>Add New Department</h4>
                          </div>
                          <div class="card-body">
                              <div class="basic-form"> <br>
                                  <form action="controller/departmentcontroller.php?status=add" method="post">
                                      <div class="form-group">
                                          <label>Department Name <span style="color:red">*</span></label>
                                          <input type="text" placeholder="Enter Department Name"  class="form-control" name="deptName" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Department Head <span style="color:red">*</span></label>
                                          <select class="form-control" name="empID" required>
                                            <option value="">Select an Employee..</option>
                                            <?php
                                            $sql_emp = "SELECT * FROM employee WHERE empJobStatus='Working'";
                                            $result_emp = $con->query($sql_emp);
                                            while ($row_emp = $result_emp->fetch_array()) {
                                              $employee = $row_emp['empID'];
                                              $sql2 = "SELECT * FROM department WHERE empID='$employee'";
                                              $result2 = $con->query($sql2);
                                               $count2 = $result2->num_rows;
                                                if ($count2 < 1) {
                                             ?>
                                            <option value="<?php echo $row_emp['empID'] ?>"><?php echo $row_emp['empName'] ?></option>
                                          <?php } } ?>
                                          <option value="0" style="font-weight:bold">New Employee</option>
                                          </select>
                                      </div>
                                      <div class="float-right">
                                        <button type="reset" class="btn btn-default">Clear</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="col-lg-7 col-sm-12">
                      <div class="card">
                          <div class="card-title">
                              <h4>Department List </h4>
                          </div>

                          <div class="card-body"> <br>
                              <div class="table-responsive">
                                  <table class="table table-bordered" id="ttb">
                                      <thead>
                                          <tr style="background-color:#d6d6d6">
                                              <th>#</th>
                                              <th>Department Name</th>
                                              <th>HOD</th>
                                              <th>Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php $k=1;
                                          while ($row = $result->fetch_array()) {
                                            $empID = $row['empID'];
                                            if ($empID == 0) {
                                              $name = '<b>Assign a New Employee</b>';
                                            } else{
                                              $sql_getname = "SELECT * FROM employee WHERE empID='$empID'";
                                              $result_getname = $con->query($sql_getname);
                                              $row__getname = $result_getname->fetch_array();
                                              $name = $row__getname['empName'];
                                            }

                                        ?>
                                          <tr data-toggle="collapse" data-target="#demo<?php echo $k ?>" class="accordion-toggle">
                                              <th scope="row"><?php echo $k ?></th>
                                              <td><?php echo $row['deptName'] ?></td>
                                              <td><?php echo $name; ?></td>
                                              <td>
                                                <a href="department.php?msg=edit&id=<?php echo  $row['deptID']; ?>&code"><button class="btn-sm btn btn-success" >Edit</button></a>
                                                <button class="btn-sm btn-danger btn sweet-message delete" data-id="<?php echo  $row['deptID']; ?>">Remove</button>
                                              </td>
                                          </tr>

                                          <?php
                                            $id = $row['deptID'];
                                            $result_desigName = $desig->viewDesig_dept($id);
                                            $count = $result_desigName->num_rows;
                                            if ($count > 0) {
                                          ?>

                                          <tr >
                                      			<td colspan="12" class="hiddenRow"  style="padding:0 !important;">
                                      				<div class="accordian-body collapse" id="demo<?php echo $k ?>">
                                      					<table class="table">
                                                  <thead>
                                      							<tr class="info">
                                      								<th style="text-align:left">Designation</th>
                                      								<th>No of Employees</th>
                                      							</tr>
                                      						</thead>

                                      						<tbody>
                                                    <?php
                                                      while ($row_desigName = $result_desigName->fetch_array()) {
                                                        $des = $row_desigName['desigID'];
                                                        $sql_emp = "SELECT * FROM employee WHERE desigID='$des' AND empJobStatus='Working'";
                                                        $result_emp = $con->query($sql_emp);
                                                        $count_emp = $result_emp->num_rows;

                                                         ?>
                                                        <tr>
                                          								<th style="text-align:left"><?php echo $row_desigName['designation']; ?></th>
                                          								<th><?php echo $count_emp; ?></th>
                                          							</tr>
                                                    <?php  } ?>
                                                  </tbody>
                                                </table>
                                      				</div>
                                      			</td>
                                      		</tr>
                                        <?php } ?>

                                        <?php $k++; } ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>



                  <?php include('build/editDept.php') ?>
                  <?php include('build/removeDept.php') ?>

      <?php include('common/footer.php') ?>
     <!-- footer -->

     <script src="assets/js/lib/toastr/toastr.min.js"></script>
     <script src="assets/js/lib/toastr/toastr.init.js"></script>

</body>

</html>
