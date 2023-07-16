<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();
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
    <link rel="stylesheet" href="assets/css/pagination.css">

    <style media="screen">
      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;
      }

      .dataTables_length{
        position: absolute;
        top:50px;
        right:5px;
        margin-bottom: 10px
      }

      .dt-buttons{
        position: absolute;
      }


      .dataTables_filter{
        position: absolute;
        top:65px;
        left:15px;
      }

      .table-responsive{
        margin-top:60px;
      }

      .pagination{
        position: absolute;
        bottom: 10px;
        right: 15px;
      }

      .dataTables_info{
        margin-top: 10px;
      }

      .btn-sm{
        font-size: 13px;
      }

      .media-object{
        width:35px;
        height:35px;
        border-radius:50%
      }

      abbr {
  font-style: italic;
  position: relative
}

abbr:hover::after {
  background: #343957;
  border-radius: 4px;
  bottom: 50%;
  color: #f2f2f2;
  content: attr(title);
  display: block;
  right: 20%;
  padding: 8px;
  position: absolute;
  width: 280px;
  z-index: 9999;
}

    </style>
</head>

<body>

  <?php
    include('common/empsidebar.php');
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('comProjects').className = 'active';
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
                                <h1>Manage the Project List</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Projects</a></li>
                                    <li class="breadcrumb-item myactive">Project List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <?php include('src/projectAlert.php') ?>
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Completed Projects List</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#d6d6d6">
                                            <th>Project Title</i></th>
                                            <th>Project Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:center">Handled By</th>
                                            <th>Task List <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql = "SELECT projects.* FROM projects INNER JOIN project_members ON project_members.projectID=projects.projectID WHERE project_members.empID='$session_empID' AND project_members.stat='on' AND projects.status='Completed'";
                                      $result = $con->query($sql);
                                      while ($row = $result->fetch_array()) { ?>
                                        <tr>
                                            <td>
                                              <?php echo $row['project_name']; ?>
                                            </td>
                                            <td><?php echo $row['project_type']; ?></td>
                                            <?php
                                            $pempID = $row['empID'];
                                              $sql2 = "SELECT * FROM employee WHERE empID='$pempID'";
                                              $result2 = $con->query($sql2);
                                              $row2 = $result2->fetch_array()
                                            ?>
                                            <td><?php echo $row2['empName']; ?></td>
                                            <td>
                                              <?php
                                                $pid = $row['projectID'];
                                                $sql_protask = "SELECT * FROM project_maintenance WHERE stat='TODO' AND projectID='$pid' AND priority='3'  AND view='yes' AND empID='$session_empID'";
                                                $result_protask  = $con->query($sql_protask);
                                                $count_protask  = $result_protask ->num_rows;
                                                if ($count_protask <= 0) {
                                                  $count_protask = 0;
                                                }
                                                ?>
                                                  <span class="badge badge-success" style="margin-right:10px;float:right;padding:5px;width:20px;border-radius:50%"><?php echo $count_protask; ?></span>

                                              <?php
                                                $pid = $row['projectID'];
                                                $sql_protask = "SELECT * FROM project_maintenance WHERE stat='TODO' AND projectID='$pid' AND priority='2'  AND view='yes' AND empID='$session_empID'";
                                                $result_protask  = $con->query($sql_protask);
                                                $count_protask  = $result_protask ->num_rows;
                                                if ($count_protask <= 0) {
                                                  $count_protask = 0;
                                                }
                                                ?>
                                                  <span class="badge badge-warning" style="margin-right:10px;float:right;padding:5px;width:20px;border-radius:50%"><?php echo $count_protask; ?></span>

                                              <?php
                                                $pid = $row['projectID'];
                                                $sql_protask = "SELECT * FROM project_maintenance WHERE stat='TODO' AND projectID='$pid' AND priority='1'  AND view='yes' AND empID='$session_empID'";
                                                $result_protask  = $con->query($sql_protask);
                                                $count_protask  = $result_protask ->num_rows;
                                                if ($count_protask <= 0) {
                                                  $count_protask = 0;
                                                }
                                                ?>
                                                  <span class="badge badge-danger" style="margin-right:10px;float:right;padding:5px;width:20px;border-radius:50%"><?php echo $count_protask; ?></span>


                                            </td>
                                            <td>
                                              <a href="empeditCProject.php?projectID=<?php echo $row['projectID'] ?>"><button type="submit" class="btn-sm btn btn-success" >view</button></a>
                                            </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                  </div>



      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
