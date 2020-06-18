<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();

$member_id=is_login($link);

//check if content is existed
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','error','Sorry this post is not existed');
}
$query="select * from kiwier_content where id = {$_GET['id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this post is not existed');
}

$data_post=mysqli_fetch_assoc($result);
//convert any special characters to text that be showed in user page
$data_post['title']=htmlspecialchars($data_post['title']);
// nl2br = convert space to next line
$data_post['content']=nl2br(htmlspecialchars($data_post['content']));
// show real-time views
$data_post['numbers']=$data_post['numbers']+1;

$query="select * from kiwier_son_module where id = {$data_post['module_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this post is not existed');
}
$data_son=mysqli_fetch_assoc($result);

$query="select * from kiwier_father_module where id = {$data_son['father_module_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this post is not existed');
}
$data_father=mysqli_fetch_assoc($result);

$query="select * from kiwier_member where id = {$data_post['member_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('index.php','error','Sorry this post is not existed');
}
$data_member=mysqli_fetch_assoc($result);

//add views
$query="update kiwier_content set numbers=numbers+1 where id={$_GET['id']}";
execute($link,$query);

//set pages
$query="select count(*) from kiwier_reply where content_id ={$_GET['id']}";
$count_reply=num($link,$query);
$page_size="5";
$page=page($count_reply,$page_size);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
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
		 <a href="index.php">Home</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a> &gt; <a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['module_name']?></a> &gt; <?php echo $data_post['title']?>
    </div>
    
	<div id="main" class="auto">
    <div class="wrap1">
			<div style="clear:both;"></div>
		</div>
		<?php
		if($_GET['page']==1){
		?>
		<div class="wrapContent">
			<div class="left">
				<div class="face">
					<a target="_blank" href="member.php?id=<?php echo$data_member['id']?>">
                        <?php
                        if($data_member['photo']!='0'){
							$arr_path=explode('/',$data_member['photo']);
							$arr_path=$arr_path['5'].'/'.$arr_path['6'];
							echo"<img width='150' height='150' style='object-fit:contain'; src='$arr_path'/>";
                        }else{
							echo "<img width='150' height='150' src='style/photo1.jpg'/>";
						}
                        ?>
					</a>
				</div>
				<div class="name">
					<a target="_blank" href="member.php?id=<?php echo$data_member['id']?>"><?php echo $data_member['name']?></a>
				</div>
			</div>
			<div class="right">
				<div class="title">
					<h2><?php echo $data_post['title']?></h2>
					<?php 
							$query="select count(*) from kiwier_reply where content_id={$_GET['id']}";
							$result_reply_numbers=num($link,$query);
							?>
					<span>Views：<?php echo $data_post['numbers']?>&nbsp;|&nbsp;Reply：<?php echo $result_reply_numbers?></span>
					<div style="clear:both;"></div>
				</div>
				<div class="pubdate">
					<span class="date">Publish Time：<?php echo $data_post['time']?> </span>
					<span class="floor" style="color:red;font-size:14px;font-weight:bold;">Publisher</span>
				</div>
				<div class="content">
					 <?php echo $data_post['content']?>
				</div>
			</div>
			<div style="clear:both;"></div>
        </div>
		<?php
		}
		?>	

        <?php
        $query="select kiwier_reply.quote_id,kiwier_reply.id,kiwier_reply.member_id,kiwier_reply.time,kiwier_reply.content,kiwier_member.name,kiwier_member.photo from 
        kiwier_reply, kiwier_member where 
        kiwier_reply.member_id = kiwier_member.id and 
        kiwier_reply.content_id = {$_GET['id']} {$page['limit']}";
		$result_reply=execute($link,$query);
		$i=($_GET['page']-1)*$page_size+1;
        while($data_reply=mysqli_fetch_assoc($result_reply)){
			//set up image path
			if($data_reply['photo']!='0'){
				$arr_path=explode('/',$data_reply['photo']);
				$arr_path=$arr_path['5'].'/'.$arr_path['6'];
			} 
        ?>
		<div class="wrapContent">
			<div class="left">
				<div class="face">
					<a target="_blank" href="member.php?id=<?php echo$data_reply['member_id']?>">
                    <?php if($data_reply['photo']!=='0'){echo "<img width='150' height='150' style='object-fit:contain'; src='$arr_path'/>";}else{echo "<img width='150' height='150' src='style/photo1.jpg'/>";}?>
                    </a>
				</div>
				<div class="name">
					<a target="_blank" href="member.php?id=<?php echo$data_reply['member_id']?>"><?php echo $data_reply['name']?></a>
				</div>
			</div>
			<div class="right">
				
				<div class="pubdate">
					<span class="date">Reply time：<?php echo $data_reply['time']?></span>
					<span class="floor">#<?php echo $i++?>&nbsp;|&nbsp;<a target="_blank" href="quote.php?id=<?php echo $_GET['id']?>&quote_id=<?php echo $data_reply['id']?>">Quote</a></span>
				</div>
				<div class="content">


					<?php
					if(!$data_reply['quote_id']==null){
					$query="select count(*) from kiwier_reply where content_id={$_GET['id']} and id<={$data_reply['quote_id']}";
					$floor=num($link,$query);
					$query="select kiwier_reply.content,kiwier_member.name from 
					kiwier_reply,kiwier_member where 
					kiwier_reply.id={$data_reply['quote_id']} and 
					kiwier_reply.content_id={$_GET['id']} and 
					kiwier_reply.member_id=kiwier_member.id";
					$result_quote=execute($link,$query);
					$data_quote=mysqli_fetch_assoc($result_quote);
					?>
				    <div class="quote">
					<h2>Quote #<?php echo $floor?> <?php echo $data_quote['name']?> posted: </h2>
					<?php echo $data_quote['content']=nl2br(htmlspecialchars($data_quote['content']))?>
					</div>
					<?php
					}
					?>

                    <?php
                    $data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
                    echo $data_reply['content']
                    ?>
				</div>
			</div>
			<div style="clear:both;"></div>
        </div>
        
        <?php
        }
        ?>
		<div class="wrap1">
			<div class="pages">
            <?php
			echo $page['html'];
            ?>
			</div>
			<a class="btn reply" href="reply.php?id=<?php echo $data_post['id']?>"></a>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>Kiwier</a>
		</div>
		<div class="copyright">Powered by Kiwier ©2020 kiwier.com</div>
	</div>
</body>
</html>