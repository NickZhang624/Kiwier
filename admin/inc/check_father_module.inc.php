<?php
if(empty($_POST['module_name'])){
    if($check_flag=='add'){
        skip('father_module_add.php','error','Please enter your block name!');
    }
    if($check_flag=='modify'){
        skip("father_module_update.php?id={$_GET['id']}",'error','Please enter your block name!');
    }
}
//get string length
if(mb_strlen($_POST['module_name'])>80){
    if($check_flag=='add'){
        skip('father_module_add.php','error','Please do not over 80 characters！');
    }
    if($check_flag=='modify'){
        skip("father_module_update.php?id={$_GET['id']}",'error','Please do not over 80 characters！');
    }
}
if(!is_numeric($_POST['sort'])){
    if($check_flag=='add'){
        skip('father_module_add.php','error','sort is ONLY allowed put numbers!');
    }
    if($check_flag=='modify'){
        skip("father_module_update.php?id={$_GET['id']}",'error','sort is ONLY allowed put numbers!');
    }
}
//deliver a variable to check it is adding data or updating data
if($check_flag=='add'){
    $_POST=escape($link,$_POST);
    $query="select * from sfk_father_module where module_name='{$_POST['module_name']}'";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)){
	skip('father_module_add.php','error','This block name is already taken');
}
}
if($check_flag=='modify'){
    //check raw data if it is same with new data
    if($raw_data==$_POST['module_name']){
        skip("father_module.php",'ok','Updated Successfully!');
    }
    //check new data whether it is exist
    $_POST=escape($link,$_POST);
    $query="select * from sfk_father_module where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)){
    skip("father_module_update.php?id={$_GET['id']}",'error','This block name is already taken');
    }
    
}       

?>