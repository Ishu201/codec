<div class="modal fade" id="editItem_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle1">Item Details</h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                  <?php if ((isset($_REQUEST['getid']))) { ?>
                    <form action="controller/itemcontroller.php?status=itemdataUpdate&id=<?php echo $_REQUEST['id'] ?>&name=<?php echo $_REQUEST['name'] ?>" method="post">
                      <input type="hidden" name="itemID" value="<?php echo $id_edit = $_REQUEST['getid'] ?>">
                      <?php
                        $result_edit = $obj->viewIndividual_ItemDataSelected($id_edit);
                        $row_edit = $result_edit->fetch_array();
                       ?>
                        <?php
                          $depID = $row_edit['allocation'];
                          $dept_name = $dept->viewDept_selected($depID);
                          $deptname = $dept_name->fetch_array();
                         ?>
                         <div class="form-group">
                             <label>Allocation <span style="color:red">*</span></label>
                             <select class="form-control" name="Allocation" required>
                               <option value="">Select a Department...</option>
                               <?php
                                 $sql_allcation = "SELECT allocation FROM item WHERE itemID='$id_edit'";
                                 $result_allcation = $con->query($sql_allcation);
                                 $row_allc = $result_allcation->fetch_array();
                                  $appear = '';
                                 while ($row_dept = $result_dept->fetch_array()) {
                                    if ($row_allc['allocation'] == $row_dept['deptName']) {
                                      echo '<option selected value="'.$row_dept['deptName'].'">'.$row_dept['deptName'].'</option>';
                                    }else{
                                      echo '<option value="'.$row_dept['deptName'].'">'.$row_dept['deptName'].'</option>';
                                    }

                                    if($row_allc['allocation'] != 'In the Stock'){
                                      $appear = 'yes';
                                    }else{
                                      $appear = 'no';
                                    }
                                 }
                               ?>

                               <?php
                                if ($appear == 'yes' ) {
                                  echo '<option value="In the Stock">In the Stock</option>';
                                } else{
                                  echo '<option selected value="In the Stock">In the Stock</option>';
                                }
                               ?>
                             </select>
                         </div>
                          <div class="form-group">
                              <label>Defects <span style="color:red">*</span></label>
                              <input type="text" value="<?php echo $row_edit['defects'] ?>" class="form-control" name="defects" required >
                          </div>
                        <div class="form-group">
                            <label>Quality <span style="color:red">*</span></label>
                            <input id="quality" type="number" max="100" min="0" value="<?php echo $row_edit['quality']; ?>"  class="form-control" name="quality" required onchange="reduce_val()">
                        </div>
                        <div class="form-group">
                            <label>Value <span style="color:red">*</span></label>
                            <input id="values" type="number" value="<?php echo $row_edit['value']; ?>" max="<?php echo $row_edit['value']; ?>" min="0"  class="form-control" name="value" required>
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
function reduce_val() {
  var qual = $("#quality").val();
  if (qual == '0') {
    $("#values").val('0');
  }
}
</script>
