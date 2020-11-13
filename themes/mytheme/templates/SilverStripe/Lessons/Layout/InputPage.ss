

<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    $Content
	<div class="container">
		<div class="row">

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

                        <table class="table table-bordered" style="margin-top: 50px;">
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>

                            <tr>
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

                            </tr>

                            <% loop $show %>
                                <tr>
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
                        </table>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>
