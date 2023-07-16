<script type="text/javascript">
const classList2 = document.querySelectorAll(".sweet-message1");
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
        text: "You want to Remove this Contact..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var recordID = $(this).attr('data-id');
          var empID = $(this).attr('data-emp');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processemp_contact.php', // get the route value
            data: {record_ID:recordID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Removed',
            'Contact Record is Successfully Removed',
            'success'
          ).then((result) => {
            location.href = 'editEmployee.php?id='+empID+'';
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
