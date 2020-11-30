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

                                <button type="button" class="btn btn-sm btn-primary" style="margin-left: 13px;" data-toggle="modal" data-target="#addModal">
                                    Add
                                </button>
                                <button style="float: right; margin-right: 17px;" type="submit" class="btn btn-primary">Search</button>
                                <!-- <button type="button" class="btn btn-primary" id="test"></button> -->
                            </form>
                        </div>

                        <table class="table table-responsive table-bordered" style="margin-top: 50px;" id="table">
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
                    <label for="">Name</label>
                    <input type="text" name="Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="Address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="Phone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="">Price</label>
                    <input type="text" name="Salary" class="form-control" id="price" required>
                </div>
                <div class="form-group">
                    <label for="">PropertyData</label>
                    <select name="PropertyDataID" class="form-control" required>
                        <option value="">-- PropertyData --</option>
                        <% loop $getPropertyData %>
                            <option value="$ID">$Address</option>
                        <% end_loop %>
                    </select>
                </div>

                <div class="form-group">
                    <label for="photo">File</label>
                    <input type="file" name="file" class="form-control form-control-file" id="addPhoto">
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <label for="">Name</label>
                    <input type="hidden" name="ID" id="editID">
                    <input type="text" name="Name" class="form-control" required id="editName">
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="Address" class="form-control" required id="editAddress">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="Phone" class="form-control" required id="editPhone">
                </div>
                <div class="form-group">
                    <label for="">PropertyData</label>
                    <select name="PropertyDataID" class="form-control" required id="editPropertyDataID">
                        <option value="">-- PropertyData --</option>
                        <% loop $getPropertyData %>
                            <option value="$ID">$Address</option>
                        <% end_loop %>
                    </select>
                </div>
                < class="form-group">
                    <label for="file">File</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="#" target="_blank" class="btn btn-warning btn-block" id="downloadFile"><i class="fa fa-download"></i> Download File <span id="nameFile"></span></a>
                            </div>
                        </div>

                        </div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

            </form>
        <!-- End Form edit -->

        <!-- form dropzone -->
        <!-- <form action="{$BaseHref}agent-data-page/dropZone" class="dropzone" name="fomr2" id="dropZone">
            <div class="dz-default dz-message">
                <h3 class="sbold">Drop files here to upload</h3>
                <span>You can also click to open file browser</span>
            </div>
        </form> -->
      </div>
    </div>
  </div>

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
            <div class="dz-default dz-message">
                <h3 class="sbold">Drop files here to upload</h3>
                <span>You can also click to open file browser</span>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- $ThemeDir.debug -->
<script src="$ThemeDir/javascript/common/autoNumeric.js"></script>
<script>
    var params = [];
    var table;
    var sorting = [];

    // Dropzone.autoDiscover = false;

    $(document).ready(function () {

        const formatCur = {mDec:0, aSep:'.', aDec:','};

        $('#price').autoNumeric('init', formatCur);

        let url = $("#baseUrl").data("url");
        let param_asal = 1;

        // dropZone
        $(document).on('click','.image', function(e){
            var id = $(this).data('id');

            $(document).find('#hiddenID').val(id);
            $('#dropZone').trigger('reset');
        });

        //Search
        $("#search_field").submit(function(evt, ui)
        {
            evt.preventDefault();
            params = $(this).serialize();

            table.ajax.reload();
        });

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
                    alert(response.message);
                    $("#addAgent").trigger('reset');
                }
            });
        });

        //Delete
        $(document).on('click','.delete', function(e){
            e.preventDefault();

            var result = confirm('are you realy to delete this');
            if(result){
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
            }
        });


        //Edit Show
        $(document).on('click','.edit', function(e){
            // evt.preventDefault();
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
                    $(document).find('#editPropertyDataID').val(response.data.PropertyDataID);
                    $(document).find('#downloadFile').attr('href', response.data.File.URL);
                    $(document).find('#nameFile').html(response.data.File.Name);
                }
            });
        });

         //Edit Submit
         $("#editAgent").submit(function(evt, ui){
            evt.preventDefault();
            // alert('masuk');
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
                    alert(response.message);
                }
            });

        });

        //DataTable
        table = $('#table').DataTable({
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
                    "searchable": true,
                    "orderable": true,
                    "targets": -1,
                    // "defaultContent": "<button type='button' class='btn btn-danger'>delete</button>",
                } ],
                "deferRender" : true,
        });
    });

    function dropZone(id){
        $('#dropArea').dropzone({
            url:url+'dropZone?ID='+id,
            maxFiles:   1,
            uploadMultiple: false,
            autoProcessQueue:false,
            addRemoveLinks: true,
            init: function(){
                dzClosure = this;

                $('#addAgent').submit(function(e) {
                    dzClosure.processQueue(); /* My button isn't a submit */
                });

                // My project only has 1 file hence not sendingmultiple
                dzClosure.on('sending', function(data, xhr, formData) {
                    $('#addAgent input[type="text"],#addAgent textarea').each(function(){
                        formData.append($(this).attr('name'),$(this).val());
                    })
                });

                dzClosure.on('complete',function(){
                    window.location.href = url+'dropZone';
                })
            },
        });
    }

</script>
