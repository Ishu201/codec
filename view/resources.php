<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/itemmodel.php';

$ob = new dbconnection();
$con = $ob->connection();

$obj = new item;
$result = $obj->viewItem_master();

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
  } elseif ($_SESSION['username'] == 'HR') {
    include('common/HRsidebar.php');
  } elseif ($_SESSION['username'] == 'Development') {
    include('common/leadsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('organization').className = 'active open';
      document.getElementById('resourse').className = 'active';
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
                                <h1>Manage the Company Resources</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Organization</a></li>
                                    <li class="breadcrumb-item myactive">Resources List</li>
                                </ol>
                            </div>
                        </div>
                        <a href='addResource.php' style="float:right"><button type="submit" class="btn-sm btn btn-info" >Add New Resource</button></a>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Item List</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table  table-bordered">
                                    <thead>
                                        <tr style="background-color:#cccc">
                                            <th>Item Code <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Item <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Item Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Vendor <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Purchase Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="width:80px">P-Qty <i  class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="width:80px">R-Qty <i  class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Total Cost <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        while ($row = $result->fetch_array()) {
                                          $id = $row['item_master_id'];
                                          $name = $row['itemName'];
                                          $newmsg = base64_encode($name);
                                          $price = $row['totalPrice'];
                                       ?>
                                        <tr>
                                            <td>CDC<?php echo sprintf("%04d", $id) ?></td>
                                            <td><?php echo '<b>'.$row['brandName'].'</b> - '.$row['itemName']; ?></td>
                                            <td><?php echo $row['category']; ?></td>
                                            <td><?php echo  $row['vendor'].' - <b>'.$row['shopLocation'].'</b>'; ?></td>
                                            <td><?php echo $row['purchaseDate']; ?></td>
                                            <td><?php echo $row['qty']; ?></td>
                                            <td><?php echo $obj->get_remainning($id) ?></td>
                                            <td style="text-align:right;font-weight:bold;">Rs.<?php echo number_format($price, 2); ?></td>
                                            <td>
                                              <a href="viewItems.php?id=<?php echo  $row['item_master_id']; ?>&name=<?php echo $newmsg; ?>"><button class="btn-sm btn btn-success" >View</button></a>
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

      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
