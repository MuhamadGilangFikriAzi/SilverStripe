

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
                        <form action="http://localhost/my-project2/product/store" method="post">

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

                        <table class="table table-hover">
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                            </tr>
                            <% loop $product %>
                                <tr>
                                    <td>
                                        $Title
                                    </td>
                                    <td>
                                        $Price
                                    </td>
                                </tr>
                            <% end_loop %>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                            </tr>
                            <% loop $show %>
                                <tr>
                                    <td>$Title</td>
                                    <td>$Price</td>
                                </tr>
                            <% end_loop %>
                        </table>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>
