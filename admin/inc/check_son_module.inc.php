<?php
if($_POST['father_module_id']<=0 or !is_numeric($_POST['father_module_id'])){
    if($check_flag=='add'){
        skip('son_module_add.php','error','Please choose a Main blcok!');
    }
    if($check_flag=='modify' || $_POST['father_module_id']=0){
        skip("son_module_update.php?id={$_GET['id']}",'error','Please choose a Main block!');
    }
}

//check main block if it is existed
if($check_flag=='add'){
    $query="select * from sfk_father_module where id='{$_POST['father_module_id']}'";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)==0){
	skip('son_module_add.php','error','Main block is not existed!');
    }
}

//check second block if it is existed
if($check_flag=='add'){
    $_POST=escape($link,$_POST);
    $query="select * from sfk_son_module where module_name='{$_POST['module_name']}'";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)){
	skip('son_module_add.php','error','Second block name is already existed!');
    }
}

if(empty($_POST['module_name'])){
    if($check_flag=='add'){
        skip('son_module_add.php','error','Please enter your block name!');
    }
    if($check_flag=='modify'){
        skip("son_module_update.php?id={$_GET['id']}",'error','Please enter your block name!');
    }
}

//get string length
if(mb_strlen($_POST['module_name'])>80){
    if($check_flag=='add'){
        skip('son_module_add.php','error','Please do not over 80 characters！');
    }
    if($check_flag=='modify'){
        skip("son_module_update.php?id={$_GET['id']}",'error','Please do not over 80 characters！');
    }
}

if(empty($_POST['info'])){
    if($check_flag=='add'){
        skip('son_module_add.php','error','Please input block information');
    }
    if($check_flag=='modify'){
        skip("son_module_update.php?id={$_GET['id']}",'error','Please enter your block information!');
    }
}

if(mb_strlen($_POST['info'])>255){
    if($check_flag=='add'){
        skip('son_module_add.php','error','Please do not over 255 characters！');
    }
    if($check_flag=='modify'){
        skip("son_module_update.php?id={$_GET['id']}",'error','Please do not over 255 characters！');
    }
}

if(!is_numeric($_POST['sort'])){
    if($check_flag=='add'){
        skip('son_module_add.php','error','sort is ONLY allowed put numbers!');
    }
    if($check_flag=='modify'){
        skip("son_module_update.php?id={$_GET['id']}",'error','sort is ONLY allowed put numbers!');
    }
}

if($check_flag=='modify'){
    // check new data whether it is existed
    $_POST=escape($link,$_POST);
    $query="select * from sfk_son_module where father_module_id={$_POST['father_module_id']} and module_name ='{$_POST['module_name']}'";
    $result=execute($link,$query);
    //true
    if(mysqli_num_rows($result)){
        //check if user doesn't change data
        if($raw_data==array("id" => "{$_GET['id']}",
        "father_module_id" => "{$_POST['father_module_id']}",
        "module_name" => "{$_POST['module_name']}",
        "info" => "{$_POST['info']}",
        "member_id" => "{$_POST['member_id']}",
        "sort" => "{$_POST['sort']}")){
            skip("son_module.php",'ok','Updated Successfully!(No data changed)');
        }
    skip("son_module_update.php?id={$_GET['id']}",'error','Sorry, the Block name is already taken');
    }
    
    
}

?>