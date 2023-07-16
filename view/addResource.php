<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <script type="text/javascript">
    $( document ).ready(function() {
      $('#unitprice').keyup(function() {
      var qty = $('#qty').val();
      var unit = $('#unitprice').val();
      $('#totalprice').val(qty*unit);
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
                                <h1>New Resources</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="resources.php">Resource List</a></li>
                                    <li class="breadcrumb-item myactive">Add new Resource</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/itemAlert.php') ?>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Add Resource</h4>
                        </div>
                        <div class="basic-form"> <br>
                            <form  method="post" action="controller/itemcontroller.php?status=add" enctype="multipart/form-data">
                              <div class="form-group">
                              <label for="myfile"> <span style="color:red">*</span> Item Image:</label> <br>
                                <input type="file" id="myfile" name="image" accept="image/*" required>
                                <p style="font-size:13px;margin-top:5px;color:#ac5377">Please use only .jpg .jpeg .png and .webp files</p>
                              </div>

                              <?php
                              $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='codec' AND TABLE_NAME ='item_master'";
                              $result = $con->query($sql);
                              $row = $result->fetch_array();
                              $num = $row[0];
                               ?>

                              <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>Resource ID <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="resID" readonly value="CDC<?php echo sprintf("%05d", $num) ?>">
                                      <input type="hidden"  class="form-control" name="masterID" readonly value="<?php echo $num ?>">
                                  </div>
                                </div>
                                <div class="col-lg-5 col-sm-6">
                                  <div class="form-group">
                                      <label>Item Name <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="itemName" placeholder="Item Name" required>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>Brand Name <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="brandName"  required>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Item Category <span style="color:red">*</span></label>
                                      <select class="form-control" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Technological Devices">Technological Devices</option>
                                        <option value="Computer Accessories">Computer Accessories</option>
                                        <option value="Other Machines">Other Machines</option>
                                        <option value="Office Furnitures">Office Furnitures</option>
                                        <option value="Stationery and Office Supplies">Stationery and Office Supplies</option>
                                        <option value="Other Resources">Other Resources</option>
                                      </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Seller <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="vendor" placeholder="Seller Company" required>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Seller Location <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="shopLocation" placeholder="Company Location" required>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>Warrant End Date </label>
                                      <input type="date" class="form-control" name="warrentDate" min="<?php echo date('Y-m-d') ?>">
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Purchase Date <span style="color:red">*</span></label>
                                      <input type="date"  class="form-control" name="purchaseDate" required placeholder="yyyy-mm-dd" max="<?php echo date('Y-m-d') ?>">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Qty <span style="color:red">*</span></label>
                                      <input id="qty" type="number"  class="form-control" name="qty" required placeholder="No of Items" min="0">
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Unit Price <span style="color:red">*</span></label>
                                      <input id="unitprice" type="number"  class="form-control" name="unitPrice" required placeholder="Enter Unit Price" min="0">
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                  <div class="form-group">
                                      <label>Total Cost <span style="color:red">*</span></label>
                                      <input id="totalprice" type="number"  class="form-control" name="totalPrice" required readonly min="0" placeholder="Cost for the full purchase">
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Payment Method <span style="color:red">*</span></label>
                                      <select class="form-control" name="method" required>
                                        <option value="">Select Category</option>
                                        <option value="Online Banking">Online Banking</option>
                                        <option value="Bank Transaction">Bank Transaction</option>
                                        <option value="Check Payment">Check Payment</option>
                                        <option value="Cash Payment">Cash Payment</option>
                                      </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12 col-sm-6">
                                  <div class="form-group">
                                      <label>Item Description <span style="color:red">*</span></label>
                                      <textarea class="form-control" style="height:100px;" name="descript" rows="8" cols="80" placeholder="Enter an Item Description" required></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="float-right">
                                <button type="reset" class="btn btn-default">Clear</button>
                                <button type="submit" class="btn btn-success">Add</button>
                              </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->


      <?php include('common/footer.php') ?>
     <!-- footer -->

          <script src="assets/js/lib/toastr/toastr.min.js"></script>
          <script src="assets/js/lib/toastr/toastr.init.js"></script>

</body>

</html>
