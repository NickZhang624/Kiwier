<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('administrator.php','error','Sorry, please try it again');
}
$qeury="select kiwier_manage.level from kiwier_manage where id={$_SESSION['administrator']['id']}";
$result=execute($link,$qeury);
$data=mysqli_fetch_assoc($result);
if(mysqli_affected_rows($link)!==1){
    skip('administrator.php','error','Sorry, please try it again');
}else{
    if($data['level']==1){
        skip('administrator.php','error','Sorry, please contact one of super administrator to delete it');
    }
}


$qeury="delete from kiwier_manage where id={$_GET['id']}";
execute($link,$qeury);
if(mysqli_affected_rows($link)==1){
    skip('administrator.php','ok','Congratulation, delete sucessfully!');
}else{
    skip('administrator.php','error','Sorry, please try it again');
}
?>