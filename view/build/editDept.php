<div class="modal fade" id="editDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Department Details</h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                    <form action="controller/departmentcontroller.php?status=update" method="post">
                      <input type="hidden" name="deptID" value="<?php echo $id_edit = $_REQUEST['id'] ?>">
                        <?php
                          $result_edit = $obj->viewDept_selected($id_edit);
                          $row_edit = $result_edit->fetch_array();
                         ?>
                        <div class="form-group">
                            <label>Department Name <span style="color:red">*</span></label>
                            <input type="text" value="<?php echo $row_edit['deptName']; ?>" class="form-control" name="deptName" required readonly>
                        </div>
                        <div class="form-group">
                            <label>Department Head <span style="color:red">*</span></label>
                            <select class="form-control" id="empID" name="empID" required onchange="validateEdit(<?php echo $row_edit['empID']; ?>)">
                              <option value="">Select an Employee..</option>
                              <?php
                              $sql_emp = "SELECT * FROM employee WHERE empJobStatus='Working' AND deptID='$id_edit'";
                              $result_emp = $con->query($sql_emp);
                              while ($row_emp = $result_emp->fetch_array()) {
                                $eid = $row_emp['desigID'];
                                $get_sql = "SELECT * FROM `designation` WHERE desigID='$eid'";
                                $result_desc = $con->query($get_sql);
                                $row_desc = $result_desc->fetch_array();
                               ?>
                              <option style="text-transform:capitalize" <?php if($row_edit['empID'] == $row_emp['empID']) { echo 'selected'; } ?> value="<?php echo $row_emp['empID'] ?>"><?php echo $row_emp['empName']; ?> &nbsp - &nbsp (<?php echo $row_desc['designation']; ?>)</option>
                            <?php } ?>
                            </select>
                        </div> <br>
                        <div class="float-right">
                          <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                          <button type="submit" class="btn btn-success" id="btn" disabled>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  function validateEdit(thisval){
    var val = document.getElementById('empID').value
    if (val != thisval) {
      document.getElementById('btn').disabled = false;
    }
  }
</script>
