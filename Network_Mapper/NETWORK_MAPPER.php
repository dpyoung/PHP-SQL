<?php 
/************************************************************************
*
*	Index.php for default document. 
*		Periodically update objects on screen.
*
************************************************************************/

?><!DOCTYPE html>
<html lang="en">
<head>
<!-- Site Title-->
<title>Network Mapper</title>
<meta charset="utf-8" />
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="robots" content="noindex, nofollow" />
<meta name="description" content="Front Page of network mapper."  />
<meta name="keywords" content="two guys network mapper" />
<!-- <meta property="og:url" content="" /> -->
<meta property="og:type" content="website" />
<meta property="og:title" content="Two Guys and the Muscle" />
<meta property="og:description" content="A wonder of modern web engineering!" />
<?php if(file_exists("/nm_images/ogimage.jpg")){
?> <meta property="og:image" content="/nm_images/ogimage.jpg" /> <?php 
} ?>
<meta name="theme-color" content="#002699">
<?php if(file_exists("/nm_images/favicon.ico")){
?> <link rel="icon" href="/nm_images/favicon.ico" type="image/x-icon"> <?php 
} ?>
<!-- Stylesheets-->
<?php if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/style.php")){
	include($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/style.php");
} ?>
<style>
body{
	width:100%;
	margin:0;
	padding:0;
}
.progress{
	border-radius:0;
}
#myProgress {
	width: 100%;
	/*background-color: rgb(120,80,80);
	background-color: rgba(170,0,0,0.7);*/
	bottom:0;
	position:fixed;
}
#myBar {
	width: 1%;
	/*height: 8px;
	background-color: rgb(0,215,20);
	border-radius:8px 0 0 8px;*/
	transition:width .6s linear;
}
.node-entry{
	margin:0.5em;
	padding:1em;
}
.btn{
	margin-bottom:1em;
}
</style>
<!-- Javascript -->
<?php 
if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/headjavascript.php")){
	include($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/headjavascript.php");
} 
?>
</head>
<body class="body">
<?php 
if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/header.php")){
	include($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/header.php");
}
?>

<div class="container-fluid">
	<div class="row">
		<div id="nm_body_contents" class="col-sm-8 col-md-9" style="max-height:98vh;overflow-y:scroll;">
		<!-- THIS IS WHERE THE PAGE GOES    network-wired    sitemap  -->
		<?php 
		if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/ping_test.php")){
			include($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/ping_test.php");
		}
		?>
		</div>
		<div class="col-sm-4 col-md-3" style="max-height:98vh;overflow-y:scroll;background-color:#aaaaaa;">
			<h1>Welcome to the Network Status Monitor!</h1>
			<p>Here, you can add, edit, and delete nodes to be checked on your network.</p>
			<div id="editorForm" class="editorForm">
				<button class="btn btn-success createanode">Create Node</button>
			</div>
		</div>
		<div style="position:fixed;bottom:2em;right:2em;">
			<button class="btn btn-warning pingthenetwork"><i class="fas fa-broadcast-tower"></i></button>
			<button class="btn btn-green refreshapage"><i class="fas fa-sync fa-spin"></i></button><!-- fas fa-broadcast-tower -->
		</div>
	</div>
	
</div>

<div id="myProgress" class="progress" style="max-height:2vh;overflow:hidden;">
	<div id="myBar" class="progress-bar progress-bar-striped bg-info progress-bar-animated"></div>
</div>
<?php
if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/footer.php")){
	include($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/footer.php");
}

if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/javascript.php")){
	include($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/javascript.php");
}

if(file_exists("nm_includes/front_javascript.php")){
	include("nm_includes/front_javascript.php");
}
?>
</body>
</html>