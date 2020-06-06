<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('son_module.php','error','Sorry, please try it again');
}
$qeury="delete from sfk_son_module where id={$_GET['id']}";
execute($link,$qeury);
if(mysqli_affected_rows($link)==1){
    skip('son_module.php','ok','Congradtulation, delete sucessfully!');
}else{
    skip('son_module.php','error','Sorry, please try it again');
}
?>