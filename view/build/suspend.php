<?php if (isset($_REQUEST['id'])) {  ?>
<div class="modal fade bd-example-modal-lg" id="suspendemployee" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php
        $id_edit = $_REQUEST['id'];
          $result_edit = $emp->viewEmp_selected($id_edit);
          $row_edit = $result_edit->fetch_array();
         ?>
        <h5 class="modal-title" id="exampleModalLongTitle">Disciplinary Record - <span style="font-weight:normal"><?php echo $row_edit['empName']; ?></span> </h5>
      </div>
      <div class="modal-body">
        <div style="margin:20px;">
            <div class="card-body">
                <div class="basic-form">
                  <form action="controller/employeecontroller.php?status=suspend" method="post">
                    <input type="hidden" name="empID" value="<?php echo $id_edit; ?>">

                      <div class="form-group">
                          <label>Disciplinary Action <span style="color:red">*</span> </label>
                          <?php
                            $get_sql = "SELECT * FROM `disciplinary` WHERE empID='$id_edit' AND status='On'";
                            $result_desc = $con->query($get_sql);
                            $row_desc = $result_desc->fetch_array();
                              $desc_rowcount= mysqli_num_rows($result_desc);
                           ?>

                           <?php
                           if ($desc_rowcount == '0') { ?>
                             <input type="text"  class="form-control" name="w_no" value="Verbal Warning 1" readonly>
                             <input type="hidden"  name="update_stat" value="v1">
                           </div>
                           <div class="form-group">
                               <label>Title <span style="color:red">*</span> </label>
                               <input type="text"  class="form-control" name="title" placeholder="Enter the Reason" required>
                           </div>
                           <div class="form-group">
                               <label>Details <span style="color:red">*</span></label>
                               <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" required></textarea>
                            </div><br>
                             <div class="float-right">
                               <button type="submit" class="btn btn-success">Warn Employee</button>
                              <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                             </div>

                           <?php }else{
                              if($row_desc['v2'] == '0'){
                                echo '<input type="text"  class="form-control" name="w_no" value="Verbal Warning 2" readonly>';
                               ?>
                               <input type="hidden" class="form-control"  name="update_stat" value="v2"><input type="hidden"  name="desc_id" value="<?php echo $row_desc['disID']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Title <span style="color:red">*</span> </label>
                                <input type="text"  class="form-control" name="title" placeholder="Enter the Reason"  value="<?php echo $row_desc['title'] ?>" >
                            </div>
                            <div class="form-group">
                                <label>Details <span style="color:red">*</span></label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" > <?php echo $row_desc['description']; ?></textarea>
                             </div><br>
                              <div class="float-right">
                                <button type="submit" class="btn btn-success">Warn Employee</button>
                                <a href="controller/employeecontroller.php?status=rem_suspend&disID=<?php echo $row_desc['disID']; ?>&emp_id=<?php echo $id_edit; ?>" class="btn btn-danger">End Warning</a>
                                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                              </div>


                            <?php }
                            else if ($row_desc['v3'] == '0') {
                              echo '<input type="text"  class="form-control" name="w_no" value="Verbal Warning 3" readonly>';
                             ?>
                             <input type="hidden"  name="update_stat" value="v3"><input type="hidden"  name="desc_id" value="<?php echo $row_desc['disID']; ?>">
                          </div>
                          <div class="form-group">
                              <label>Title <span style="color:red">*</span> </label>
                              <input type="text"  class="form-control" name="title" placeholder="Enter the Reason"  value="<?php echo $row_desc['title'] ?>" >
                          </div>
                          <div class="form-group">
                              <label>Details <span style="color:red">*</span></label>
                              <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" > <?php echo $row_desc['description']; ?></textarea>
                           </div><br>
                            <div class="float-right">
                              <button type="submit" class="btn btn-success">Warn Employee</button>
                              <a href="controller/employeecontroller.php?status=rem_suspend&disID=<?php echo $row_desc['disID']; ?>&emp_id=<?php echo $id_edit; ?>" class="btn btn-danger">End Warning</a>
                              <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>


                            <?php }
                            else if ($row_desc['w1'] == '0') { ?>
                              <input type="text"  class="form-control" name="w_no" value="Written Warning 1" readonly>
                              <input type="hidden"  name="update_stat" value="w1"><input type="hidden"  name="desc_id" value="<?php echo $row_desc['disID']; ?>">
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-4">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px;" readonly> <?php echo $row_desc['title']; ?></textarea>
                                </div>
                                <div class="col-lg-8">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" readonly> <?php echo $row_desc['description']; ?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                                <label>Message <span style="color:red">*</span></label>
                                <textarea name="warning" class="form-control" rows="3" placeholder="Warning Message" style="height:100px" required ></textarea>
                             </div><br>
                              <div class="float-right">
                                <button type="submit" class="btn btn-success">Send Warning</button>
                                <a href="controller/employeecontroller.php?status=rem_suspend&disID=<?php echo $row_desc['disID']; ?>&emp_id=<?php echo $id_edit; ?>" class="btn btn-danger">End Warning</a>
                                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                              </div>


                            <?php }
                            else if ($row_desc['w2'] == '0')  { ?>
                              <input type="text"  class="form-control" name="w_no" value="Written Warning 2" readonly>
                              <input type="hidden"  name="update_stat" value="w2"><input type="hidden"  name="desc_id" value="<?php echo $row_desc['disID']; ?>">
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-4">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px;" readonly> <?php echo $row_desc['title']; ?></textarea>
                                </div>
                                <div class="col-lg-8">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" readonly> <?php echo $row_desc['description']; ?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                                <label>Message <span style="color:red">*</span></label>
                                <textarea name="warning" class="form-control" rows="3" placeholder="Warning Message" style="height:100px" required ></textarea>
                             </div><br>
                              <div class="float-right">
                                <button type="submit" class="btn btn-success">Send Warning</button>
                                <a href="controller/employeecontroller.php?status=rem_suspend&disID=<?php echo $row_desc['disID']; ?>&emp_id=<?php echo $id_edit; ?>" class="btn btn-danger">End Warning</a>
                                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                              </div>


                            <?php }
                            else if ($row_desc['dem'] == '0')  { ?>
                              <input type="text"  class="form-control" name="w_no" value="Demotion" readonly>
                              <input type="hidden"  name="update_stat" value="dem"><input type="hidden"  name="desc_id" value="<?php echo $row_desc['disID']; ?>">
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-4">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px;" readonly> <?php echo $row_desc['title']; ?></textarea>
                                </div>
                                <div class="col-lg-8">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" readonly> <?php echo $row_desc['description']; ?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                                <label>Message <span style="color:red">*</span></label>
                                <textarea name="warning" class="form-control" rows="3" placeholder="Warning Message" style="height:100px" required ></textarea>
                             </div><br>
                              <div class="float-right">
                                <button type="submit" class="btn btn-success">Send Warning</button>
                                <a href="controller/employeecontroller.php?status=rem_suspend&disID=<?php echo $row_desc['disID']; ?>&emp_id=<?php echo $id_edit; ?>" class="btn btn-danger">End Warning</a>
                                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                              </div>


                            <?php }
                            else if ($row_desc['sus'] == '0')  { ?>
                              <input type="text"  class="form-control" name="w_no" value="Suspend" readonly>
                              <input type="hidden"  name="update_stat" value="sus"><input type="hidden"  name="desc_id" value="<?php echo $row_desc['disID']; ?>">
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-4">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px;" readonly> <?php echo $row_desc['title']; ?></textarea>
                                </div>
                                <div class="col-lg-8">
                                  <textarea name="description" class="form-control" rows="3" placeholder="Further Description" style="height:100px" readonly> <?php echo $row_desc['description']; ?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                                <label>Message <span style="color:red">*</span></label>
                                <textarea name="warning" class="form-control" rows="3" placeholder="Warning Message" style="height:100px" required ></textarea>
                             </div><br>
                              <div class="float-right">
                                <button type="submit" class="btn btn-success">Suspend</button>
                                <a href="controller/employeecontroller.php?status=rem_suspend&disID=<?php echo $row_desc['disID']; ?>&emp_id=<?php echo $id_edit; ?>" class="btn btn-danger">End Warning</a>
                                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                              </div>

                            <?php } }?>

                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div> <br>
</div>

<?php } ?>
