<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$link=connect();
include_once 'inc/check_administrator_login.inc.php';
//check the ID recevied if it is number or other characters
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('son_module.php','error',"Sorry, No ID existed!");
}

$query="select * from sfk_son_module where id={$_GET['id']}";
$result=execute($link,$query);
// //check if this query is existed in the database
if(!mysqli_num_rows($result)){
    skip('son_module.php','error',"Sorry, No ID existed!");
}
$data=mysqli_fetch_assoc($result);
$raw_data=$data;

//update date
if(isset($_POST['submit'])){
    $raw_data;
    $check_flag="modify";
    include_once 'inc/check_son_module.inc.php'; 
    $query="update sfk_son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('son_module.php','ok','Updated Successfully!');
    }else{
        skip("son_module_update.php?id={$_GET['id']}",'error','Please try it again');
    }
    
};

?>

<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Edit Second Block - <?php echo $data['module_name']?></div>
<form method="post">
            <table class="au">
                <tr>
                    <td>Main Block*</td>
                    <td>
                        <select name="father_module_id">
                            <option value="0">Please choose a Main block</option>
                            <?php
                            $query='select * from sfk_father_module';
                            $father_data=execute($link,$query);
                            while($data_father_module=mysqli_fetch_assoc($father_data)){
                                if($data['father_module_id']==$data_father_module['id']){
                                    echo "<option selected='selected' value='{$data_father_module['id']}'>{$data_father_module['module_name']}</option>";
                                }else{
                                    echo "<option value='{$data_father_module['id']}'>{$data_father_module['module_name']}</option>";
                                }
                                
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        Main Block Name
                    </td>
                </tr>
                <tr>
                    <td>New Block Name*</td>
                    <td><input name="module_name" type="text" value="<?php echo $data['module_name']?>" /></td>
                    <td>
                        Please enter a new block name
                    </td>
                </tr>
                <tr>
                    <td>Block Information</td>
                    <td><textarea name="info"><?php echo $data['info']?></textarea></td>
                    <td>
                        Block Information
                    </td>
                </tr>
                <tr>
                    <td>Member</td>
                    <td>
                        <select name="member_id">
                            <option value="0">Please choose a member</option>
                        </select>
                    </td>
                    <td>
                        Please choose a member as the administrator
                    </td>
                </tr>
                <tr>
                    <td>Sort</td>
                    <td><input name="sort" type="text" value="<?php echo $data['sort']?>"/></td>
                    <td>
                        please enter a number
                    </td>
                </tr>
            </table>
            <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="Submit" />
        </form>
	</div>
</body>
</html>