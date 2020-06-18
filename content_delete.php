<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	if(!is_login_manage($link)){
		skip('login.php','error','Please login in first');
	} 
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php','error','Sorry, please try it again');
}

$qeury="select member_id from kiwier_content where id={$_GET['id']}";
$result=execute($link,$qeury);
if(mysqli_num_rows($result)==1){
    $data=mysqli_fetch_assoc($result);
    if(check_user($member_id,$data['member_id']) || is_login_manage($link)){
        $qeury="delete from kiwier_content where id={$_GET['id']}";
        execute($link,$qeury);
        if(mysqli_affected_rows($link)==1){
            if(isset($_GET['return_url'])){
                skip($_GET['return_url'],'ok','delete successfully');
            }else{
                skip("member.php?id={$member_id}",'ok','delete successfully');
            }     
        }else{
            skip("member.php?id={$member_id}",'error','Sorry, please try it again');
        }
    }else{
        skip("member.php?id={$member_id}",'error','Sorry, you are not allow to delete this ');
    }
}else{
    skip('index.php','error','Sorry, wrong ID');
}

?>