<script type="text/javascript">
const classList3 = document.querySelectorAll(".sweet-message2");
  for (let i = 0; i < classList3.length; i++) {
    classList3[i].addEventListener("click", function() {
      const swalWithBootstrapButtons2 = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success swal',
          cancelButton: 'btn btn-danger swal'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons2.fire({
        title: 'Are you sure?',
        text: "You Need to Remove this Document..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var docID = $(this).attr('data-id');
          var empID = $(this).attr('data-emp');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processdoc.php', // get the route value
            data: {doc_ID:docID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Removed',
            'Document is Successfully Removed',
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
            'Document is Safe :)',
            'error'
          )
        }
      });
    });
  };
</script>
