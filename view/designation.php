<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/designationmodel.php';
include 'model/departmentmodel.php';
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();
$desig = new designation;
$result_desig = $desig->viewDesig();

$dept = new department;
$result_dept = $dept->viewDept();
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
    <link rel="stylesheet" href="assets/css/pagination.css">

    <style media="screen">
      .dataTables_length{
        position: absolute;
        top:50px;
        right:5px;
        margin-bottom: 10px
      }

      input[type="search"]{
        width:300px !important;
      }

      .dt-buttons{

      }


      .dataTables_filter{
        position: absolute;
        top:55px;
        left:15px;
      }

      .table-responsive{
        margin-top:50px;
      }

      .pagination{
        position: absolute;
        bottom: 10px;
        right: 15px;
      }

      .dataTables_info{
        margin-top: 10px;
      }

      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;
      }



    </style>

</head>

<body>

    <?php include('common/sidebar.php') ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('organization').className = 'active open';
      document.getElementById('desig').className = 'active';
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
                                    <li class="breadcrumb-item myactive">Designation</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/designationAlert.php') ?>

                  <div class="row">
                    <div class="col-lg-4 col-sm-12">
                      <div class="card">
                          <div class="card-title">
                              <h4>Add New Designation</h4>
                          </div>
                          <div class="card-body">
                              <div class="basic-form"> <br>
                                  <form action="controller/designationcontroller.php?status=add" method="post">
                                      <div class="form-group">
                                          <label>Designation Name <span style="color:red">*</span></label>
                                          <input type="text" placeholder="Enter Designation Name"  class="form-control" name="designation" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Department <span style="color:red">*</span></label>
                                          <select class="form-control" name="deptID" required>
                                            <option value="">Select the Department</option>
                                            <?php
                                              while ($row_dept = $result_dept->fetch_array()) { ?>
                                            <option value="<?php echo $row_dept['deptID'] ?>"><?php echo $row_dept['deptName'] ?></option>
                                            <?php
                                              }
                                            ?>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label>Salary <span style="color:red">*</span></label>
                                          <input type="number" placeholder="Enter Basic Salary Rs."  class="form-control" name="salary" required>
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

                    <div class="col-lg-8 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Designation List</h4>
                        </div>
                          <div class="bootstrap-data-table-panel">
                              <div class="table-responsive">
                                  <table id="bootstrap-data-table-export" class="table table-bordered">
                                      <thead>
                                          <tr style="background-color:#d6d6d6">
                                              <th>Designation <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                              <th>Department <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                              <th>Basic Salary <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                              <th>Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        while ($row_des = $result_desig->fetch_array()) {
                                          $id = $row_des['deptID'];
                                            $result_deptName = $dept->viewDept_selected($id);
                                            $row_deptName = $result_deptName->fetch_array();
                                          ?>
                                        <tr>
                                            <td><?php echo $row_des['designation']; ?></td>
                                            <td><?php echo $row_deptName['deptName']; ?></td>
                                            <td style="text-align:right">Rs. <?php echo number_format($row_des['basic_salary'], 2); ?></td>
                                            <td>
                                              <a href="designation.php?msg=edit&id=<?php echo  $row_des['desigID']; ?>&code"><button class="btn-sm btn btn-success">Edit</button></a>
                                              <button class="btn-sm btn-danger btn sweet-message delete" data-id="<?php echo  $row_des['desigID']; ?>">Remove</button>
                                            </td>
                                        </tr>
                                      <?php } ?>
                                      </tbody>
                                      <tbody>
                                        <?php
                                        while ($row_des = $result_desig->fetch_array()) {
                                          $id = $row_des['deptID'];
                                            $result_deptName = $dept->viewDept_selected($id);
                                            $row_deptName = $result_deptName->fetch_array();
                                          ?>
                                        <tr>
                                            <td><?php echo $row_des['designation']; ?></td>
                                            <td><?php echo $row_deptName['deptName']; ?></td>
                                            <td style="text-align:right">Rs. <?php echo number_format($row_des['basic_salary'], 2); ?></td>
                                            <td>
                                              <a href="designation.php?msg=edit&id=<?php echo  $row_des['desigID']; ?>"><button class="btn-sm btn btn-success">Edit</button></a>
                                              <button class="btn-sm btn-danger btn sweet-message delete" data-id="<?php echo  $row_des['desigID']; ?>">Remove</button>
                                            </td>
                                        </tr>
                                      <?php } ?>
                                      </tbody>
                                  </table> <br>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>



                  <?php include('build/editDesignation.php') ?>
                  <?php include('build/removeDesig.php') ?>

      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>
     <script src="assets/js/lib/toastr/toastr.min.js"></script>
     <script src="assets/js/lib/toastr/toastr.init.js"></script>

</body>

</html>
