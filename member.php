<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();

$member_id=is_login($link);

//check if id is existed
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Sorry this user is not existed');
}
$query="select * from kiwier_member where id = {$_GET['id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this user is not existed');
}

$data_member=mysqli_fetch_assoc($result);

$query="select count(*) from kiwier_content where member_id = {$_GET['id']}";
$count_all=num($link,$query);

//set up image path
if($data_member['photo']!='0'){
$arr_path=explode('/',$data_member['photo']);
$arr_path=$arr_path['5'].'/'.$arr_path['6'];
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
<link rel="stylesheet" type="text/css" href="style/list.css" />
<link rel="stylesheet" type="text/css" href="style/member.css" />
<link rel="stylesheet" type="text/css" href="style/show.css" />
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
<a>Hi, {$_COOKIE['kiwier']['name']} </a><span style="color:white">|<span> <a href="sign_out.php">Sign out</a>
                    
A;
                    echo $str;

                }else{
$str=<<<A
<a href="login.php">Login</a>&nbsp;
<a href="register.php">Sign</a>  

A;
echo $str;
                }
                ?>
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>
<div id="position" class="auto">
	<a href="index.php">Home</a> &gt; <?php echo $data_member['name']?>
</div>
<div id="main" class="auto">
	<div id="left">
		<ul class="postsList">
			<?php 
			$page=page($count_all,4);
            $query="select kiwier_content.title,kiwier_content.id,kiwier_content.time,kiwier_content.numbers,kiwier_member.name,kiwier_member.photo,kiwier_content.member_id from 
            kiwier_content,kiwier_member where 
            kiwier_content.member_id={$_GET['id']} and 
            kiwier_content.member_id=kiwier_member.id order by id desc {$page['limit']}";
            $result_content=execute($link, $query);
			while($data_content=mysqli_fetch_assoc($result_content)){
				$data_content['title']=htmlspecialchars($data_content['title']);
				$query="select time from kiwier_reply where content_id={$data_content['id']} order by id desc limit 1";
				$result_last_reply=execute($link, $query);
				if(mysqli_num_rows($result_last_reply)==0){
					$last_time='No reply';
				}else{
					$data_last_reply=mysqli_fetch_assoc($result_last_reply);
					$last_time=$data_last_reply['time'];
				}
                $query="select count(*) from kiwier_reply where content_id={$data_content['id']}";
			?>
			<li>
				<div class="smallPic">
					<a href="#">
						<img width="45" height="45" style='object-fit:contain'; src="<?php if($data_content['photo']!=='0'){echo $arr_path;}else{echo 'style/photo1.jpg';}?>" />
					</a>
				</div>
				<div class="subject">
					<div class="titleWrap"><h2><a target="_blank" href="show_content.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
					<p>
					<?php if(check_user($member_id,$data_content['member_id'])){
						$delete_data=urldecode("content_delete.php?id={$data_content['id']}");
						$return_url=urldecode($_SERVER['REQUEST_URI']);
						$message="Do you want to delete {$data_content['title']}? ";
						$delete_rul="confirm.php?delete_data={$delete_data}&return_url={$return_url}&message={$message}";
						 
						echo "<a href='content_update.php?id={$data_content['id']}'>Edit</a> | <a href='$delete_rul'>Delete</a> |";

					}?>
					Date posted：<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;Last reply：<?php echo $last_time?>
					</p>
				</div>
				<div class="count">
					<p>
						reply<br /><span><?php echo num($link,$query)?></span>
					</p>
					<p>
						Views<br /><span><?php echo $data_content['numbers']?></span>
					</p>
				</div>
				<div style="clear:both;"></div>
			</li>
            <?php
        }
        ?>
        </ul>
    <div class="wrap1">
		<div class="pages">
			<?php 
			echo $page['html'];
			?>
        </div>
    </div>
	</div>
	<div id="right">
		<div class="member_big">
			<dl>
				<dt>
					<img width="180" height="180" style='object-fit:contain'; src="<?php if($data_member['photo']!=='0'){echo "$arr_path";}else{echo 'style/photo1.jpg';}?>" />
				</dt>
				<dd class="name"><?php echo $data_member['name']?></dd>
				<dd>Total posts：<?php echo $count_all?></dd>
				<?php
				if($member_id==$data_member['id']){
					echo "<dd><a target='_blank' href='member_photo_update.php?id={$member_id}'>Change Profile</a></dd>
					<dd><a target='_blank' href=''>Change Password</a></dd>";
				}
				?>		
			</dl>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<div id="footer" class="auto">
		<div class="bottom">
			<a>kiwier</a>
		</div>
		<div class="copyright">Powered by Kiwier ©2020 kiwier.com</div>
	</div>
</body>
</html>