<script type="text/javascript">
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
        title: 'Remove this Leave Type',
        text: "This Leave type will be Deactivated..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Deactive',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var leaveID = $(this).attr('data-id');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processlt.php', // get the route value
            data: {leave_ID:leaveID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Deactivated',
            'Leave Type is Successfully Deactivated',
            'success'
          ).then((result) => {
            location.href = 'leaveTypes.php';
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
          ).then((result)=>{
            location.href = 'leaveTypes.php';
          });
        }
      });
    });
  };

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
          title: 'Active This Leave Type',
          text: "This Leave type will be Restored..!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Activate',
          cancelButtonText: 'Cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            var leaveID = $(this).attr('data-id');
            $.ajax({
              type: "GET", //we are using GET method to get data from server side
              url: '/codec/view/operation/processlt2.php', // get the route value
              data: {leave_ID:leaveID}, //set data
              }).done(function (data) {
              console.log(data);

            swalWithBootstrapButtons.fire(
              'Activated',
              'Leave Type is Successfully Activated',
              'success'
            ).then((result) => {
              location.href = 'leaveTypes.php';
            });

            });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Record is Safe :)',
              'error'
            )
          }
        });
      });
    };

</script>
