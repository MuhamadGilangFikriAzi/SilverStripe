

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
                        <!-- <form action="$BaseHref/product/store" method="post" class="mb-4">

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

                        </form> -->

                        <div class="row" style="margin-top: 50px;">
                            <form id="search_field" method="POST">
                                <div class="col-sm-6">
                                    <input type="text" name="title"  class="form-control" placeholder="Search Title">
                                </div>

                                <div class="col-sm-6">
                                    <input type="number" name="price" class="form-control" placeholder="Search Price">
                                </div>

                                <button style="float: right;" type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>

                        <table class="table table-bordered" style="margin-top: 50px;" id="table">
                           <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                            </tr>
                           </thead>

                        </table>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    var params = [];
    var table;
    var sorting = [];
    $(document).ready(function () {
        let url = $("#baseUrl").data("url");

        let param_asal = 1;

        $("#search_field").submit(function(evt, ui)
        {
            evt.preventDefault();
            params = $(this).serialize();
            console.log(params);

            table.ajax.reload();
        });

        table = $('#table').DataTable({
            "processing" : true,
            "serverSide" : true,
            "paging" : true,
            "searching" : false,
            "ordering" : false,
            'language':{
                    "decimal":        "",
                    "emptyTable":     "Tidak ada data di dalam table",
                    "info":           "Menampilkan _START_ - _END_ dari total _TOTAL_ data dari _PAGE_ kolom dari _PAGES_",
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
                    data : function(d){
                        d.filter_record = params,
                        d.sorting = sorting
                    }
                    // "type" : "POST"
                },

                "columnDefs": [ {
                    "searchable": true,
                    "orderable": true,
                    "targets": 0
                } ],
                "deferRender" : true
        });
    });

</script>
