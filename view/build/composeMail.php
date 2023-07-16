<div aria-hidden="true" role="dialog" tabindex="-1" id="composeMail" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-header-info" style="background-color:#343957">
            <h4 class="modal-title" style="color:white"><i class="ti-email"></i> &nbsp Compose Message</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:white;position:absolute;top:0px;right:0px;">X</button>
          </div>
          <div class="modal-body">
            <form action="controller/mailcontroller.php" method="post">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-2">
                      <label style="color:#343957;font-weight:bold"><i class="ti-user"></i> &nbsp To <span style="color:red">*</span> </label>
                    </div>
                    <div class="col-lg-9">
                      <input type="hidden" class="form-control"  name="mail_sender"  value="<?php echo $_SESSION['username']; ?>">
                      <select class="form-control" id="mail_receiver" name="mail_receiver" required>
                        <option value=""></option>
                        <?php
                          if ($empID == '1') { ?>
                            <option value="Accounts"  style="font-weight:bold !important">Accounts Department</option>
                            <option value="HR"  style="font-weight:bold !important">HR Department</option>
                            <option value="Development"  style="font-weight:bold !important">Development Department</option>
                          <?php } else if ($empID == '2') { ?>
                            <option value="Admin" style="font-weight:bold !important">Admin</option>
                            <option value="HR"  style="font-weight:bold !important">HR Department</option>
                            <option value="Development"  style="font-weight:bold !important">Development Department</option>
                          <?php } else if ($empID == '3') { ?>
                            <option value="Admin" style="font-weight:bold !important">Admin</option>
                            <option value="Accounts"  style="font-weight:bold !important">Accounts Department</option>
                            <option value="Development"  style="font-weight:bold !important">Development Department</option>
                          <?php } else if ($empID == '4') { ?>
                            <option value="Admin" style="font-weight:bold !important">Admin</option>
                            <option value="Accounts"  style="font-weight:bold !important">Accounts Department</option>
                            <option value="HR"  style="font-weight:bold !important">HR Department</option>
                          <?php } else{ ?>
                            <option value="Admin" style="font-weight:bold !important">Admin</option>
                            <option value="Accounts"  style="font-weight:bold !important">Accounts Department</option>
                            <option value="HR"  style="font-weight:bold !important">HR Department</option>
                            <option value="Development"  style="font-weight:bold !important">Development Department</option>
                            <?php }  ?>

                        <option disabled></option>
                        <?php
                          $sql1 = "SELECT * FROM employee WHERE empJobStatus='Working' AND empID!='$empID'";
                          $result1 = $con->query($sql1);
                          while ($row1 = $result1->fetch_array()) { ?>
                            <option value="<?php echo $row1['empEmail']; ?>" style="text-transform:capitalize"><?php echo $row1['empName']; ?></option>
                          <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-2">
                      <label style="color:#343957;font-weight:bold"><i class="ti-layout-cta-left"></i> &nbsp Subject <span style="color:red">*</span> </label>
                    </div>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject..">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label style="color:#343957;font-weight:bold"> &nbsp  &nbsp Message <span style="color:red">*</span> </label>
                  <div class="col-sm-12"><textarea class="form-control" name="message" rows="8" style="height:50% !important"></textarea></div>
                </div>

          </div>
          <div class="modal-footer" >
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left">Cancel</button>
                <!-- <button type="submit" name="draft" class="btn btn-warning"><i class="ti-cloud-down"></i> &nbsp Save Draft</button> -->
                <button type="submit" name="send" class="btn btn-success ">Send &nbsp<i class="ti-arrow-circle-right"></i></button>
          </div>
          </form>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
  <!-- /.modal-dialog -->
