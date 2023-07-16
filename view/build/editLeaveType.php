<div class="modal fade" id="editLeaveType" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Department Details</h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                    <form action="controller/leavetypescontroller.php" method="post">
                        <input type="hidden" name="leaveID" value="<?php echo $id_edit = $_REQUEST['id'] ?>">
                        <?php
                        $sqll = "SELECT * FROM company_leaves WHERE leaveID='$id_edit'";
                        $resultl = $con->query($sqll);
                        $row = $resultl->fetch_array();
                         ?>
                      <div class="form-group">
                          <label>Leave Type <span style="color:red">*</span></label>
                          <input type="text"  class="form-control" name="leaveName" required value="<?php echo $row['leave_type']; ?>" readonly>
                      </div>
                      <div class="form-group">
                          <label>Days <span style="color:red">*</span></label>
                          <input type="number"  class="form-control" name="leaveDays" required value="<?php echo $row['total_days']; ?>">
                      </div> <br>
                        <div class="float-right">
                          <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                          <button type="submit" class="btn btn-success" name="editL">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
