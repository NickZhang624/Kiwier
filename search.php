<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();
$member_id=is_login($link);


if(!isset($_GET['keyword'])){
	$_GET['keyword']='';
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link,$_GET['keyword']);
$query="select count(*) from kiwier_content where title like '%{$_GET['keyword']}%'";
$count_all=num($link,$query);

$page=page($count_all,5);

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
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">Kiwier</div>
			<div class="nav">
				<a class="hover" href="index.php">Home</a>
			</div>
			<div class="serarch">
				<form action="search.php" method="get">
					<input class="keyword" type="text" name="keyword" value="<?php echo $_GET['keyword']?>" placeholder="Search..." />
					<input class="submit" type="submit" name="submit" value=""/>
				</form>
			</div>
			<div class="login">
                <?php
                if($member_id){
$str=<<<A
                    <a target=_blank" href="member.php?id=$member_id">Hi, {$_COOKIE['kiwier']['name']} </a><span style="color:white">|<span> <a href="sign_out.php">Sign out</a>
                    
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
	 <a href="index.php">Home</a> &gt; Search Result
</div>
<div id="main" class="auto">
	<div id="left">
		<div class="box_wrap">
			<h3>Total: <?php echo $count_all?> posts found</h3>
		</div>
		<div style="clear:both;"></div>
		<ul class="postsList">
			<?php 
			$query="select
			kiwier_content.title,kiwier_content.id,kiwier_content.time,kiwier_content.numbers,kiwier_content.member_id,kiwier_member.name,kiwier_member.photo
			from kiwier_content,kiwier_member where
			kiwier_content.title like '%{$_GET['keyword']}%' and
			kiwier_content.member_id=kiwier_member.id
			{$page['limit']}";
			$result_content=execute($link,$query);
			while($data_content=mysqli_fetch_assoc($result_content)){
			$data_content['title']=htmlspecialchars($data_content['title']);
			$data_content['title_color']=str_replace($_GET['keyword'],"<span style='color:red;'>{$_GET['keyword']}</span>",$data_content['title']);
			$query="select time from kiwier_reply where content_id={$data_content['id']} order by id desc limit 1";
			$result_last_reply=execute($link, $query);
			if(mysqli_num_rows($result_last_reply)==0){
				$last_time='No reply';
			}else{
				$data_last_reply=mysqli_fetch_assoc($result_last_reply);
				$last_time=$data_last_reply['time'];
			}
			$query="select count(*) from kiwier_reply where content_id={$data_content['id']}";
			//set up image path
			if($data_content['photo']!='0'){
				$arr_path=explode('/',$data_content['photo']);
				$arr_path=$arr_path['5'].'/'.$arr_path['6'];
			}    
			?>
			<li>
				<div class="smallPic">
					<a target="_blank" href="member.php?id=<?php echo $data_content['member_id']?>">
						<img width="45" height="45" style='object-fit:contain' src="<?php if($data_content['photo']!='0'){echo $arr_path;}else{echo 'style/photo.jpg';}?>">
					</a>
				</div>
				<div class="subject">
					<div class="titleWrap"><h2><a target="_blank" href="show_content.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title_color']?></a></h2></div>
					<p>
						Publisher：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;Last reply：<?php echo $last_time?><br />
					</p>
					<?php if(is_login_manage($link) and !$member_id=is_login($link)){// 
						$return_url=urldecode($_SERVER['REQUEST_URI']);
						$delete_data=urldecode("content_delete.php?id={$data_content['id']}&return_url={$return_url}");
						$message="Do you want to delete {$data_content['title']}? ";
						$delete_rul="confirm.php?delete_data={$delete_data}&message={$message}";
						 
						echo "<a href='content_update.php?id={$data_content['id']}&R={$return_url}'>Edit</a> | <a href='$delete_rul'>Delete</a>";

					    }?>
				</div>
				<div class="count">
				<?php 
							$query="select count(*) from kiwier_reply where content_id={$data_content['id']}";
							$result_reply_numbers=num($link,$query);
							?>
						<p>
							Reply<br /><span><?php echo $result_reply_numbers?></span>
							
						</p>
						<p>
							Views<br /><span><?php echo $data_content['numbers']?></span>
						</p>
				</div>
				<div style="clear:both;"></div>
			</li>
			<?php }?>
		</ul>
		<div class="pages_wrap">
			<div class="pages">
				<?php 
				echo $page['html'];
				?>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div id="right">
		<div class="classList">
			<div class="title">Modules</div>
			<ul class="listWrap">
				<?php 
				$query="select * from kiwier_father_module";
				$result_father=execute($link, $query);
				while($data_father=mysqli_fetch_assoc($result_father)){
				?>
				<li>
					<h2><a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a></h2>
					<ul>
						<?php 
						$query="select * from kiwier_son_module where father_module_id={$data_father['id']}";
						$result_son=execute($link, $query);
						while($data_son=mysqli_fetch_assoc($result_son)){
						?>
						<li><h3><a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['module_name']?></a></h3></li>
						<?php 
						}
						?>
					</ul>
				</li>
				<?php 
				}
				?>
			</ul>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
</body>
</html>