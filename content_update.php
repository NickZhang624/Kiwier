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

$qeury="select * from kiwier_content where id={$_GET['id']}";
$result=execute($link,$qeury);
if(mysqli_num_rows($result)==1){
	$data=mysqli_fetch_assoc($result);
	$data['title']=htmlspecialchars($data['title']);
	$data['content']=htmlspecialchars($data['content']);
    if(check_user($member_id,$data['member_id']) || is_login_manage($link)){
			if(isset($_POST['submit'])){
				include_once 'inc/check_update.php';
				$_POST=escape($link,$_POST);
				$query="update kiwier_content set module_id={$_POST['module_id']}, title='{$_POST['title']}', content='{$_POST['content']}' where id={$_GET['id']}";
				execute($link,$query);
				if(mysqli_affected_rows($link)==1){
					if(isset($_GET['R'])){
					skip($_GET['R'],'ok','update successfully');
					}else {
					skip("member.php?id={$data['member_id']}",'ok','update successfully');
					}
				}else{
					skip("content_update.php?id={$_GET['id']}",'error','Sorry, wrong ID');
				}
			}	
	}
	else{
        skip("member.php?id={$member_id}",'error','Sorry, you are not allow to delete this ');
	}
	


}else{
    skip('index.php','error','Sorry, wrong ID');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
<link rel="stylesheet" type="text/css" href="style/publish.css" />
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">Kiwier</div>
			<div class="nav">
				<a class="hover" href="index.php">Home</a>
			</div>
			<div class="serarch">
				<form>
					<input class="keyword" type="text" name="keyword" placeholder="Search..." />
					<input class="submit" type="submit" name="submit" value="" />
				</form>
			</div>
			<div class="login">
                <?php
                if($member_id){
$str=<<<A
<a target=_blank" href="member.php?id=$member_id">Hi, {$_COOKIE['sfk']['name']} </a><span style="color:white">|<span> <a href="sign_out.php">Sign out</a>
                    
A;
                    echo $str;

                }
                ?>
				
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>
	<div id="position" class="auto">
		 <a href="index.php">Home</a> &gt; Edit
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
                <?php
                $query="select * from kiwier_father_module order by sort desc";
                $result_father=execute($link,$query);
                while($data_father=mysqli_fetch_assoc($result_father)){
                    echo "<optgroup label='{$data_father['module_name']}'>";
                    $query="select * from kiwier_son_module where father_module_id={$data_father['id']} order by sort desc";
                    $result_son=execute($link,$query);
                    while($data_son=mysqli_fetch_assoc($result_son)){
						if($data_son['id']==$data['module_id']){
							echo "<option selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
						}else{
							echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
						}
                        
                    }
                    echo "</optgroup>";
                }
                ?>
			</select>
			<input class="title" placeholder="Please enter a title" name="title" type="text" value="<?php echo $data['title']?>"/>
			<textarea name="content" class="content" ><?php echo $data['content']?></textarea>
			<input class="publish" type="submit" name="submit" value="Submit" />
			<div style="clear:both;"></div>
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>Kiwier</a>
		</div>
		<div class="copyright">Powered by Kiwier ©2020 kiwier.com</div>
	</div>
</body>
</html>


