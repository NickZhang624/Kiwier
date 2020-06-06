<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';
$query='select * from sfk_father_module';
$result=execute($link,$query);
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Main Block</div>
		<table class="list">
			<tr>
				<th>Sort</th>	 	 	
				<th>Block Name</th>
				<th>operation</th>
            </tr>
            <?php
            while($data=mysqli_fetch_assoc($result)){
                $delete_data=urldecode("father_module_delete.php?id={$data['id']}");
                $return_url=urldecode($_SERVER['REQUEST_URI']);
                $message="Do you want to delete block {$data['module_name']}?";
                $delete_rul="confirm.php?delete_data={$delete_data}&return_url={$return_url}&message={$message}";
$html=<<<A
            <tr>
				<td><input class="sort" type="text" name="sort" value="{$data['sort']}"/></td>
				<td>{$data['module_name']}[id:{$data['id']}]</td>
				<td><a href="#">[Access]</a>&nbsp;&nbsp;<a href="father_module_update.php?id={$data['id']}">[Edit]</a>&nbsp;&nbsp;<a href="$delete_rul">[Delete]</a></td> 
			</tr>
A;
            
            echo $html;
        }
            ?>
			
			
		</table>
	</div>
</body>
</html>
