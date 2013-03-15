<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reader</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/assets/css/reader.css" rel="stylesheet">

	<script type="text/javascript" src="/assets/js/jquery-2.0.0b2.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/assets/js/reader.js"></script>
	
  </head>

  <body>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <a class="brand" href="/feeds" style="margin:0">Reader</a>
    <div class="pull-right">
		<ul class="nav">
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php echo htmlentities(username()) ?>
				<img src="http://www.gravatar.com/avatar/<?php echo trim(strtolower(md5(useremail()))) ?>?s=40" height="20" width="20" style="border-radius:2px;" alt="" />
			  <b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="/import">Import Feeds</a></li>
				<li><a href="/logout">Logout</a></li>
			</ul>
		  </li>
		</ul>
    </div>
  </div>
</div>



<div class="container-fluid">
	<div class="row-fluid">
		
