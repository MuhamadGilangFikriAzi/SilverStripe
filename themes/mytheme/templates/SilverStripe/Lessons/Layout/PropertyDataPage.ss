<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    $Content
    <div class="container">
        <div class="row">
            <div id="baseUrl" data-url="{$BaseHref}property-data/"></div>

            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="margin-top: 50px">
                            <form id="search_field" method="POST">
                                <div class="col-sm-3">
                                    <input
                                        type="text"
                                        name="Address"
                                        class="form-control search"
                                        placeholder="Search Address..."
                                    />
                                </div>

                                <div class="col-sm-3">
                                    <input
                                        type="text"
                                        name="Phone"
                                        class="form-control search"
                                        placeholder="Search Phone..."
                                    />
                                </div>

                                <div class="col-sm-3">
                                    <input
                                        type="text"
                                        name="VendorName"
                                        class="form-control search"
                                        placeholder="Search Vendor Name..."
                                    />
                                </div>

                                <div class="col-sm-3">
                                    <input
                                        type="text"
                                        name="VendorPhone"
                                        class="form-control search"
                                        placeholder="Search Vendor Phone..."
                                    />
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    style="margin-left: 13px"
                                    data-toggle="modal"
                                    data-target="#addModal"
                                >
                                    Add
                                </button>

                                <button
                                    style="float: right; margin-right: 17px;"
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Search
                                </button>

                                <button type="button" class="btn btn-warning" style="float: right; margin-right: 17px" id="reset-form">
                                    Reset
                                </button>
                            </form>
                        </div>

                        <table
                            class="table table-responsive table-bordered"
                            style="margin-top: 50px"
                            id="table"
                        >
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Vendor Name</th>
                                    <th>Vendor Phone</th>
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
<div
    class="modal fade"
    id="addModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Add Property
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form Add PropertyData -->
            <form id="addProperty" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Address</label>
                        <input
                            type="text"
                            name="Address"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input
                            type="text"
                            name="Phone"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">FullAddress</label>
                        <textarea
                            name="AddressFull"
                            id=""
                            cols="10"
                            rows="4"
                            class="form-control"
                            required
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Vendor Name</label>
                        <input
                            type="text"
                            name="VendorName"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">Vendor Phone</label>
                        <input
                            type="text"
                            name="VendorPhone"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="CategoryID" class="form-control" required>
                            <option value="">-- Category --</option>
                            <% loop $getCategory %>
                            <option value="$ID">$Name</option>
                            <% end_loop %>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Facility</label>
                        <div class="optionset checkboxset">
                            <% loop getFacilityData %>
                            <div class="checkbox form-check">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        name="FacilityDataID[]"
                                        class="form-check-input"
                                        value="$ID"
                                    />
                                    $Name
                                </label>
                            </div>
                            <% end_loop %>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Photo</label>
                        <input
                            type="file"
                            name="Photo"
                            id="photo"
                            class="form-control form-control-file"
                        />
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Create
                    </button>
                </div>
            </form>
            <!-- End Form Add -->
        </div>
    </div>
</div>

<!-- Modal Edit-->
<div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Edit Property
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form edit PropertyData -->
            <form id="editProperty" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="hidden" name="id" id="editID" />
                        <input
                            type="text"
                            name="Address"
                            id="editAddress"
                            class="form-control"
                            required
                            value=""
                        />
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input
                            type="text"
                            name="Phone"
                            id="editPhone"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">FullAddress</label>
                        <textarea
                            name="AddressFull"
                            id="editFullAddress"
                            cols="10"
                            rows="4"
                            class="form-control"
                            required
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Vendor Name</label>
                        <input
                            type="text"
                            id="editVendorName"
                            name="VendorName"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">Vendor Phone</label>
                        <input
                            type="text"
                            id="editVendorPhone"
                            name="VendorPhone"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="">Category</label>
                        <select
                            name="CategoryID"
                            id="editCategoryID"
                            class="form-control"
                            required
                        >
                            <option value="">-- Category --</option>
                            <% loop $getCategory %>
                            <option value="$ID">$Name</option>
                            <% end_loop %>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Facility</label>
                        <div class="optionset checkboxset">
                            <% loop getFacilityData %>
                            <div class="checkbox form-check">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        name="editFacilityDataID[]"
                                        class="form-check-input editFacilityDataID"
                                        id="contoh$ID"
                                        value="$ID"
                                    />
                                    $Name
                                </label>
                            </div>
                            <% end_loop %>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Image</label>
                        <div class=""></div>
                        <img src="" alt="..." class="img-thumbnail img_edit"  data-toggle="modal" data-target="#imageEdit" style="width: 300px; height: 300px;">
                        <div class="modal fade" id="imageEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="" alt="..." class="img-thumbnail img_edit" style="width: 600px; height: 600px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="file" name="Photo" id="edit_image" class="form-control">

                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Create
                    </button>
                </div>
            </form>
            <!-- End Form edit -->
        </div>
    </div>
