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
        title: 'Are you sure?',
        text: "This Action Cannot be Undone..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var desigID = $(this).attr('data-id');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processdesig.php', // get the route value
            data: {desig_ID:desigID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Removed',
            'Designation is Successfully Removed',
            'success'
          ).then((result) => {
            location.href = 'designation.php';
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
</script>
