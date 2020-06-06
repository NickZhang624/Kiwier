<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();

if(!$member_id=is_login($link)){
    skip('login.php','error','Please login in first');
}

//check if content is existed
if(!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['quote_id']) || !is_numeric($_GET['quote_id'])){
    skip("show_content.php?id={$_GET['id']}",'error','Sorry this reply is not existed');
}
$query="select * from sfk_content,sfk_reply where sfk_content.id = {$_GET['id']} and sfk_reply.id={$_GET['quote_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this post is not existed');
}
$data_post=mysqli_fetch_assoc($result);
//convert any special characters to text that be showed in user page
$data_post['title']=htmlspecialchars($data_post['title']);
$data_post['content']=nl2br(htmlspecialchars($data_post['content']));


$query="select count(*) from sfk_reply where content_id={$_GET['id']} and id <={$_GET['quote_id']}";
$i=num($link,$query);

$query="select * from sfk_member where id = {$data_post['member_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this post is not existed');
}
$data_member=mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
include_once 'inc/check_reply.php';
$_POST=escape($link,$_POST);
$_SESSION['contents']=$_POST['content'];
$query="insert into sfk_reply(content_id,quote_id,content,time,member_id) values({$_GET['id']},{$_GET['quote_id']},'{$_POST['content']}',now(),{$member_id})";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
    unset($_SESSION['contents']);
    skip("show_content.php?id={$_GET['id']}",'ok','post successfully');
}else{
    skip($_SERVER['REQUEST_URI'],'error','Please try it again');
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
	<div id="publish">
		<div><?php echo $data_member['name']?>: <?php echo $data_post['title']?></div>
		<div class="quote">
			<p class="title">Quote #<?php echo $i?> <?php echo $data_member['name']?> replied: </p>
            <?php
            echo $data_post['content']
            ?>
		</div>
		<form method="post">
			<textarea name="content" class="content"></textarea>
			<input class="reply" type="submit" name="submit" value="submit" />
			<div style="clear:both;"></div>
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>SFK</a>
		</div>
		<div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
	</div>
</body>
</html>