</div>

<script
    type="text/javascript"
    src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"
></script>
<script>
    var params = [];
    var table;
    var sorting = [];

    $(document).ready(function () {
        let url = $("#baseUrl").data("url");
        let param_asal = 1;

        //Search
        $("#search_field").submit(function (evt, ui) {
            evt.preventDefault();
            params = $(this).serialize();

            table.ajax.reload();
        });

        $('#reset-form').click(function(){

            $('#search_field').trigger('reset');
            $('#search_field').trigger('submit');

            table.ajax.reload();
        })
;
        //Create
        $("#addProperty").submit(function (evt, ui) {
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
                    $("#addProperty").trigger('reset');
                }
            });
        });

        //Delete
        $(document).on("click", ".delete", function (e) {
            e.preventDefault();

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );
                    var del = $(this).data("id");

                    $.ajax({
                        type: "post",
                        url: url + "delete",
                        data: { id: del },
                        dataType: "json",
                        success: function (response) {
                            table.ajax.reload();
                        },
                    });
                }
            })
        });

        //Edit Show
        $(document).on("click", ".edit", function (e) {
            // evt.preventDefault();
            modal = $("#editModal");
            var id = $(this).data("id");

            $.ajax({
                type: "POST",
                url: url + "getEdit",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    $(document).find("#editID").val(response.data.ID);
                    $(document).find("#editAddress").val(response.data.Address);
                    $(document)
                        .find("#editFullAddress")
                        .val(response.data.AddressFull);
                    $(document).find("#editPhone").val(response.data.Phone);
                    $(document)
                        .find("#editVendorName")
                        .val(response.data.VendorName);
                    $(document)
                        .find("#editVendorPhone")
                        .val(response.data.VendorPhone);
                    $(document)
                        .find("#editCategoryID")
                        .val(response.data.CategoryID);

                    let facilityData = response.data.FacilityData;

                    facilityData.forEach((element) => {
                        $("#contoh" + element).prop("checked", true);
                    });

                    let imageModal = document.querySelectorAll('.img_edit');
                    imageModal.forEach(element => {
                        element.src = response.data.FileURL;
                    });

                },
            });

            let facility = document.querySelectorAll(".editFacilityDataID");
            facility.forEach((element) => {
                element.checked = false;
            });
        });

        //Edit Submit
        $("#editProperty").submit(function (evt, ui) {
            evt.preventDefault();

            $.ajax({
                type: "post",
                url: url + "update",
                data: new FormData(this),
                enctype : 'multipart/form-data',
                processData : false,
                contentType : false,
                dataType: "json",
                success: function (data) {
                    let imageModal = document.querySelectorAll('.img_edit');
                    imageModal.forEach(element => {
                        element.src = data.data.FileURL;
                    });

                    $('#edit_image').val('');

                    table.ajax.reload();
                    alert(data.message);
                },
            });
        });

        //DataTable
        table = $("#table").DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: false,
            ordering: true,
            language: {
                decimal: "",
                emptyTable: "Tidak ada data di dalam table",
                info:
                    "Menampilkan _START_ - _END_ dari total _TOTAL_ data pada kolom _PAGE_ dari _PAGES_ kolom ",
                infoEmpty: "Data tidak ditemukan",
                infoFiltered: "(Mencari dari _MAX_ total data)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Menampilkan _MENU_ data",
                loadingRecords: "Loading...",
                processing: "Processing...",
                search: "Cari:",
                zeroRecords: "Tidak ada data yang ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: ">",
                    previous: "<",
                },
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending",
                },
            },
            order: [[1, "asc"]],
            ajax: {
                url: url + "getData",
                data: function (d) {
                    (d.filter_record = params), (d.sorting = sorting);
                },
                // "type" : "POST"
            },

            columnDefs: [
                {
                    // searchable: true,
                    orderable: false,
                    targets: [0,5],
                },
            ],
            deferRender: true,
        });
    });
</script>
