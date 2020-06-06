<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if(!is_login_manage($link)){
    header('location:login.php');
}

session_unset();
session_destroy();
setcookie(session_name(),'',time()-3600,'/');
header('location:login.php');
?>