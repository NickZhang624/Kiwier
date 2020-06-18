<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
if($member_id=is_login($link)){
    skip('index.php','ok','R');
}
if(isset($_POST['submit'])){
include_once 'inc/check_login.inc.php';
$_POST=escape($link,$_POST);
$query="select * from kiwier_member where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
$result=execute($link,$query);
if(mysqli_num_rows($result)==1){
    setcookie('kiwier[name]',$_POST['name'],time()+$_POST['time']);
    setcookie('kiwier[pw]', sha1(md5($_POST['pw'])),time()+$_POST['time']);
    skip('index.php','ok','Login in successful');
}else {
    skip('login.php','error','Sorry, Please enter your username and password');
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
<link rel="stylesheet" type="text/css" href="style/register.css" />
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">Kiwier</div>
			<div class="nav">
				<a class="hover" href="index.php">Home</a>
			</div>
			<div class="serarch">
				<form>
					<input class="keyword" type="text" name="keyword" placeholder="Search..." />
					<input class="submit" type="submit" name="submit" value="" />
				</form>
			</div>
			<div class="login">
			<?php
//                 if(isset($member_id) && $member_id){
// $str=<<<A
//                     <p>Hi, {$_COOKIE['kiwier']['name']}</p> 
                    
// A;
//                     echo $str;

//                 }else{
$str=<<<A
<a href="login.php">Login</a>&nbsp;
<a href="register.php">Sign</a>   

A;
echo $str;
                // }
                ?>
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>
	<div id="register" class="auto">
		<h2>Hi, Welcome to Kiwier</h2>
		<form method="post">
			<label>User Name*：<input type="text" name="name"  /><span></span></label>
			<label>Password*：<input type="password" name="pw"  /><span></span></label>
			<label>Code*: <input name="vcode" name="vcode" type="text"  /><span></span></label>
			<img class="vcode" src="show_code.php" />
            <label>Login Time：
				<select style="width:236px;height:25px;" name="time">
					<option value="3600">within 1 hour</option>
					<option value="86400">within 1 day</option>
					<option value="259200">within 3 days</option>
					<option value="2592000">within 30 days</option>
				</select>
				<span></span>
			</label>
			<div style="clear:both;"></div>
			<input class="btn" name="submit" type="submit" value="Login in" />
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>Kiwier</a>
		</div>
		<div class="copyright">Powered by Kiwier ©2020 kiwier.com</div>
	</div>
</body>
</html>