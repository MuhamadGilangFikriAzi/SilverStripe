
var params = [];
var table;
var sorting = [];
let url = $("#baseUrl").data('url');
const formatCur = {mDec:0 , aSep:'.', aDec:',', asign:"Rp."};
var i = 0;
$(document).ready(function () {

    $('input[type]')

    $('#create').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: url+'store',
            data: new FormData(this),
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {

                $(this).trigger('reset');
            }
        });
    });

    $(document).on('click','#addDetail', function(){

        $('#detail').append(`
            <div class="row">
                <div class="col-sm-3">
                    <select name="detail[${i}][ProductID]" id="" class="form-control product">
                        <option value="0">...</option>
                        <% loop $getProduct %>
                            <option value="$ID">$Name</option>
                        <% end_loop %>
                    </select>
                </div>

                <div class="col-sm-2">
                    <input type="text" name="detail[${i}][Qty]" placeholder="Qty" class="form-control text-right qty">
                </div>

                <div class="col-sm-3">
                    <input type="text" name="detail[${i}][Price]" readonly class="form-control price text-right" placeholder="Price">
                </div>

                <div class="col-sm-3">
                    <input type="text" name="detail[${i}][Subtotal]" readonly class="form-control text-right subtotal" placeholder="Subtotal" id="">
                </div>

                <div class="col-sm-1">
                    <button type="button" class="deleteDetail btn btn-danger"></button>
                </div>
            </div>`
        );
        i++;

        $('.qty').keyup(function (e) {
            subtotal($(this));
        });

        $('.product').change(function (e) {
            e.preventDefault();
            var id = $(this).val();
            let price = $(this).parent().parent().find('.price');
            let here = $(this);
            price.autoNumeric('init',formatCur);

            $.ajax({
                type: "get",
                url: url+'getPrice',
                data: {'id' : id},
                dataType: "json",
                success: function (response) {
                    price.val(response.data.Price);
                    subtotal(here);
                }
            });

        });
    });

    $(document).on('click', '.deleteDetail', function(){



    //DataTable
    table = $('#table').DataTable({
        "responsive": true,
        "processing" : true,
        "serverSide" : true,
        "paging" : true,
        "searching" : false,
        "ordering" : true,
        'language':{
                "decimal":        "",
                "emptyTable":     "Tidak ada data di dalam table",
                "info":           "Menampilkan _START_ - _END_ dari total _TOTAL_ data pada kolom _PAGE_ dari _PAGES_ kolom ",
                "infoEmpty":      "Data tidak ditemukan",
                "infoFiltered":   "(Mencari dari _MAX_ total data)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Menampilkan _MENU_ data",
                "loadingRecords": "Loading...",
                "processing":     "Processing...",
                "search":         "Cari:",
                "zeroRecords":    "Tidak ada data yang ditemukan",
                "paginate": {
                    "first":      "Pertama",
                    "last":       "Terakhir",
                    "next":       ">",
                    "previous":   "<"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            "order": [[ 1, 'asc' ]],
            "ajax" : {
                "url" : url+"getData",
                data : function(d){
                    d.filter_record = params,
                    d.sorting = sorting
                }
            },

            "columnDefs": [ {
                // "searchable": true,
                "orderable": false,
                "targets": [3,4],
                // "defaultContent": "<button type='button' class='btn btn-danger'>delete</button>",
            } ],
            "deferRender" : true,
    });

    });

    function alertSuccess(message) {
        Swal.fire(
            'Saved',
            message,
            'success'
        );
    }

    function alertDelete(confirm) {
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

                swalWithBootstrapButtons.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                );


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
}
