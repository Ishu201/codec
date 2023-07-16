<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/itemmodel.php';
include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

$dept = new department;
$result_dept = $dept->viewDept();

?>

<?php
$master_id = $_REQUEST['id'];
$master_name = base64_decode($_REQUEST['name']);

$quality_ornot='';

$obj = new item();
$res = $obj->viewItem_masterSelected($master_id);
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <style media="screen">
    .media{
      border: none !important;
    }

    .contact-title{
      font-size:13px !important
    }

    .phone-number{
      font-size: 13px !important
    }

    .specD{
      font-size: 14px !important;
      font-weight: bold;
    }
    .phone-number{
      color: #333333;
    }

    th{
      color:#3973ac !important;
    }
    td{
      color:#404040 !important
    }
    </style>

    <script type="text/javascript">
    $( document ).ready(function() {
      $(".dial").knob({
        'format' : function (value) {
           return value + '%';
        }
      });
    });
    </script>
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
      document.getElementById('resourse').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-7 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>View Items of CDC</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="resources.php">Resource List</a></li>
                                    <li class="breadcrumb-item myactive">View Items</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/item_edit_Alert.php') ?>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Item Details</h4>
                        </div>

                        <?php
                          $row = $res->fetch_array();
                          if ($row['category']=='Stationery and Office Supplies') {
                            $quality_ornot='not';
                          }
                         ?>

                        <!-- start -->
                        <div class="user-profile" >
                          <div class="row" >
                            <div class="col-lg-3" >
                              <div class="user-photo m-b-30" > <br>
                                <center>
                                <img style="width:200px;height:180px;" class="img-fluid" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" alt="" />
                                <br> <br>
                                <h4><?php echo $row['brandName'].' - '.$row['itemName']; ?></h4>
                                <h6><?php echo $row['category']; ?></h6>
                              </center>
                              </div>

                            </div>

                            <div class="col-lg-9" >
                              <div class="basic-form" style="width:95%"> <br>
                                <p>
                                  <i class="ti-location-pin"></i> <?php echo  $row['vendor'].' - <b>'.$row['shopLocation'].'</b>'; ?>
                                </p>
                                <div class="row" style="height:30px;">
                                  <div class="col-lg-2" >
                                    <span class="contact-title specD">Purchase Date:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD"><?php echo $row['purchaseDate']; ?></span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="contact-title specD">Warrant Date:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD">
                                      <?php
                                      if ($row['warrentDate'] == '') {
                                        echo 'No Warrant';
                                      }else {
                                        echo $row['warrentDate'];
                                      }
                                      ?>
                                    </span>
                                  </div>
                                </div>

                                <div class="row" style="height:30px;">
                                  <div class="col-lg-2">
                                    <span class="contact-title specD">Total Amount:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD">Rs.<?php echo number_format($row['totalPrice'], 2) ; ?></span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="contact-title specD">Unit Price:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD">Rs.<?php $num = $row['totalPrice']/$row['qty']; echo number_format($num, 2) ?></span>
                                  </div>
                                </div>

                                <div class="row" style="height:30px;">
                                  <div class="col-lg-2">
                                    <span class="contact-title specD">Total Items:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD"><?php echo $row['qty']; ?></span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="contact-title specD">Remaining Items:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD"><?php  echo $obj->get_remainning($master_id) ?></span>
                                  </div>
                                  <?php if ($quality_ornot=='') { ?>
                                  <div class="col-lg-2">
                                    <span class="contact-title specD">Items At Repair:</span>
                                  </div>
                                  <div class="col-lg-2">
                                    <span class="phone-number specD">
                                      <?php
                                      $sql = "SELECT * FROM item WHERE status='Repair' AND item_master_id='$master_id'";
                                      $result = $con->query($sql);
                                      $rowcount= mysqli_num_rows($result);
                                      echo $rowcount;
                                      ?>
                                    </span>
                                  </div> <?php } ?>
                                </div>
                                <br>
                                  <p><?php echo $row['descript']; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end -->

  <!-- checking if the stationary item or not -->
                    <?php if ($quality_ornot=='') { ?>
                      <div class="recent-comment">
                        <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                          <?php
                            $res2 = $obj->viewIndividual_ItemSelected($master_id);
                            $i=1;
                            while ($row2 = $res2->fetch_array()) {
                              $item_id = $row2['itemID'];
                           ?>
                          <!-- start first -->
                          <div class="card-header" role="tab" id="headingTwo<?php echo $i; ?>" >
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $i; ?>">
                              <div class="media" >
                                  <div class="media-left">
                                    <div class="card-body m-t-15 text-center text-center" style="margin-top:0px !important;padding:5px !important">
                                      <input class="knob dial" data-fgColor="#336699" data-bgcolor="#c6d9ec" data-thickness=".3" readonly value="<?php echo $row2['quality']; ?>" data-width="45%" >
                                      <!-- <input class="knob" data-width="40px" value="5" readonly> -->
                                    </div>
                                  </div>
                                  <div class="media-body">
                                    <h4 class="media-heading">Item - <?php echo sprintf("%02d", $i) ; ?></h4>
                                    <p>Allocation &nbsp &nbsp &nbsp  - &nbsp <?php echo $row2['allocation']; ?> </p>
                                    <p>Defects &nbsp &nbsp &nbsp &nbsp - &nbsp
                                      <?php
                                       if( $row2['defects'] == 'No'){
                                         echo 'Not at the Time Period';
                                       } else{
                                         echo $row2['defects'];
                                       }
                                      ?>
                                    </p>
                                    <p>Current Value &nbsp - &nbsp Rs.<?php echo number_format($row2['value'], 2); ?></p>
                                      <p class="comment-date" >
                                        <?php
                                          if ($row2['status'] == 'Repair') {
                                            echo '<a href="viewItems.php?id='.$_REQUEST['id'].'&name='.$_REQUEST['name'].'&msg=repairoff&getid='.$row2['itemID'].'"><span class="badge badge-danger" style="color:white">At Repair</span></a>';
                                          }elseif ($row2['status'] == 'Working') {
                                            echo '<a href="viewItems.php?id='.$_REQUEST['id'].'&name='.$_REQUEST['name'].'&msg=repairon&getid='.$row2['itemID'].'"><span class="badge badge-success" style="color:white">Working</span></a>';
                                          }else{
                                            echo '<span class="badge badge-dark" style="color:white">Out of Use</span>';
                                          }
                                         ?>
                                      </p>
                                  </div>
                              </div>
                            </a>
                          </div>
                          <div id="collapseTwo<?php echo $i; ?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $i; ?>" data-parent="#accordionEx1">
                            <div class="card-body" style="padding:10px;">
                              <div class="row">
                                <!-- check and display if there any maintenance records -->
                                <?php
                                  $res3 = $obj->maintenance_ItemSelected($item_id);
                                  $rowcount2= mysqli_num_rows($res3);
                                  if ($rowcount2 > 0) { ?>
                                  <div class="col-lg-10">
                                    <h5 class="reqHeading" style="color:#336699">Maintenance History</span> </h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Date</th>
                                                  <th>Reason</th>
                                                  <th>Computer Shop</th>
                                                  <th>Total Cost</th>
                                                  <th>Return Date</th>
                                                  <th>Status</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $no=1;
                                          while ($row3 = $res3->fetch_array()) {
                                         ?>

                                              <tr>
                                                  <th scope="row"><?php echo $no; ?></th>
                                                  <td><?php echo $row3['startDate']; ?></td>
                                                  <td><?php echo $row3['reason']; ?></td>
                                                  <td><?php echo $row3['shop']; ?> - <span style="font-weight:bold"><?php echo $row3['shopLocation']; ?></span></td>
                                                  <td style="text-align:right;padding-right:35px;">Rs.<?php echo number_format($row3['cost'], 2); ?></td>
                                                  <td style="padding-left:20px"><?php echo $row3['deliveredDate']; ?></td>
                                                  <?php if($row3['status'] =='Successfull'){ ?>
                                                  <td style="color:#28A745 !important;font-weight:bold">Successfull</td>
                                                <?php }else if($row3['status'] =='Unsuccessfull'){ ?>
                                                  <td style="color:red !important;font-weight:bold">Unsuccessfull</td>
                                                <?php }else{ ?>
                                                  <td style="font-weight:bold">-</td>
                                                <?php } ?>
                                                </tr>

                                            <?php $no++; } ?>
                                              </tbody>
                                          </table>
                                      </div>
                                    </div>
                            <?php } else{ ?>
                                <!-- else if there are no maintenance record -->
                                <div class="col-lg-10">
                                  <h5 class="reqHeading" style="color:#336699">No Maintenance Record</span> </h5>
                                </div>
                              <?php } ?>
                              <div class="col-lg-2" >
                                <div class="float-right"> <br>
                                  <?php
                                    if ($row2['quality'] > 0) { ?>
                                    <a href="viewItems.php?id=<?php echo $_REQUEST['id'] ?>&name=<?php echo $_REQUEST['name'] ?>&msg=editItemData&getid=<?php echo $row2['itemID'] ?>" ><button type="submit" class="btn-sm btn btn-dark" ><i class="ti-marker-alt"></i> &nbsp Edit</button></a>
                                  <?php  }
                                   ?>
                                </div>
                              </div>

                              </div>
                            </div>
                          </div>
                          <!-- end first -->
                        <?php $i++; } ?>
                        </div>
                      </div>
                    <?php }else{ ?>
<!-- checking stationary products view -->
                      <div class="row" style="margin-left:15px;">
                        <div class="col-lg-6">
                          <h5 class="reqHeading" style="color:#336699">Item List</span> </h5>
                          <div class="table-responsive">
                              <table class="table">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Status</th>
                                          <th style="text-align:right">Value</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $res2 = $obj->viewIndividual_ItemSelected($master_id);
                                      $i=1;
                                      while ($row2 = $res2->fetch_array()) {
                                        $item_id = $row2['itemID'];
                                     ?>
                                      <tr>
                                          <th scope="row"><?php echo $i; ?></th>
                                          <td><?php echo $row2['allocation']; ?></td>
                                          <td style="text-align:right">Rs.<?php echo number_format($row2['value'],2); ?></td>
                                          <td>
                                          <?php if ($row2['allocation'] == 'In the Stock'){ ?>
                                              <a href="controller/itemcontroller.php?itemID=<?php echo $item_id; ?>&status=removeStationary&id=<?php echo $_REQUEST['id'] ?>&name=<?php echo $_REQUEST['name'] ?>">
                                                <button type="submit" class="btn-sm btn btn-dark" style="font-size:11px;"><i class="ti-close"></i> &nbsp Empty Stock</button>
                                              </a>
                                          <?php } else{ ?>
                                              -
                                          <?php } ?>
                                          </td>
                                      </tr>
                                    <?php $i++; } ?>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <!-- end product type check -->
                      </div>
                    </div>
                  <!-- </div> -->

      <?php  include('build/edititem_stat.php')?>
      <?php  include('build/maintenance.php')?>
      <?php include('common/footer.php') ?>
     <!-- footer -->

          <script src="assets/js/lib/toastr/toastr.min.js"></script>
          <script src="assets/js/lib/toastr/toastr.init.js"></script>



          <!--ION Range Slider JS-->
          <script src="assets/js/lib/knob/jquery.knob.min.js "></script>
          <script src="assets/js/lib/knob/knob.init.js "></script>


</body>

</html>
