<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('father_module.php','error','Sorry, please try it again');
}
$qeury="select * from sfk_son_module where father_module_id={$_GET['id']}";
$result=execute($link,$qeury);
if(mysqli_num_rows($result)){
    skip('father_module.php','error','Sorry, please delete Second Blocks first');
}

$qeury="delete from sfk_father_module where id={$_GET['id']}";
execute($link,$qeury);
if(mysqli_affected_rows($link)==1){
    skip('father_module.php','ok','Congradtulation, delete sucessfully!');
}else{
    skip('father_module.php','error','Sorry, please try it again');
}
?>