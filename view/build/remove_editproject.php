<script type="text/javascript">
const classList1 = document.querySelectorAll(".sweet-message2");
  for (let i = 0; i < classList1.length; i++) {
    classList1[i].addEventListener("click", function() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success swal',
          cancelButton: 'btn btn-danger swal'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Remove This Document From this Project',
        text: "This Action Cannot be Undone..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var p_docID = $(this).attr('data-id');
          var projectID = $(this).attr('data-proj');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processmemberPrivil.php', // get the route value
            data: {pdocID:p_docID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons.fire(
            'Removed',
            'Document is Successfully Removed',
            'success'
          ).then((result) => {
            location.reload();
          });

          });
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Document is Safe :)',
            'error'
          )
        }
      });
    });
  };



const classList2 = document.querySelectorAll(".sweet-message");
  for (let i = 0; i < classList2.length; i++) {
    classList2[i].addEventListener("click", function() {
      const swalWithBootstrapButtons2 = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success swal',
          cancelButton: 'btn btn-danger swal'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons2.fire({
        title: 'Remove The Developer From this Project',
        text: "This Action Cannot be Undone..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var memberID = $(this).attr('data-id');
          var projectID = $(this).attr('data-project');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processmember.php', // get the route value
            data: {member_ID:memberID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Removed',
            'Developer is Successfully Removed',
            'success'
          ).then((result) => {
            location.reload();
          });

          });

        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons2.fire(
            'Cancelled',
            'Record is Safe :)',
            'error'
          )
        }
      });
    });
  };



  const classList4 = document.querySelectorAll(".sweet-message4");
    for (let i = 0; i < classList4.length; i++) {
      classList4[i].addEventListener("click", function() {
        const swalWithBootstrapButtons4 = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success swal',
            cancelButton: 'btn btn-danger swal'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons4.fire({
          title: 'Are you sure?',
          text: "You want to Remove this Task..!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Remove',
          cancelButtonText: 'Cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            var taskID = $(this).attr('data-id');
            var projectID = $(this).attr('data-project');
            $.ajax({
              type: "GET", //we are using GET method to get data from server side
              url: '/codec/view/operation/processmaintainP.php', // get the route value
              data: {task_ID:taskID}, //set data
              }).done(function (data) {
              console.log(data);

            swalWithBootstrapButtons4.fire(
              'Removed',
              'Developer is Successfully Removed',
              'success'
            ).then((result) => {
              location.href = 'editCProject.php?projectID='+projectID+'';
            });

            });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons4.fire(
              'Cancelled',
              'Task Record is Safe :)',
              'error'
            )
          }
        });
      });
    };



</script>
