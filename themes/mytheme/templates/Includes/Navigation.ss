
<div id="nav-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="index.html" class="nav-logo"><img src="images/logo.png" alt="One Ring Rentals" /></a>
                <!-- BEGIN SEARCH -->
                <div id="sb-search" class="sb-search">
                    <form>
                        <input class="sb-search-input" placeholder="Search..." type="text" value="" name="search" id="search">
                        <input class="sb-search-submit" type="submit" value="">
                        <i class="fa fa-search sb-icon-search"></i>
                    </form>
                </div>
                <!-- END SEARCH -->
                <!-- BEGIN MAIN MENU -->
                <nav class="navbar">
                    <button id="nav-mobile-btn"><i class="fa fa-bars"></i></button>

                    <ul class="nav navbar-nav">
                        <% loop $Menu(1) %>
                        <li class="$LinkingMode"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
                        <% end_loop %>
                    </ul>

                </nav>
                <!-- END MAIN MENU -->

            </div>
        </div>
    </div>
</div>
