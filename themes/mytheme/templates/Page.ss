<!DOCTYPE html>
<!--
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Simple. by Sara (saratusar.com, @saratusar) for Innovatif - an awesome Slovenia-based digital agency (innovatif.com/en)
Change it, enhance it and most importantly enjoy it!
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->
$MetaTags(false)
    <title>One Ring Rentals: $Title</title>

<!--[if !IE]><!-->
<html lang="$ContentLocale">
<!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    <link rel="shortcut icon" href="themes/simple/images/favicon.ico" />
    <!-- <% require javascript('//code.jquery.com/jquery-3.3.1.min.js') %> -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="$ThemeDir/javascript/dropzone-5.7.0/dist/basic.css">
    <link rel="stylesheet" href="$ThemeDir/javascript/dropzone-5.7.0/dist/dropzone.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="$ThemeDir/javascript/dropzone-5.7.0/dist/dropzone.css">

    <!-- <link rel="stylesheet" type="text/css" href="/public/DataTables-1.10.22/css/jquery.dataTables.min.css"/>

        <script type="text/javascript" src="/public/DataTables-1.10.22/js/jquery.dataTables.min.js"></script> -->

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="$ThemeDir/javascript/dropzone-5.7.0/dist/dropzone.js"></script>
        <script src="https://unpkg.com/imask"></script>

        <!-- Sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body class="$ClassName.ShortName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<% include Header %>
<div class="main" role="main">
    <div class="inner typography line">
        <div class="wrapper">
            <div class="content-wrapper">
                <section>
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <% include Banner %>
		                            $Layout
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
	</div>
</div>
<% include Footer %>

<% require themedJavascript('script') %>

</body>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

</html>


