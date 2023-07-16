<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();
?>
<?php
if ($_SESSION['username'] == '') {
  $msg = base64_encode('Please Log in to the system..!');
  header("Location:../index.php?msg=$msg");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('common/files.php') ?>
  <link href="assets/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
  <link href="assets/css/lib/calendar/fullcalendar.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <style media="screen">
    .fc-right {
      display: none;
    }

    .fc-content {
      color: white !important;
    }

    .fc-scroller {
      overflow: hidden !important;
      height: 50% !important;
    }

    .fc-event {
      border: none !important;
      -webkit-box-shadow: 2px 4px 12px 2px rgba(0, 0, 0, 0.40);
      box-shadow: 2px 4px 12px 2px rgba(0, 0, 0, 0.40);
      padding: 3px;
    }

    th {
      text-align: center !important;
    }

    .fc-day-number {
      padding: 10px !important
    }

    .fc-day .fc-widget-content .fc-sun .fc-past {
      background-color: green !important;
    }
  </style>

</head>

<body>

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'HR') {
    include('common/HRsidebar.php');
  }
  ?>
  <!-- /# sidebar -->
  <script type="text/javascript">
    document.getElementById('leave').className = 'active open';
    document.getElementById('companyLeave').className = 'active';
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
                <h1>Company Leaves and Holiday Management</span></h1>
              </div>
            </div>
          </div>
          <!-- /# column -->
          <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
              <div class="page-title">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Leave Management</a></li>
                  <li class="breadcrumb-item myactive">Company Leaves</li>
                </ol>
              </div>
            </div>
            <a href='leaveTypes.php' style="float:right"><button type="submit" class="btn-sm btn btn-success">Add Leave Types</button></a>
          </div>
          <!-- /# column -->
        </div>

        <!-- /# row -->
        <section id="main-content">
          <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
              <div class="card">
                <div class="card-title">
                  <h4>Special Company Events</h4>
                  <p id="errors"></p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card-box">
                        <div id="calendar"></div>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
              <!-- /# card -->
            </div>
            <div class="col-lg-1"></div>
            <!-- /# column -->
          </div>


          <?php include('build/calanderEvent.php') ?>

          <?php include('common/footer.php') ?>
          <!-- footer -->

          <script src="assets/js/lib/jquery-ui/jquery-ui.min.js"></script>
          <script src="assets/js/lib/moment/moment.js"></script>
          <script src="assets/js/lib/calendar/fullcalendar.min.js"></script>


          <script type="text/javascript">
            ! function($) {
              "use strict";


              var defaultEvents = [{
                title: 'Hey!',
                start: '2022-06-08',
                end: '2022-06-09',
                className: 'bg-dark'
              }, ];

              const dateRegex = /^\d{4}-\d{2}-\d{2}$/;

              var keys = Object.keys(localStorage);
              keys.forEach(key => {
                var json_str = localStorage.getItem(key)
                try {
                  if (key.match(dateRegex)) {
                    // alert(key)
                    var abc = JSON.parse(json_str);
                    defaultEvents.push(abc);
                  } else {
                    // alert('nooooo')
                    localStorage.removeItem(date);
                  }
                } catch (e) {
                  console.log(e)
                }
              })


              var CalendarApp = function() {
                this.$body = $("body")
                this.$modal = $('#event-modal'),
                  this.$event = ('#external-events div.external-event'),
                  this.$calendar = $('#calendar'),
                  this.$saveCategoryBtn = $('.save-category'),
                  this.$categoryForm = $('#add-category form'),
                  this.$extEvents = $('#external-events'),
                  this.$calendarObj = null
              };


              /* on drop */
              CalendarApp.prototype.onDrop = function(eventObj, date) {
                  var $this = this;
                  // retrieve the dropped element's stored Event Object
                  var originalEventObject = eventObj.data('eventObject');
                  var $categoryClass = eventObj.attr('data-class');
                  // we need to copy it, so that multiple events don't have a reference to the same object
                  var copiedEventObject = $.extend({}, originalEventObject);
                  // assign it the date that was reported
                  copiedEventObject.start = date;
                  if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                  // render the event on the calendar
                  $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
                  // Date
                  var start_key = copiedEventObject.start;
                  var start_events = new Date(start_key);
                  let startdate = JSON.stringify(start_events)
                  startdate = startdate.slice(1, 11);
                  // title and class
                  var titleget = copiedEventObject['title'];
                  var classnameget = copiedEventObject['className'];

                  var newEvent = '{"title":"' + titleget + '", "start":"' + startdate + '", "className":"' + classnameget + '"}';
                  localStorage.setItem(startdate, newEvent);
                  // is the "remove after drop" checkbox checked?
                  if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    eventObj.remove();
                  }
                },

                // ------------------------usefull------------------------------------------------------------------------
                /* on click on event and removes it*/
                CalendarApp.prototype.onEventClick = function(calEvent, jsEvent, view) {
                  var $this = this;
                  var form = $("<form></form>");
                  form.append("<label>Modify the Event</label>");
                  form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>");
                  $this.$modal.modal({
                    backdrop: 'static'
                  });
                  $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').on("click", function() {
                    $this.$calendarObj.fullCalendar('removeEvents', function(ev) {
                      return (ev._id == calEvent._id);
                    });
                    $this.$modal.modal('hide');
                    var key = calEvent.start;
                    var events = new Date(key);
                    let date = JSON.stringify(events)
                    date = date.slice(1, 11);
                    localStorage.removeItem(date);
                  });
                  $this.$modal.find('form').on('submit', function() {
                    calEvent.title = form.find("input[type=text]").val();
                    $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                    $this.$modal.modal('hide');

                    // start Date
                    var start_key = calEvent.start;
                    var start_events = new Date(start_key);
                    let start_date = JSON.stringify(start_events)
                    start_date = start_date.slice(1, 11);
                    // end Date
                    var end_key = calEvent.end;
                    var end_events = new Date(end_key);
                    let end_date = JSON.stringify(end_events)
                    end_date = end_date.slice(1, 11);

                    var newEvent = '{"title":"' + calEvent.title + '", "start":"' + start_date + '","end":"' + end_key + '", "className":"' + calEvent.className + '"}'
                    var key = calEvent.start;
                    var events = new Date(key);
                    let date = JSON.stringify(events)
                    date = date.slice(1, 11);
                    localStorage.setItem(date, newEvent);
                    return false;
                  });
                },

                /* on select add event to the calander*/
                CalendarApp.prototype.onSelect = function(start, end, allDay) {
                  var $this = this;
                  $this.$modal.modal({
                    backdrop: 'static'
                  });
                  var form = $("<form></form>");
                  form.append("<div class='row'></div>");
                  form.find(".row")
                    .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Enter Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>")
                    .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>")
                    .find("select[name='category']")
                    .append("<option value='bg-danger'>Danger</option>")
                    .append("<option value='bg-success'>Success</option>")
                    .append("<option value='bg-dark'>Dark</option>")
                    .append("<option value='bg-info'>Info</option>")
                  $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').on("click", function() {
                    form.submit();
                  });
                  $this.$modal.find('form').on('submit', function() {
                    var title = form.find("input[name='title']").val();
                    var beginning = form.find("input[name='beginning']").val();
                    var ending = form.find("input[name='ending']").val();
                    var categoryClass = form.find("select[name='category'] option:checked").val();
                    if (title !== null && title.length != 0) {
                      $this.$calendarObj.fullCalendar('renderEvent', {
                        title: title,
                        start: start,
                        end: end,
                        allDay: false,
                        className: categoryClass
                      }, true);
                      $this.$modal.modal('hide');

                      var startdate = new Date(start); // Date 2011-05-09T06:08:45.178Z
                      var startyear = startdate.getFullYear();
                      var startmonth = ("0" + (startdate.getMonth() + 1)).slice(-2);
                      var startday = ("0" + startdate.getDate()).slice(-2);
                      var finalstart = startyear + '-' + startmonth + '-' + startday;

                      var enddate = new Date(end); // Date 2011-05-09T06:08:45.178Z
                      var endyear = enddate.getFullYear();
                      var endmonth = ("0" + (enddate.getMonth() + 1)).slice(-2);
                      var endday = ("0" + enddate.getDate()).slice(-2);
                      var finalend = endyear + '-' + endmonth + '-' + endday;

                      var newEvent = '{"title":"' + title + '", "start":"' + finalstart + '","end":"' + finalend + '", "className":"' + categoryClass + '"}'
                      localStorage.setItem(finalstart, newEvent);
                    } else {

                    }
                    return false;

                  });
                  $this.$calendarObj.fullCalendar('unselect');
                },

                // ------------------------usefull------------------------------------------------------------------------


                // not important
                CalendarApp.prototype.enableDrag = function() {
                  //init events
                  $(this.$event).each(function() {
                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                      title: $.trim($(this).text()) // use the element's text as the event title
                    };
                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);
                    // make the event draggable using jQuery UI
                    $(this).draggable({
                      zIndex: 999,
                      revert: true, // will cause the event to go back to its
                      revertDuration: 0 //  original position after the drag
                    });
                  });
                }


              /* Initializing the calander first view*/
              CalendarApp.prototype.init = function() {
                  this.enableDrag();
                  /*  Initialize the calendar  */
                  var date = new Date();
                  var d = date.getDate();
                  var m = date.getMonth();
                  var y = date.getFullYear();
                  var form = '';
                  var today = new Date($.now());

                  //defaultEvents

                  var $this = this;
                  $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '00:15:00',
                    /* If we want to split day time each 15minutes */
                    minTime: '08:00:00',
                    maxTime: '19:00:00',
                    defaultView: 'month',
                    defaultDate: '<?php echo date('Y-m-d'); ?>',
                    handleWindowResize: true,
                    height: $(window).height() - 200,
                    header: {
                      left: 'prev,next today',
                      center: 'title',
                      right: 'month,agendaWeek,agendaDay'
                    },
                    events: defaultEvents,
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    drop: function(date) {
                      $this.onDrop($(this), date);
                    },
                    select: function(start, end, allDay) {
                      $this.onSelect(start, end, allDay);
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                      $this.onEventClick(calEvent, jsEvent, view);
                    }

                  });

                  //on new event
                  this.$saveCategoryBtn.on('click', function() {
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                      $this.$extEvents.append('<div class="external-event bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
                      $this.enableDrag();
                    }

                  });
                },

                //init CalendarApp
                $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

            }(window.jQuery),

            //initializing CalendarApp
            function($) {
              "use strict";
              $.CalendarApp.init()
            }(window.jQuery);
          </script>


</body>

</html>