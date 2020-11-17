
<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">

				<!-- BEGIN PROPERTY LISTING -->
				<div id="property-listing" class="list-style clearfix"> <!-- Inject "grid-style1" for grid view-->
                    <div class="row">

                        <% loop $Results %>

                            <div class="item col-md-4">
                                <div class="image">
                                    $Image.Fill(760,670)
                                </div>
                                <div class="info">
                                    <h3>
                                        <a href="">$Name</a>
                                    </h3>
                                </div>
                            </div>
                            <% end_loop %>

					</div>
				</div>
				<!-- END PROPERTY LISTING -->


				<!-- BEGIN PAGINATION -->
                <% if $Results.MoreThanOnePage %>
                    <div class="pagination">
                        <% if $Results.NotFirstPage %>
                        <ul id="previous col-xs-6">
                            <li><a href="$Results.PrevLink"><i class="fa fa-chevron-left"></i></a></li>
                        </ul>
                        <% end_if %>
                        <ul class="hidden-xs">
                            <% loop $Results.Pages %>
                            <li <% if $CurrentBool %>class="active"<% end_if %>><a href="$Link">$PageNum</a></li>
                            <% end_loop %>
                        </ul>
                        <% if $Results.NotLastPage %>
                        <ul id="next col-xs-6">
                            <li><a href="$Results.NextLink"><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                        <% end_if %>
                    </div>
                <% end_if %>
                    <!-- END PAGINATION -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
	</div>
</div>
<!-- END CONTENT WRAPPER -->
