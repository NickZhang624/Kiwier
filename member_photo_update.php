<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/photo_upload.php';

$link=connect();
if(!$member_id=is_login($link)){
    skip('login.php','error','Please login in first');
}
$query="select * from kiwier_member where id={$member_id}";
$result=execute($link,$query);
$data=mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
    $path='/opt/lampp/htdocs/kiwierbbs/style/';
    $upload=upload($path,'40M','photo');
    if($upload['return']){
        $query="update kiwier_member set photo='{$upload['path']}' where id={$member_id}";
        execute($link,$query);
        if(mysqli_affected_rows($link)==1){
            skip("member.php?id={$member_id}",'ok','upload sucessfully!'); 
        }else{
            skip('member_photo_update.php','error','Please try it again');  
        }
    }else{
        skip('member_photo_update.php','error',$upload['error']); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style/photo_update.css" />
</head>
<body>
	<div id="main">
		<h2>Change profile image</h2>
		<div>
            <h3>Original image：</h3>
            <?php
            if($data['photo']!='0'){
				$arr_path=explode('/',$data['photo']);
                $arr_path=$arr_path['5'].'/'.$arr_path['6'];
                echo "<img width='150' height='150' style='object-fit:contain'; src=$arr_path /> ";
			}else{
                echo "<img width='150' height='150' src='style/photo2.jpg' />";
            }
            ?>
			
		</div>
		<div style="margin:15px 0 0 0;">
			<form method="post" enctype="multipart/form-data">
				<input style="cursor:pointer;" width="100" type="file" name="photo"/><br /><br />
				<input class="submit" type="submit" value="Save" name="submit"/>
			</form>
		</div>
	</div>
</body>
</html>