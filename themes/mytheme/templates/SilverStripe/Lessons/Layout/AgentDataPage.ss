<div class="content">
    $Content
	<div class="container">
		<div class="row">
            <div id="baseUrl" data-url="{$BaseHref}agent-data-page/"></div>

            <!-- BEGIN MAIN CONTENT -->

            <div class="main col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="margin-top: 50px;">
                            <form id="search_field" method="POST">

                                <div class="col-sm-4">
                                    <input type="text" name="Name" class="form-control search" placeholder="Search Name...">
                                </div>

                                <div class="col-sm-4">
                                    <input type="text" name="Address"  class="form-control search" placeholder="Search Address...">
                                </div>

                                <div class="col-sm-4">
                                    <input type="text" name="Phone" class="form-control search" placeholder="Search Phone...">
                                </div>

                                <button type="button" class="btn btn-sm btn-gray" style="margin-left: 13px;" data-toggle="modal" data-target="#addModal">
                                    Add
                                </button>
                                <button style="float: right; margin-right: 17px;" type="submit" class="btn btn-sm btn-gray">Search</button>
                                <button type="button" class="btn btn-sm btn-gray" style="float: right; margin-right: 17px" id="reset-form">
                                    Reset
                                </button>
                                <!-- <button type="button" class="btn btn-primary" id="test"></button> -->
                            </form>
                        </div>

                        <div class="table table-responsive">
                            <table class="table table-responsive table-hover" style="margin-top: 50px;" id="table">
                                <thead>
                                 <tr>
                                     <th>Name</th>
                                     <th>Address</th>
                                     <th>Phone</th>
                                     <th>PropertyData</th>
                                     <th>Action</th>
                                 </tr>
                                </thead>

                             </table>
                        </div>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>

  <!-- Modal Create-->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Agent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Form Add PropertyData -->
        <form id="addAgent" method="POST" name="form1" enctype="multipart/form-data">
            <div class="modal-body">

                <div class="form-group">
                    <label for="">Name <span class="text-danger">*</span></label>
                    <input type="text" name="Name" class="form-control" required minlength="8" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="">Address <span class="text-danger">*</span></label>
                    <input type="text" name="Address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="Phone" class="form-control phone" id="phone" required placeholder="+62-">
                </div>

                <div class="form-group">
                    <label for="">Price <span class="text-danger">*</span></label>
                    <input type="text" name="Salary" data-a-sign="Rp. " class="form-control text-right" id="price" required>
                </div>

                <div class="form-group">

                    <label for="">PropertyData <span class="text-danger">*</span></label>
                    <select name="PropertyDataID" data-live-search="true" class="form-control selectpicker" data-style="" required id="addProperty">
                        <option value="">-- Property Data --</option>
                        <% loop $getPropertyData %>
                            <option value="$ID">$Address</option>
                        <% end_loop %>
                    </select>
                </div>

                <div class="form-group">
                    <label for="photo">File <span class="text-danger">*</span></label>
                    <input type="file" name="file" class="form-control form-control-file" id="addPhoto">
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn modal-close btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
            </div>

        </form>
        <!-- End Form Add -->

      </div>
    </div>
  </div>

   <!-- Modal Edit-->
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Form edit Agent -->
                <form id="editAgent" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <input type="hidden" name="ID" id="editID">
                            <input type="text" name="Name" class="form-control" required id="editName">
                        </div>
                        <div class="form-group">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input type="text" name="Address" class="form-control" required id="editAddress">
                        </div>
                        <div class="form-group">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="Phone" class="form-control phone" required id="editPhone">
                        </div>
                        <div class="form-group">
                            <label for="">PropertyData <span class="text-danger">*</span></label>
                            <select name="PropertyDataID" data-live-search="true" class="form-control selectpicker" data-style="" required id="editPropertyDataID">
                                <option value="">-- PropertyData --</option>
                                <% loop $getPropertyData %>
                                    <option value="$ID">$Address</option>
                                <% end_loop %>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="#" target="_blank" class="btn btn-warning btn-block" id="downloadFile"><i class="fa fa-download"></i> Download File <span id="nameFile"></span></a>
                                </div>
                            </div>
                        </div>

                <!-- End Form edit -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn modal-close btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Edit -->

  <!-- Modal upload-->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">upload Property</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- form dropzone -->
        <form action="{$BaseHref}agent-data-page/dropZone" onchange="dropZone()" class="dropzone" name="fomr2" id="dropZone" method="GET">
            <input type="hidden" id="hiddenID" name="ID" value="tets">
            <div class="dz-default dz-message" >
                <h3 class="sbold">Drop files here to upload</h3>
                <span>You can also click to open file browser</span>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- $ThemeDir.debug -->

