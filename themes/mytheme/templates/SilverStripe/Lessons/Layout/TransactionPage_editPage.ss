<div class="content">
    $Content
	<div class="container">
		<div class="row">
            <div id="baseUrl" data-url="{$BaseHref}transaction/"></div>

            <%-- BEGIN MAIN CONTENT --%>

            <div class="main col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="margin-top: 50px;">
                            <div class="row">

                                <div class="col-sm-12" style="margin-top: 50px;">
                                    <label for="Edit">Edit</label>
                                    <br><br>
                                    <form id="edit" method="POST">
                                        <div class="card border-light mb-3">
                                            <div class="card-header">

                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="id" id="" value="$transaction.ID">
                                                <div class="form-group">
                                                    <label for="">Kode</label>
                                                    <input type="text" value="$transaction.Kode" readonly class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input type="text" name="Name" class="form-control" value="$transaction.Name">
                                                </div>

                                                <div class="form-group datepicker_wrapper">
                                                    <label for="">Date</label>
                                                    <input name="Date" class="datepicker form-control" value="$date" data-date-format="dd/mm/yyyy">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea name="Description" class="form-control" rows="5">$transaction.Description</textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card">
                                            <div class="card-header text-right" style="margin-bottom: 30px;">
                                                <button type="button" id="addDetail" class="text-right">Add</button>
                                            </div>

                                            <div class="card-body" id="detail">
                                                <% loop $detail %>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <select name="detail[$ID][ProductID]" class="form-control product">
                                                            $Top.renderProduct($ID)
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <input type="text" name="detail[$ID][Qty]" placeholder="Qty" value="$Qty" class="form-control text-right qty">
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" name="detail[$ID][Price]" readonly value="$Price" class="form-control price text-right" placeholder="Price">
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" name="detail[$ID][Subtotal]" readonly value="$Subtotal" class="form-control text-right subtotal" placeholder="Subtotal">
                                                    </div>

                                                    <div class="col-sm-1">
                                                        <button type="button" class="deleteDetail btn btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            <% end_loop %>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-sm-8 text-right">
                                                        <label for="">Total : </label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" readonly name="Total" value="$transaction.Total" class="form-control text-right" id="total">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="text-right">
                                            <button type="button" id="back">Back</button>
                                            <button type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>
<script>
    var params = [];
    var table;
    var sorting = [];
    let url = $("#baseUrl").data('url');

    var i = 0;

    $(document).ready(function () {

        $('#back').click(function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Save`,
                denyButtonText: `Don't save`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    update();
                    // Swal.fire('Saved!', '', 'success');
                    window.location.href = url;
                } else if (result.isDenied) {

                    Swal.fire('Changes are not saved', '', 'info');
                    window.location.href = url;
                }


            });

        });

        const formatCur = {mDec:0 , aSep:'.', aDec:',', asign:"Rp."};
            $('.qty').autoNumeric('init', formatCur);
            $('.subtotal').autoNumeric('init', formatCur);
            $('.price').autoNumeric('init', formatCur);
            $('#total').autoNumeric('init', formatCur);

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

        $('.datepicker').datepicker({
            autoclose: true
            // startDate: '-3d',
        });


        //Delete
        $(document).on('click','.delete', function(){
            // e.preventDefault();
            var id = $(this).data('id');
            var deleteURL = url+'delete';

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
                    $.ajax({
                        type: "POST",
                        url: deleteURL,
                        data: {'id' : id},
                        dataType: "json",
                        success: function (response) {
                            swalWithBootstrapButtons.fire(
                            'Deleted!',
                            response.message,
                            'success'
                            );
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

        $('#edit').submit(function (e) {
            e.preventDefault();

            update(this);
        });

        //Add detail
        $(document).on('click','#addDetail', function(){

            $('#detail').append(`
                <div class="row">
                    <div class="col-sm-3">
                        <select name="detail[${i}][ProductID]" class="form-control product">
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
                        <input type="text" name="detail[${i}][Subtotal]" readonly class="form-control text-right subtotal" placeholder="Subtotal">
                    </div>

                    <div class="col-sm-1">
                        <button type="button" class="deleteDetail btn btn-danger">Delete</button>
                    </div>
                </div>`
            );

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
                $(this).parent().parent().remove()

                total();

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
    });

    // to count subtotal
    function subtotal(data){
        const formatCur = {mDec:0 , aSep:'.', aDec:',', asign:"Rp."};

        var parent = data.parent().parent();
        var qty = parent.find('.qty').val().split('.').join('');
        var price = parent.find('.price').val().split('.').join('');
        var subtotal = Number(qty) * Number(price);

        // console.log(subtotal.toLocaleString('de-DE'));
        parent.find('.subtotal').val(formatNumber(subtotal));

        total();
    }

    // to count total
    function total(){
        let subtotal = document.querySelectorAll('.subtotal');
        var total = 0;
        subtotal.forEach(element => {

            total += Number(element.value.split('.').join(''));
        });

        document.querySelector('#total').value = formatNumber(total);
    }

    //make format Number
    function formatNumber(number){
        return number.toLocaleString('de-DE');
    }

    function update(param){
        $.ajax({
            type: "post",
            url: url+'update',
            data: new FormData(param),
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire(
                    'Saved',
                    response.message,
                    'success'
                );
                // $(this).trigger('reset');
            }
        });
    }

</script>


