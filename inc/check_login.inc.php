<?php
if(empty($_POST['name'])){
    skip('login.php','error','Please enter user name!');
}
if(empty($_POST['pw'])){
    skip('login.php','error','Please enter your password!');
}
if(empty($_POST['vcode'])){
    skip('login.php','error','Please enter validation code!');
}
if(empty($_POST['time']) || !is_numeric($_POST['time']) || $_POST['time']>2592000){
    $_POST['time']=2592000;
}
if(strtolower($_POST['vcode'])!= strtolower($_SESSION['vcode'])){
    skip('login.php','error','Please re-enter validation code');
}


?>