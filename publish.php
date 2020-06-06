<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();

if(!$member_id=is_login($link)){
    skip('login.php','error','Please login in first');
}

if(isset($_POST['submit'])){
    include_once 'inc/check_publish.inc.php';
    $_POST=escape($link,$_POST);
    $query="insert into sfk_content(module_id,title,content,member_id,time) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',{$member_id},now())";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
		skip('publish.php','ok','publish successful');
		
    }else{
        skip('publish.php','error','Sorry please try again');
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
<link rel="stylesheet" type="text/css" href="style/public.css" />
<link rel="stylesheet" type="text/css" href="style/publish.css" />
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">SFK</div>
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
		 <a href="index.php">Home</a> &gt; Publish
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
                <?php
                $query="select * from sfk_father_module order by sort desc";
                $result_father=execute($link,$query);
                while($data_father=mysqli_fetch_assoc($result_father)){
                    echo "<optgroup label='{$data_father['module_name']}'>";
                    $query="select * from sfk_son_module where father_module_id={$data_father['id']} order by sort desc";
                    $result_son=execute($link,$query);
                    while($data_son=mysqli_fetch_assoc($result_son)){
						if(isset($_GET['son_module_id']) && $data_son['id']==$_GET['son_module_id']){
							echo "<option selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
						}else{
							echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
						}
                        
                    }
                    echo "</optgroup>";
                }
                ?>
			</select>
			<input class="title" placeholder="Please enter a title" name="title" type="text" />
			<textarea name="content" class="content"></textarea>
			<input class="publish" type="submit" name="submit" value="Submit" />
			<div style="clear:both;"></div>
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>sfk</a>
		</div>
		<div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
	</div>
</body>
</html>