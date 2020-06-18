<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
if(is_login_manage($link)){
    skip('father_module.php','error','You are already logged in! ');
}


if(isset($_POST['submit'])){
    include_once 'inc/check_login.inc.php';
    $_POST=escape($link,$_POST);
    $query="select * from kiwier_manage where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)==1){
        $data=mysqli_fetch_assoc($result);
        $_SESSION['administrator']['name']=$data['name'];
        $_SESSION['administrator']['pw']=sha1($data['pw']);
        $_SESSION['administrator']['id']=$data['id'];
        $_SESSION['administrator']['level']=$data['level'];
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
<link rel="stylesheet" type="text/css" href="style/login.css" />
</head>
<body>
	<div id="main">
		<div class="title">Administrator Login</div>
		<form method="post">
			<label>User Name:&nbsp;&nbsp;<input class="text" type="text" name="name" /></label>
			<label>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="text" type="password" name="pw" /></label>
			<label><input class="submit" type="submit" name="submit" value="Login In" /></label>
		</form>
	</div>
</body>
</html>