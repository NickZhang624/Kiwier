<?php
if(empty($_POST['name'])){
    skip('login.php','error','Please enter user name!');
}
if(empty($_POST['pw'])){
    skip('login.php','error','Please enter your password!');
}
?>