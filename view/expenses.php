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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/pagination.css">

    <style media="screen">
      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;
      }

      input[type="search"]{
        width:300px !important;
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

      .sortIcon{
        font-size: 10px;
      }
    </style>
</head>

<body>

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('organization').className = 'active open';
      document.getElementById('expenses').className = 'active';
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
                                <h1>Company Expenses Management</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Organization</a></li>
                                    <li class="breadcrumb-item myactive">Expenses List</li>
                                </ol>
                            </div>
                        </div>
                        <a href='addBill.php' style="float:right"><button type="submit" class="btn-sm btn btn-info" >Add Payment</button></a>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Payment List</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table  table-bordered">
                                    <thead>
                                        <tr style="background-color:#cccc">
                                            <th>ID <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Expense Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Account <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Pay Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Payment Method <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Amount <i  class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $no=1;
                                      $sql_exp = "SELECT * FROM expenses";
                                      $result_exp = $con->query($sql_exp);
                                      while($row_exp = $result_exp->fetch_array()){

                                       ?>
                                        <tr>
                                            <td><b><?php echo sprintf("%05d",$row_exp['expenseID']); ?></b></td>
                                            <td><?php echo $row_exp['type']; ?></td>
                                            <td><?php echo $row_exp['account']; ?></td>
                                            <td><?php echo $row_exp['paidDate']; ?></td>
                                            <td><?php echo $row_exp['method']; ?></td>
                                            <td>Rs.<?php echo number_format($row_exp['amount'], 2); ?></td>
                                        </tr>
                                      <?php $no++; } ?>

                                    </tbody>
                                </table> <br>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
