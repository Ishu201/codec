<div class="modal fade" id="editDesignationModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Designation Details</h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                    <form action="controller/designationcontroller.php?status=update" method="post">
                      <input type="hidden" name="desigID" value="<?php echo $id_edit = $_REQUEST['id'] ?>">
                      <?php
                        $result_edit = $desig->viewDesig_selected($id_edit);
                        $row_edit = $result_edit->fetch_array();
                       ?>
                        <div class="form-group">
                            <label>Designation Type <span style="color:red">*</span></label>
                            <input type="text" value="<?php echo $row_edit['designation']; ?>"  class="form-control" name="designation" required readonly>
                        </div>
                        <?php
                          $depID = $row_edit['deptID'];
                          $dept_name = $dept->viewDept_selected($depID);
                          $deptname = $dept_name->fetch_array();
                         ?>
                        <div class="form-group">
                            <label>Department <span style="color:red">*</span></label>
                            <input type="text" value="<?php echo $deptname['deptName']; ?>"  class="form-control" name="deptName" required readonly>
                        </div>
                        <div class="form-group">
                            <label>Salary <span style="color:red">*</span></label>
                            <input type="number" value="<?php echo $row_edit['basic_salary']; ?>"  class="form-control" name="salary" required>
                        </div>
                         <br>
                        <div class="float-right">
                          <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