<script>
    var params = [];
    var table;
    var sorting = [];

    // set format for phone number
    var phone = document.querySelectorAll('.phone');
    var maskOptions = {
     mask: '+{62}-000-0000-000000'
    };

    phone.forEach(element => {
        var mask = IMask(element, maskOptions);
    });
    // end format for phone number


    $(document).ready(function () {

        let url = $("#baseUrl").data("url");
        let param_asal = 1;

        // set format number
        const formatCur = {mDec:0 , aSep:'.', aDec:',', asign:"Rp."};
        $('#price').autoNumeric('init', formatCur);
        // end format number

        //Select 2
        $('select').selectpicker('refresh');
        // End Select2

        // Reset button
        $('#reset-form').click(function(){
            $('#search_field').trigger('reset');
            $('#search_field').trigger('submit');
        })
        // End Reset button

        // dropZone
        $(document).on('click','.image', function(e){
            var id = $(this).data('id');

            $(document).find('#hiddenID').val(id);
            $('#dropZone').trigger('reset');
        });
        // end dropZone

        //Search
        $("#search_field").submit(function(evt, ui)
        {
            evt.preventDefault();
            params = $(this).serialize();

            table.ajax.reload();
        });
        //end Search

        //Create
        $("#addAgent").submit(function(evt, ui)
        {
            evt.preventDefault();
            $.ajax({
                type: "post",
                url: url+'store',
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function (response) {
                    table.ajax.reload();
                    Swal.fire(
                        'Saved',
                        'Your data has been saved.',
                        'success'
                    );
                    $("#addAgent").trigger('reset');
                }
            });
        });
        //end create

        //Delete
        $(document).on('click','.delete', function(e){
            e.preventDefault();

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
                var del = $(this).data('id');
                $.ajax({
                    type: "post",
                    url: url+"delete",
                    data: {"id" : del},
                    dataType: "json",
                    success: function (response) {
                        table.ajax.reload();
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
        // End delete

        //get data edit
        $(document).on('click','.edit', function(e){
            modal = $('#editModal');
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: url+'edit',
                data: {'id' : id},
                dataType: "json",
                success: function (response) {
                    $("#editFile").val('');

                    $(document).find('#editID').val(response.data.ID);
                    $(document).find('#editName').val(response.data.Name);
                    $(document).find('#editAddress').val(response.data.Address);
                    $(document).find('#editPhone').val(response.data.Phone);
                    $(document).find('#editPropertyDataID').selectpicker('val', response.data.PropertyDataID);
                    $(document).find('#downloadFile').attr('href', response.data.File.URL);
                    $(document).find('#nameFile').html(response.data.File.Name);
                }
            });
        });
        //end get data edit

         //Edit Submit
         $("#editAgent").submit(function(evt, ui){
            evt.preventDefault();

            edit = $(this).serialize();

            $.ajax({
                type: "post",
                url: url+'update',
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function (response) {
                    table.ajax.reload();
                    Swal.fire(
                        'Saved',
                        'Your data has been updated.',
                        'success'
                    );
                    $("#addAgent").trigger('reset');
                }
            });
        });
        // End Edit submit

        // when click upload
        $(document).on('click','.image', function(){
            $('.dz-image-preview').remove();
            $('.dz-message').remove();

            var id = $('#hiddenID').val();

            $.ajax({
                type: "get",
                url: url+'getDropZone',
                data: {'id' : id},
                dataType: "json",
                success: function (response) {

                    //show message if not have upload file before
                    if(response.data.length == 0){
                        $('#dropZone').append(`
                        <div class="dz-default dz-message">
                            <h3 class="sbold">Drop files here to upload</h3>
                            <span>You can also click to open file browser</span>
                        </div>`
                        );
                    }
                    let data = response.data;

                    data.forEach(element => {
                        $('#dropZone').append(`<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                            <div class="dv-images">
                                <img data-dz-thumbnail src="${element.URL}" alt="${element.Name}" style="width: 120px; height: 120px;">
                            </div>
                            <div class="dz-details">
                                <div class="dz-size">
                                    <span data-dz-size=""><strong>${element.Size}</strong></span>
                                </div>
                                <div class="dz-filename">
                                    <span data-dz-name="">${$element.Name}</span>
                                </div>
                            </div>
                            <div class="dz-progress">
                                <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                            </div>
                            <div class="dz-error-message">
                                <span data-dz-errormessage=""></span>
                            </div>
                            <div class="dz-success-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>Check</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="dz-error-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>Error</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>`
                        );
                    });
                }
            });
        });
        // End click upload

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
                "order": [[ 1, 'asc' ]],actionsBox,
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
    // End DataTable
</script>

