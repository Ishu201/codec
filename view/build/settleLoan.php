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
        title: 'Settle the Loan',
        text: "Make sure this Employee pays the whole Ammount..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Settle Loan',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var loanID = $(this).attr('data-id');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/settleLoan.php', // get the route value
            data: {loan_ID:loanID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Settled',
            'Loan is Completly settled',
            'success'
          ).then((result) => {
            location.href = 'loanData.php';
          });

          });

        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons2.fire(
            'Cancelled',
            'Loan is not Settled',
            'error'
          ).then((result)=>{

          });
        }
      });
    });
  };
</script>
