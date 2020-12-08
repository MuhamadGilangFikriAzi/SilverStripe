function alertDelete(url, id, reload) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            alert('masuk');
            $.ajax({
                type: "POST",
                url: url,
                data: { 'id': id },
                dataType: "json",
                success: function (response) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    );

                    reload
                }
            });

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        }
    });
});

    // const swalWithBootstrapButtons = Swal.mixin({
    //     customClass: {
    //         confirmButton: 'btn btn-success',
    //         cancelButton: 'btn btn-danger'
    //     },
    //     buttonsStyling: false
    //     })

    //     swalWithBootstrapButtons.fire({
    //     title: 'Are you sure?',
    //     text: "You won't be able to revert this!",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonText: 'Yes, delete it!',
    //     cancelButtonText: 'No, cancel!',
    //     reverseButtons: true
    //     }).then((result) => {
    //         if (result.isConfirmed) {

    //             $.ajax({
    //                 type: "POST",
    //                 url: url,
    //                 data: {'id' : id},
    //                 dataType: "json",
    //                 success: function (response) {
    //                     reload

    //                     swalWithBootstrapButtons.fire(
    //                     'Deleted!',
    //                     response.message,
    //                     'success'
    //                     );
    //                 }
    //             });

    //         } else if (
    //             /* Read more about handling dismissals below */
    //             result.dismiss === Swal.DismissReason.cancel
    //         ) {
    //             swalWithBootstrapButtons.fire(
    //             'Cancelled',
    //             'Your imaginary data is safe :)',
    //             'error'
    //             )
    //         }
    //     });
}
