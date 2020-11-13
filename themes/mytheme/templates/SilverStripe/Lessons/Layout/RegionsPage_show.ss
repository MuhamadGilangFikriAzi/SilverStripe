<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">$Title</h1>

                <div class="breadcrumb">
                    $Breadcrumbs
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->


<!-- BEGIN CONTENT -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="main col-sm-8">
                <!-- $Region.debug()					 -->
                <% with $Region %>
                <div class="blog-main-image">
                    $Photo
                </div>
                $Description
                <% end_with %>
            </div>

            <div class="sidebar gray col-sm-4">
                <h2 class="section-title">Regions</h2>
                <ul class="categories subnav">
                    <% loop $Regions %>
                        <li class="$LinkingMode"><a class="$LinkingMode" href="$Link">$Title</a>></li>
                    <% end_loop %>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->


