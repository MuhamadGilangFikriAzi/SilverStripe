

<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    $Content
	<div class="container">
        <div class="row">

			<!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">
                <% if $MessageError %>
                    <% loop $MessageError %>
                        <div class="alert alert-danger" role="alert">
                            $MessageError
                        </div>
                    <% end_loop %>
                <% end_if %>
                <div class="card">
                    <div class="card-header">Input Client </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>

                            <% loop $data %>
                                <tr>
                                    <td>$Name</td>
                                    <td>$Address</td>
                                    <td><a href="$BaseHref/client/delete?id=$ID" class="btn btn-danger">Delete</a></td>
                                </tr>
                            <% end_loop %>
                        </table>

                    </div>
                </div>

                <div class="card" style="margin-top: 50px;">
                    <div class="card-header">Input Client</div>

                    <div class="card-body">
                        <form action="$BaseHref/client/store" method="POST" name="client" onsubmit="validateForm()">

                            <!-- Input Name -->
                            <div class="form-group">
                                <label>Name : </label>
                                <input type="text" name="name" class="form-control" placeholder="Input Name Here" required id="name">
                            </div>

                            <!-- Input Address -->
                            <div class="form-group">
                                <label>Address : </label>
                                <Textarea name="address" class="form-control" placeholder="Input Address Here" required id="address"></Textarea>
                            </div>

                            <div class="form-group text-right">
                                <button type="reset">Reset</button>
                                <button type="submit">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
			</div>

		</div>
	</div>
</div>

<script>
    $(document).ready(function () {
        function validateForm() {
            var name = document.forms["client"]["name"].value;
            console.log(name);
        }
    });
</script>
