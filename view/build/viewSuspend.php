<?php if (isset($_REQUEST['id'])) {  ?>
<div class="modal fade" id="viewSuspend" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
    <div class="modal-content" >
      <div class="modal-header" style="background-color:#009999">
        <h5 class="modal-title" style="color:white">Disciplinary History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php
        $id_edit = $_REQUEST['id'];
        $get_sql = "SELECT * FROM `disciplinary` WHERE empID=".$id_edit." AND status='On' ORDER BY `disID` ASC";
        $result_desc = $con->query($get_sql);
       ?>
      <div class="modal-body" >
        <div class="row" style="padding:10px">
          <div class="col-lg-12" >
            <div class="table-responsive" style="margin-top:0px;padding:0px;">
                <table class="table table-bordered" >
                    <thead>
                        <tr style="border:1px solid #e4e6e8;background-color:#cccc">
                            <th>#</th>
                            <th>Action</th>
                            <th>Title</th>
                            <th>Reason</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        while ($row_desc = $result_desc->fetch_array()) {

                       ?>
                        <tr>
                            <td style="color:#333333"><?php echo $no; ?></td>
                            <td style="color:#333333"><?php echo $row_desc['type']; ?></td>
                            <td style="color:#333333"><?php echo $row_desc['title']; ?></td>
                            <td style="color:#333333"><?php echo $row_desc['description']; ?></td>
                            <td style="color:#333333"><?php echo $row_desc['date']; ?></td>
                        </tr>
                      <?php $no++; } ?>
                    </tbody>
                </table>
                </div></div>
            </div>
      </div>
    </div>
  </div>
</div> <br>
</div>
<?php } ?>
