<?php
if(empty($_POST['name'])){
    skip('manage_add.php','error','Please enter an administration name!');
}
if(mb_strlen($_POST['name'])>20){
    skip('manage_add.php','error','Please do not over 20 characters！');
}
if(empty($_POST['pw'])){
    skip('manage_add.php','error','Please enter a password!');
}
if(mb_strlen($_POST['pw'])<6){
    skip('manage_add.php','error','please enter at least 6 characters!');
}
if(mb_strlen($_POST['pw'])>20){
    skip('manage_add.php','error','please do not enter over 20 characters!');
}

$_POST=escape($link,$_POST);
    $query="select * from kiwier_manage where name='{$_POST['name']}'";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)){
	skip('manage_add.php','error','This name is already taken');
}
if(!isset($_POST['level'])){
    skip('manage_add.php','error','Please choose an administrator level');
}elseif($_POST['level']=='1'){
    $_POST['level']=1;
}elseif($_POST['level']=='2'){
    $_POST['level']=2;
}
?>