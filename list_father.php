<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();

$member_id=is_login($link);


//check father_id
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Sorry this module is not existed');
}
$query="select * from sfk_father_module where id = {$_GET['id']}";
$result=execute($link,$query);
$data_father=mysqli_fetch_assoc($result);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this module is not existed');
}

//fetch data from son_module
$query="select * from sfk_son_module where father_module_id={$_GET['id']}";
$result_son=execute($link,$query);
// set variable
$id_son='';
$son_list='';

while($data_son=mysqli_fetch_assoc($result_son)){
    //output: id,id,id,
    $id_son.=$data_son['id'].',';
    $son_list.="<a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
}
//output: id,id,id
$id_son=trim($id_son,',');

//check if no son_module under father_module databse 
if($id_son==""){
    $id_son=0;
}

//fetch content numbers and counts from content 
$query="select count(*) from sfk_content where module_id in({$id_son})";
$count_all=num($link,$query);
$query="select count(*) from sfk_content where module_id in({$id_son}) and time > CURDATE()";
$count_today=num($link,$query);


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
		 <a href="index.php">Home</a> &gt; <?php echo $data_father['module_name'] ?>
	</div>
	<div id="main" class="auto">
		<div id="left">
			<div class="box_wrap">
				<h3><?php echo $data_father['module_name'] ?></h3>
				<div class="num">
				    Today：<span><?php echo $count_today ?></span>&nbsp;&nbsp;&nbsp;
				    Total：<span><?php echo $count_all ?></span>
				  <div class="moderator"> Submodule: <?php echo $son_list ?></div>
				</div>
			</div>
			<div style="clear:both;"></div>
			<ul class="postsList">
                <?php
                $query="select sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.numbers,sfk_member.id member_id,sfk_member.name,sfk_member.photo,sfk_son_module.module_name,sfk_son_module.id son_id
                from sfk_content,sfk_member,sfk_son_module where 
                sfk_content.module_id in({$id_son}) and 
                sfk_content.member_id = sfk_member.id and 
                sfk_content.module_id = sfk_son_module.id {$page['limit']}";
                $result_content=execute($link,$query);
                while($data_content=mysqli_fetch_assoc($result_content)){
					$data_content['title']=htmlspecialchars($data_content['title']);
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
                        <div class="titleWrap"><a href="list_son.php?id=<?php echo $data_content['son_id']?>">[<?php echo $data_content['module_name']?>]</a>&nbsp;&nbsp;<h2><a href="show_content.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
						<?php
						$query="select * from sfk_reply where content_id={$data_content['id']} order by id desc limit 1";
						$result_last_reply=execute($link,$query);
						if(mysqli_num_rows($result_last_reply)==0){
							$last_reply="No reply";
						}else{
							$data_last_reply=mysqli_fetch_assoc($result_last_reply);
							$last_reply=$data_last_reply['time'];
						}
						?>
						<p>
							Publisher：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;Last reply：<?php echo $last_reply?>
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
							$query="select count(*) from sfk_reply where content_id={$data_content['id']}";
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
            <?php    
            }
            ?>
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
				<div class="title">Subject List</div>
				<ul class="listWrap">
                    <?php
                    $query="select * from sfk_father_module";
                    $result_father=execute($link,$query);
                    while($data_father=mysqli_fetch_assoc($result_father)){
                    ?>
					<li>
						<h2><a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a></h2>
						<ul>
                            <?php
                            $query="select * from sfk_son_module where father_module_id={$data_father['id']}";
                            $result_son=execute($link,$query);
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
	<div id="footer" class="auto">
		<div class="bottom">
			<a>SFK</a>
		</div>
		<div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
	</div>
</body>
</html>