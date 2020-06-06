<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';

$query="select * from sfk_manage where id = {$_SESSION['administrator']['id']}";
$result=execute($link,$query);
$data=mysqli_fetch_assoc($result);

$query="select count(*) from sfk_father_module";
$count_father_module=num($link,$query);

$query="select count(*) from sfk_son_module";
$count_son_module=num($link,$query);

$query="select count(*) from sfk_content";
$count_content=num($link,$query);

$query="select count(*) from sfk_reply";
$count_reply=num($link,$query);

$query="select count(*) from sfk_member";
$count_member=num($link,$query);

$query="select count(*) from sfk_manage";
$count_manage=num($link,$query);
?>

<?php include 'inc/header.inc.php'?>
<div id="main">
	<div class="title">System Information</div>
	<div class="explain">
		<ul>
			<li>|- Hi，<?php echo $data['name']?></li>
            <li>|- Administration Level：<?php 
            if($_SESSION['administrator']['level']==2){
                echo 'Super Administrator';
            }else{
                echo 'Standard Administrator';
            }?> </li>
			<li>|- Create Time：<?php echo $data['create_time']?></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
            <li>|- Module(<?php echo $count_father_module?>)</li>
            <li>|- Submodule(<?php echo $count_son_module?>))</li>
            <li>|- Post(<?php echo $count_content?>))</li>
            <li>|- Reply(<?php echo $count_reply?>))</li>
            <li>|- Member(<?php echo $count_member?>))</li>
            <li>|- Administrator(<?php echo $count_manage?>)</li>             
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- Opreation System：<?php echo PHP_OS?> </li>
			<li>|- Server Software：<?php echo $_SERVER['SERVER_SOFTWARE']?> </li>
			<li>|- MySQL Version：<?php echo  mysqli_get_server_info($link)?></li>
			<li>|- Max Filesize：<?php echo ini_get('upload_max_filesize')?></li>
			<li>|- Memory Limitation：<?php echo ini_get('memory_limit')?></li>
		</ul>
	</div>
	
	<div class="explain">
		<ul>
			<li>|- Version：sfkbbs V1.0 </li>
			<li>|- Developer：Nick Zhang :))</li>
			<li>|- Website：<a target="_blank" href="../index.php">www.sifangku.com</a></li>
		</ul>
	</div>
</div>
</body>
</html>