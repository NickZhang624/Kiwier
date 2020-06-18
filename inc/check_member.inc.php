<?php
if(empty($_POST['name'])){
    skip('register.php','error','Please enter user name!');
}
if(empty($_POST['pw'])){
    skip('register.php','error','Please enter your password!');
}
if(empty($_POST['confirm_pw'])){
    skip('register.php','error','Please confirm your password!');
}
if(empty($_POST['vcode'])){
    skip('register.php','error','Please enter validation code!');
}
if(mb_strlen($_POST['name'])>30){
    skip('register.php','error','Please do not over 30 characters！');
}
if(mb_strlen($_POST['pw'])>20){
    skip('register.php','error','Please do not over 20 characters！');
}
if(mb_strlen($_POST['confirm_pw'])>20){
    skip('register.php','error','Please do not over 20 characters！');
}
if($_POST['pw']!=$_POST['confirm_pw']){
    skip('register.php','error','Different passwords entered!');
}
if(strtolower($_POST['vcode'])!= strtolower($_SESSION['vcode'])){
    skip('register.php','error','Please re-enter validation code');
}
$_POST=escape($link,$_POST);
$query="select * from kiwier_member where name='{$_POST['name']}'";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
    skip('register.php','error','Sorry user name is already taken, please enter another name');
}
?>