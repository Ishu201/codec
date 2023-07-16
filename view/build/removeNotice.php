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
        title: 'Remove this Notice',
        text: "This Action Cannot be Undone..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          var noticeID = $(this).attr('data-id');
          $.ajax({
            type: "GET", //we are using GET method to get data from server side
            url: '/codec/view/operation/processnotice.php', // get the route value
            data: {notice_ID:noticeID}, //set data
            }).done(function (data) {
            console.log(data);

          swalWithBootstrapButtons2.fire(
            'Removed',
            'Notice is Successfully Removed',
            'success'
          ).then((result) => {
            location.href = 'notice.php';
          });

          });

        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons2.fire(
            'Cancelled',
            'Notice is Safe :)',
            'error'
          ).then((result)=>{
            location.href = 'notice.php';
          });
        }
      });
    });
  };
</script>
