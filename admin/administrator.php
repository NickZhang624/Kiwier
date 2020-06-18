<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';
$query='select * from kiwier_manage';
$result=execute($link,$query);
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Administrator</div>
		<table class="list">
			<tr>
				<th>Name</th>	 	 	
                <th>Level</th>
                <th>Create Time</th>
				<th>operation</th>
            </tr>
            <?php
            while($data=mysqli_fetch_assoc($result)){
                $delete_data=urldecode("administrator_delete.php?id={$data['id']}");
                $return_url=urldecode($_SERVER['REQUEST_URI']);
                $message="Do you want to delete administrator {$data['name']} ?";
                $delete_rul="confirm.php?delete_data={$delete_data}&return_url={$return_url}&message={$message}";
                if($data['level']==1){
                    $data['level']='Standard Administrator';
                }else{
                    $data['level']='Super Administrator';
                }
$html=<<<A
            <tr>
				<td>{$data['name']}</td>
                <td>{$data['level']}</td>
                <td>{$data['create_time']}</td>
				<td><a href="father_module_update.php?id={$data['id']}">[Edit]</a>&nbsp;&nbsp;<a href="$delete_rul">[Delete]</a></td> 
			</tr>
A;
            
            echo $html;
        }
            ?>
			
			
		</table>
	</div>
</body>
</html>