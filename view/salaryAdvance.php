<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
// include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <link rel="stylesheet" href="assets/css/pagination.css">

    <style media="screen">
    html,body{
      width: 100%;
      height: 100%;
      margin: 0px;
      padding: 0px;
      overflow-x: hidden;
    }

    .dataTables_length{
      position: absolute;
      top:50px;
      right:5px;
      margin-bottom: 10px
    }

    .dt-buttons{

    }


    .dataTables_filter{
      position: absolute;
      top:65px;
      left:15px;
    }

    .table-responsive{
      margin-top:60px;
    }

    .pagination{
      position: absolute;
      bottom: 10px;
      right: 15px;
    }

    .dataTables_info{
      margin-top: 10px;
    }

    .btn-sm{
      font-size: 13px;
    }

    .leave-rem{
      color:#343957;
      font-weight: bold;
    }

    .media{
      border: none !important;
    }

    .card-header:hover{
      background-color: #e0e0d1;
    }

    .reqHeading{
      font-weight: bold;
    }
    </style>

</head>

<body>

    <?php include('common/sidebar.php') ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('leave').className = 'active open';
      document.getElementById('leaveReq').className = 'active';
    </script>


    <?php include('common/header.php') ?>
    <!-- head bar -->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Employee Leave Requests</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Leave Management</a></li>
                                    <li class="breadcrumb-item myactive">Leave Requests</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="card">
                    <div class="card-title">
                        <h4>Leave Requests </h4>
                    </div>
                    <div class="recent-comment">
                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                      <!-- start first -->
                      <div class="card-header" role="tab" id="headingTwo1">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                          <div class="media" >
                              <div class="media-left">
                                  <img class="media-object" src="assets/images/user-1.png" alt="...">
                              </div>
                              <div class="media-body">
                                  <h4 class="media-heading">john doe</h4>
                                  <p>Casual Leave &nbsp - &nbsp to Attend an charity work in my village </p>
                                  <div class="comment-action">
                                      <div class="badge badge-success">Approved</div>
                                  </div>
                                  <p class="comment-date">October 21, 2017</p>
                              </div>
                          </div>
                        </a>
                      </div>
                      <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1" data-parent="#accordionEx1">
                        <div class="card-body" style="padding:10px;">
                          <div class="row">
                            <div class="col-lg-6">
                              <p class="reqHeading">Designation &nbsp &nbsp - <span style="font-weight:normal"> &nbsp Accountant (Finance Department)</span> </p>
                              <p class="reqHeading">Start Date &nbsp &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:80px !important;"> &nbsp 2022-01-12</span>End Date &nbsp &nbsp - <span style="font-weight:normal"> &nbsp 2022-01-13</span>  </p>
                              <p class="reqHeading">Duration &nbsp &nbsp  &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:100px !important;"> &nbsp Full Day</span> Status &nbsp &nbsp - <span style="font-weight:normal"> &nbsp Approved</span>  </p>
                            </div>
                            <div class="col-lg-6" >
                              <div class="float-right">
                                <a><button type="submit" class="btn-sm btn btn-warning" data-toggle="modal" data-target="#leaveApp">View</button></a>
                                <button class="btn-sm btn-success btn">Approve</button>
                                <button class="btn-sm btn-danger btn">Reject</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end first -->

                      <div class="card-header" role="tab" id="headingTwo2">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo21" aria-expanded="false" aria-controls="collapseTwo21">
                          <div class="media" >
                              <div class="media-left">
                                  <img class="media-object" src="assets/images/user-1.png" alt="...">
                              </div>
                              <div class="media-body">
                                  <h4 class="media-heading">john doe</h4>
                                  <p>Cras sit amet nibh libero, in gravida nulla.  Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </p>
                                  <div class="comment-action">
                                      <div class="badge badge-success">Approved</div>
                                  </div>
                                  <p class="comment-date">October 21, 2017</p>
                              </div>
                          </div>
                        </a>
                      </div>
                      <div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21" data-parent="#accordionEx1">
                        <div class="card-body" style="padding:10px;">
                          <div class="row">
                            <div class="col-lg-6">
                              <p class="reqHeading">Designation &nbsp &nbsp - <span style="font-weight:normal"> &nbsp Accountant (Finance Department)</span> </p>
                              <p class="reqHeading">Start Date &nbsp &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:80px !important;"> &nbsp 2022-01-12</span>End Date &nbsp &nbsp - <span style="font-weight:normal"> &nbsp 2022-01-13</span>  </p>
                              <p class="reqHeading">Duration &nbsp &nbsp  &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:100px !important;"> &nbsp Full Day</span> Status &nbsp &nbsp - <span style="font-weight:normal"> &nbsp Approved</span>  </p>
                            </div>
                            <div class="col-lg-6" >
                              <div class="float-right">
                                <a><button type="submit" class="btn-sm btn btn-warning" data-toggle="modal" data-target="#leaveApp">View</button></a>
                                <button class="btn-sm btn-success btn">Approve</button>
                                <button class="btn-sm btn-danger btn">Reject</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="card-header" role="tab" id="headingThree31">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseThree31" aria-expanded="false" aria-controls="collapseThree31">
                          <div class="media" >
                              <div class="media-left">
                                  <img class="media-object" src="assets/images/user-1.png" alt="...">
                              </div>
                              <div class="media-body">
                                  <h4 class="media-heading">john doe</h4>
                                  <p>Cras sit amet nibh libero, in gravida nulla.  Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </p>
                                  <div class="comment-action">
                                      <div class="badge badge-primary">Not Approved</div>
                                  </div>
                                  <p class="comment-date">October 21, 2017</p>
                              </div>
                          </div>
                        </a>
                      </div>
                      <div id="collapseThree31" class="collapse" role="tabpanel" aria-labelledby="headingThree31" data-parent="#accordionEx1">
                        <div class="card-body" style="padding:10px;">
                          <div class="row">
                            <div class="col-lg-6">
                              <p class="reqHeading">Designation &nbsp &nbsp - <span style="font-weight:normal"> &nbsp Accountant (Finance Department)</span> </p>
                              <p class="reqHeading">Start Date &nbsp &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:80px !important;"> &nbsp 2022-01-12</span>End Date &nbsp &nbsp - <span style="font-weight:normal"> &nbsp 2022-01-13</span>  </p>
                              <p class="reqHeading">Duration &nbsp &nbsp  &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:100px !important;"> &nbsp Full Day</span> Status &nbsp &nbsp - <span style="font-weight:normal"> &nbsp Approved</span>  </p>
                            </div>
                            <div class="col-lg-6" >
                              <div class="float-right">
                                <a><button type="submit" class="btn-sm btn btn-warning" data-toggle="modal" data-target="#leaveApp">View</button></a>
                                <button class="btn-sm btn-success btn">Approve</button>
                                <button class="btn-sm btn-danger btn">Reject</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div> </div>
                  </div>

                   <br><hr>

                   <div class="page-header">
                       <div class="page-title">
                           <h1>Leave Request Records</span></h1>
                       </div>
                   </div>
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Leave Requests</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Department <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Leave Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Start Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>End Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Duration <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Leave Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>Development</td>
                                            <td>Casual Leave</td>
                                            <td>15-01-2022</td>
                                            <td>15-01-2022</td>
                                            <td>Full Day</td>
                                            <td>Not Approved</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Finance</td>
                                            <td>Casual Leave</td>
                                            <td>15-01-2022</td>
                                            <td>15-01-2022</td>
                                            <td>Full Day</td>
                                            <td>Not Approved</td>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>Development</td>
                                            <td>Casual Leave</td>
                                            <td>15-01-2022</td>
                                            <td>15-01-2022</td>
                                            <td>Full Day</td>
                                            <td>Not Approved</td>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>Finance</td>
                                            <td>Casual Leave</td>
                                            <td>15-01-2022</td>
                                            <td>15-01-2022</td>
                                            <td>Full Day</td>
                                            <td>Not Approved</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>




                  <?php include('build/leaveApp.php') ?>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
