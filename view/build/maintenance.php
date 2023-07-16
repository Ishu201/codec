<div class="modal fade" id="repairOn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle2">Sent for Repair</h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                  <?php if ((isset($_REQUEST['getid']))) { ?>
                    <form action="controller/itemcontroller.php?status=senttorepair&id=<?php echo $_REQUEST['id'] ?>&name=<?php echo $_REQUEST['name'] ?>" method="post">
                      <input type="hidden" name="itemID" value="<?php echo $id_edit = $_REQUEST['getid'] ?>">
                          <div class="form-group">
                              <label>Failure <span style="color:red">*</span></label>
                              <input type="text" placeholder="Enter the Reason of the Failure" class="form-control" name="reason" required >
                          </div>
                          <div class="form-group">
                              <label>Date <span style="color:red">*</span></label>
                              <input type="date" value="<?php echo date('Y-m-d')?>" class="form-control" name="startDate" required >
                          </div>
                          <div class="form-group">
                              <label>Repair Center <span style="color:red">*</span></label>
                              <input type="text" placeholder="Enter the Repair Center Name"  class="form-control" name="shop" required>
                          </div>
                          <div class="form-group">
                              <label>Shop Location <span style="color:red">*</span></label>
                              <input type="text" placeholder="Enter the Shop Location"  class="form-control" name="shopLocation" required>
                          </div>
                           <br>
                          <div class="float-right">
                            <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                    </form>
                  <?php } ?>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- if we select Successfull total cost and pay method should appear and if we select Unsuccessfull quality and new value should appear -->

<div class="modal fade" id="repairOff" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Return From Repair</h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                  <?php if ((isset($_REQUEST['getid']))) { ?>
                    <form action="controller/itemcontroller.php?status=backfromrepair&id=<?php echo $_REQUEST['id'] ?>&name=<?php echo $_REQUEST['name'] ?>" method="post">
                      <input type="hidden" name="itemID" value="<?php echo $id_edit = $_REQUEST['getid'] ?>">
                      <?php
                        $sql = "SELECT * FROM item_maintenance WHERE itemID='$id_edit' ORDER BY maintenanceID DESC LIMIT 1";
                        $getlast_rec = $con->query($sql);
                        $lastrec = $getlast_rec->fetch_array();

                        $result_edit = $obj->viewIndividual_ItemDataSelected($id_edit);
                        $row_edit = $result_edit->fetch_array();
                       ?>
                       <input type="hidden" name="mainID" value="<?php echo $lastrec['maintenanceID']; ?>">
                        <div class="form-group">
                            <label>Computer Shop</label>
                            <input type="text" value="<?php echo $lastrec['shop']; ?> - <?php echo $lastrec['shopLocation']; ?>" class="form-control"  readonly style="text-transform:capitalize">
                        </div>
                        <div class="form-group">
                            <label>Failure</label>
                            <input type="text" value="<?php echo $lastrec['reason']; ?>" class="form-control"  readonly style="text-transform:capitalize">
                        </div>
                        <div class="form-group">
                            <label>Return Date <span style="color:red">*</span></label>
                            <input type="date" value="<?php echo date('Y-m-d')?>" class="form-control" name="deliveredDate" required >
                        </div>
                        <div class="form-group">
                            <label>Status <span style="color:red">*</span></label>
                            <select class="form-control" name="stat" required id="getstat" onchange="get_stat()">
                              <option value=""> - Select Repair Status - </option>
                              <option value="Successfull">Successfull</option>
                              <option value="Unsuccessfull" >Unsuccessfull</option>
                            </select>
                        </div>
                        <script type="text/javascript">

                        </script>
                        <div id="sucdiv" style="display:none">
                        <div class="form-group">
                            <label>Total Cost <span style="color:red">*</span></label>
                            <input id="sucdiv_input1" type="number" min="0" placeholder="Total Cost for the Maintenance Process"  class="form-control" name="cost" >
                        </div>
                        <div class="form-group">
                            <label>Payment Method <span style="color:red">*</span></label>
                            <select id="sucdiv_input2" class="form-control" name="method" >
                              <option value="">Select Category</option>
                              <option value="Online Banking">Online Banking</option>
                              <option value="Bank Transaction">Bank Transaction</option>
                              <option value="Check Payment">Check Payment</option>
                              <option value="Cash Payment">Cash Payment</option>
                            </select>
                        </div>
                      </div>
                      <div id="unsucdiv" style="display:none">
                        <div class="form-group">
                            <label>Quality <span style="color:red">*</span></label>
                            <input id="unsuc_input1" type="number" max="99" min="0" value="<?php echo $row_edit['quality']; ?>"  class="form-control" name="quality" onchange="reduce_val()">
                        </div>
                        <div class="form-group">
                            <label>Value <span style="color:red">*</span></label>
                            <input id="unsuc_input2" type="number" value="<?php echo $row_edit['value']; ?>" max="<?php echo $row_edit['value']; ?>" min="0"  class="form-control" name="value" >
                        </div>
                    </div>
                         <br>
                        <div class="float-right">
                          <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                  </form>
                  <?php } ?>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>


<script type="text/javascript">
  function get_stat() {
    var selects = $("#getstat").val();
    if (selects == 'Successfull') {
      $("#sucdiv").css("display", "block");
      $("#unsucdiv").css("display", "none");

      $("#sucdiv_input1").prop('required',true);
      $("#sucdiv_input2").prop('required',true);
      $('#unsuc_input1').removeAttr('required');
      $('#unsuc_input2').removeAttr('required');
    }else{
      $("#sucdiv").css("display", "none");
      $("#unsucdiv").css("display", "block");

      $("#unsuc_input1").prop('required',true);
      $("#unsuc_input2").prop('required',true);
      $('#sucdiv_input1').removeAttr('required');
      $('#sucdiv_input2').removeAttr('required');
    }
  }

  function reduce_val() {
    var qual = $("#unsuc_input1").val();
    if (qual == '0') {
      $("#unsuc_input2").val('0');
    }
  }
</script>
