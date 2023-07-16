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
        title: 'Are you sure?',
        text: "This Employee doesn't work with you Anymore..!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Removed',
            'Employee is Successfully Moved',
            'success'
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Employee Record is Safe :)',
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
          title: 'Are you sure?',
          text: "This Action Cannot be Undone..!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Remove',
          cancelButtonText: 'Cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            swalWithBootstrapButtons2.fire(
              'Removed',
              'Record is Successfully Removed',
              'success'
            )
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



    const classList3 = document.querySelectorAll(".sweet-message3");
      for (let i = 0; i < classList3.length; i++) {
        classList3[i].addEventListener("click", function() {
          const swalWithBootstrapButtons3 = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success swal',
              cancelButton: 'btn btn-danger swal'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons3.fire({
            title: 'Are you sure?',
            text: "You want to Remove this Record..!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Remove',
            cancelButtonText: 'Cancel',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              swalWithBootstrapButtons3.fire(
                'Removed',
                'Record is Successfully Moved',
                'success'
              )
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons3.fire(
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
              text: "You want to Remove this Record..!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Remove',
              cancelButtonText: 'Cancel',
              reverseButtons: true
            }).then((result) => {
              if (result.isConfirmed) {
                swalWithBootstrapButtons4.fire(
                  'Removed',
                  'Record is Successfully Moved',
                  'success'
                )
              } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons4.fire(
                  'Cancelled',
                  'Record is Safe :)',
                  'error'
                )
              }
            });
          });
        };




        const classList5 = document.querySelectorAll(".sweet-message5");
          for (let i = 0; i < classList5.length; i++) {
            classList5[i].addEventListener("click", function() {
              const swalWithBootstrapButtons5 = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success swal',
                  cancelButton: 'btn btn-danger swal'
                },
                buttonsStyling: false
              })

              swalWithBootstrapButtons5.fire({
                title: 'Are you sure?',
                text: "This Action Cannot be Undone..!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Remove',
                cancelButtonText: 'Cancel',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                  swalWithBootstrapButtons5.fire(
                    'Removed',
                    'Leave Data id Successfully Removed',
                    'success'
                  )
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons5.fire(
                    'Cancelled',
                    'Record is Safe :)',
                    'error'
                  )
                }
              });
            });
          };
