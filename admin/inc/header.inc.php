<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Management Panel</title>
<meta name="keywords" content="Management Panel" />
<meta name="description" content="Management Panel" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
</head>
<body>
<div id="top">
	<div class="logo">
		Control
	</div>
	<!-- <ul class="nav">
		<li><a href="http://www.sifangku.com" target="_blank">私房库</a></li>
		<li><a href="http://www.sifangku.com" target="_blank">私房库</a></li>
	</ul> -->
	<div class="login_info">
		<a href="../index.php" target="_blank" style="color:#fff;">Website Homepage</a>&nbsp;|&nbsp;
		Administrator: <?php echo $_SESSION['administrator']['name']?> <a href="logout.php">[Sign Out]</a>
	</div>
</div>
<div id="sidebar">
	<ul>
		<li>
			<div class="small_title">System</div>
			<ul class="child">
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='index.php'){echo 'class="current"';} ?>  href="index.php">System Info</a></li>
				<?php
				if($_SESSION['administrator']['level']==2){
				?>
<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='administrator.php'){echo 'class="current"';} ?>  href="administrator.php">Administrator</a></li>
<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='manage_add.php'){echo 'class="current"';} ?>  href="manage_add.php">New Administrator</a></li>
				<?php
				}
				?>
			</ul>
		</li>
		<li>
			<div class="small_title">Content Panel</div>
			<ul class="child">
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){echo 'class="current"';} ?>  href="father_module.php">Modules</a></li>
				<?php
				if(basename($_SERVER['SCRIPT_NAME'])=='father_module_update.php'){
					echo '<li><a class="current";>Edit Module</a></li>';
				}
				?>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module_add.php'){echo 'class="current"';} ?> href="father_module_add.php">New Module</a></li>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module.php'){echo 'class="current"';} ?>  href="son_module.php">Submodule</a></li>
				<?php
				if(basename($_SERVER['SCRIPT_NAME'])=='son_module_update.php'){
					echo '<li><a class="current";>Edit Submodule</a></li>';
				}
				?>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module_add.php'){echo 'class="current"';} ?>  href="son_module_add.php">New Submodules</a></li>
				<li><a href="../index.php" target="_blank">Posts</a></li>
			</ul>
		</li>
		<li>
			<div class="small_title">User Panel</div>
			<ul class="child">
				<li><a href="#">User Lists</a></li>
			</ul>
		</li>
	</ul>
</div>