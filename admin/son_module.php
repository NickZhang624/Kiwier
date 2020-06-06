<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';

$query='select ssm.id son_id, ssm.module_name son_module_name, ssm.member_id, ssm.sort, sfm.module_name father_module_name from sfk_son_module ssm, sfk_father_module sfm where sfm.id=ssm.father_module_id order by sfm.id';
$result=execute($link,$query);

?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Second Block</div>
		<table class="list">
            <tr>
                <th>Sort</th>
                <th>Main Block</th>	 	 	
                <th>Second Block Name</th>
                <th>Administrator</th>
				<th>operation</th>
            </tr>
            <?php
            while($data=mysqli_fetch_assoc($result)){
                $delete_data=urldecode("son_module_delete.php?id={$data['son_id']}");
                $return_url=urldecode($_SERVER['REQUEST_URI']);
                $message="Do you want to delete second block {$data['son_module_name']} ?";
                $delete_rul="confirm.php?delete_data={$delete_data}&return_url={$return_url}&message={$message}";
$html=<<<A
            <tr>
				<td><input class="sort" type="text" name="sort" value="{$data['sort']}"/></td>
                <td>{$data['father_module_name']}</td>
                <td>{$data['son_module_name']}[id:{$data['son_id']}]</td>
                <td>{$data['member_id']}</td>
				<td><a href="#">[Access]</a>&nbsp;&nbsp;<a href="son_module_update.php?id={$data['son_id']}">[Edit]</a>&nbsp;&nbsp;<a href="$delete_rul">[Delete]</a></td> 
            </tr>
A;
echo $html;}
            ?>
			
		</table>
	</div>
</body>
</html>