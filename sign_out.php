<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
if(!$member_id=is_login($link)){
    skip('index.php','error','Please login in first');
}

setcookie('kiwier[name]','',time()-3600);
setcookie('kiwier[pw]', '',time()-3600);
skip('index.php','ok','Sign out successfully!');

?>