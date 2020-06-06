<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">SFK</div>
			<div class="nav">
				<a class="hover" href="index.php">Home</a>
			</div>
			<div class="serarch">
				<form action="search.php" method="get">
					<input class="keyword" type="text" name="keyword" placeholder="Search..." />
					<input class="submit" type="submit" name="submit" value=""/>
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
	<?php
        $query="select * from sfk_father_module order by sort desc";
        $result_father=execute($link,$query);
        while($data_father=mysqli_fetch_assoc($result_father)){
	?>
	<div class="box auto">
		<div class="title">
		<a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a>
		</div>
		<div class="classList">
			<?php
			$query="select * from sfk_son_module where father_module_id={$data_father['id']}";
			$result_son=execute($link,$query);
			if(mysqli_num_rows($result_son)){
				while($data_son=mysqli_fetch_assoc($result_son)){
					$query="select count(*) from sfk_content where module_id={$data_son['id']} and time > CURDATE()";
					$count_today=num($link,$query);
					$query1="select count(*) from sfk_content where module_id={$data_son['id']}";
					$numbers=num($link,$query1);
					echo "<div class='childBox new'>
					<h2><a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> <span>(Today {$count_today})</span></h2>
					Posts：{$numbers}<br />
						</div>";
				}
			}else{
				echo '<div style="padding:10px 0;">No Submodule...</div>';
			}

			?>
		<div style='clear:both;'></div>	
			
		</div>
	</div>
		<?php }?>

	<div id="footer" class="auto">
		<div class="bottom">
			<a>SFK</a>
		</div>
		<div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
	</div>
</body>
</html>