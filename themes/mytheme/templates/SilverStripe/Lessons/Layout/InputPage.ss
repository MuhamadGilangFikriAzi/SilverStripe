

<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    $Content
	<div class="container">
		<div class="row">
            <div id="baseUrl" data-url="{$BaseHref}product/getData"></div>

			<!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">
                <div class="card">
                    <div class="card-header">Input Product $test</div>
                    <div class="card-body">
                        <form action="$BaseHref/product/store" method="post" class="mb-4">

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="Title" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Number</label>
                                <input type="number" name="Price" class="form-control">
                            </div>

                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>

                        </form>

                        <table class="table table-bordered" style="margin-top: 50px;" id="table">
                           <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                            </tr>
                           </thead>


                            <!-- <tr>
                                <form action="{$BaseHref}product/" method="GET">
                                    <td><input type="text" name="title" class="form-control"></td>
                                    <td><input type="number" name="price" class="form-control"></td>
                                    <td>
                                        <div class="form-group">
                                            <button type="reset" id="reset">reset</button>
                                            <button type="submit" class="btn btn-sm btn-info">Search</button>
                                        </div>

                                    </td>
                                </form>

                            </tr> -->
                            <!-- <tbody>
                                <% loop $show %>
                                <tr>
                                    <td>$Title</td>
                                    <td>$Price</td>
                                    <form action="{$BaseHref}product/update?ID=$ID" method="POST">
                                        <td><input type="text" name="title" class="form-control" value="$Title"></td>
                                        <td><input type="number" name="price" class="form-control" value="$Price"></td>
                                        <td>
                                            <div class="form-group">
                                                <a href="{$BaseHref}product/delete?ID=$ID" class="btn btn-sm btn-danger">Delete</a>
                                                <button type="submit" class="btn btn-info btn-sm">Edit</button></td>
                                            </div>
                                    </form>
                                </tr>
                            <% end_loop %>
                            </tbody> -->

                        </table>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        let url = $("#baseUrl").data("url");

        $('#table').DataTable({
            "processing" : false,
            "serverside" : true,
            'language':{
                    "decimal":        "",
                    "emptyTable":     "Tidak ada data di dalam table",
                    "info":           "Menampilkan _START_ - _END_ dari total _TOTAL_ data",
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
                    "url" : url,
                    "type" : "POST"
                },

                "columnDefs": [ {
                    "searchable": true,
                    "orderable": true,
                    "targets": 0
                } ],

        });
    });
</script>
