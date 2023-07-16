<div class="modal fade" id="leaveApp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLongTitle">Assigned Leave Days</h6>
      </div>
      <div class="modal-body">
        <div >
            <div class="card-body">
              <div class="table">
                  <table style="width:100%;" class="table table-bordered">
                      <thead style="background-color:#d6d6d6;">
                          <tr>
                              <th>Type</th>
                              <th>Days</th>
                              <th>Remaining</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        $id= $_GET['id'];
                        $sql6 = "SELECT * FROM employee_leaves WHERE empID ='$id' AND stat='On'";
                        $result6 = $con->query($sql6);
                         $count = $result6->num_rows;
                         if ($count > 0) {
                           while ($row6 = $result6->fetch_array()) { ?>
                          <tr>
                            <th style="padding-left:20px;color:gray !important"><?php echo $row6['leaveID']; ?></th>
                              <td style="text-align:center;color:gray"><?php echo $row6['days']; ?></td>
                              <td style="text-align:center;color:gray"><?php echo $row6['days']-$row6['used']; ?></td>
                          </tr>
                        <?php } } else{ ?>
                        <td colspan="3"> There is No Leave Records</td>
                      <?php } ?>
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
