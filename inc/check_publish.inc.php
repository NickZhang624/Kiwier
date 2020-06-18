<?php
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
    skip('publish.php','error','Please try again');
}
$query="select * from kiwier_son_module where id={$_POST['module_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('publish.php','error','Please try again');
}

if(empty($_POST['title'])){
    skip('publish.php','error','Please enter a title');
}
if(mb_strlen($_POST['title'])>88){
    skip('publish.php','error','Please do not enter over 88 characters');
}

if(empty($_POST['content'])){
    skip('publish.php','error','Please describe your question');
}

?>