<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();

if($member_id=is_login($link)){
    skip('login.php','ok','R');
}
if(isset($_POST['submit'])){
include_once 'inc/check_member.inc.php';
$_POST=escape($link,$_POST);
$query="insert into sfk_member(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
    //check if user is login in 
    // setcookie('sfk[name]',$_POST['name']);
    // setcookie('sfk[pw]', sha1(md5($_POST['pw'])));
    skip('login.php','ok','Register successful');
}else {
    skip('register.php','error','Please register again');
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
			<div class="logo">SFK</div>
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
//                     <p>Hi, {$_COOKIE['sfk']['name']}</p> 
                    
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
		<h2>Hi, Welcome to SFK</h2>
		<form method="post">
			<label>User Name：<input type="text" name="name"  /><span>*Not Accept over 30 Characters</span></label>
			<label>Password：<input type="password" name="pw"  /><span>*Not Accept over 20 Characters</span></label>
			<label>Password：<input type="password" name="confirm_pw"  /><span>*Please Confirm Your Password</span></label>
			<label>Code: <input name="vcode" name="vcode" type="text"  /><span>*Validation code</span></label>
			<img class="vcode" src="show_code.php" />
			<div style="clear:both;"></div>
			<input class="btn" name="submit" type="submit" value="Sign Up" />
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>SFK</a>
		</div>
		<div class="copyright">Powered by sifangku ©2020 sifangku.com</div>
	</div>
</body>
</html>