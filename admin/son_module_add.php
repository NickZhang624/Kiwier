<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$link = connect();
include_once 'inc/check_administrator_login.inc.php';
if(isset($_POST['submit'])){
    $check_flag="add";

    //check user's input
    include_once 'inc/check_son_module.inc.php';

    $query="insert into sfk_son_module(father_module_id,module_name,info,member_id,sort) 
    values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('son_module.php','ok','Added Successfully!');
    }else{
        skip('son_module_add.php','error','Please try it again');
    }
}

?>

<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Add New Second Block</div>
    <form method="post">
            <table class="au">
                <tr>
                    <td>Main Block*</td>
                    <td>
                        <select name="father_module_id">
                            <option value="0">Please choose a Main block</option>
                            <?php
                            $query='select * from sfk_father_module';
                            $data=execute($link,$query);
                            while($data_father_module=mysqli_fetch_assoc($data)){
                                echo "<option value='{$data_father_module['id']}'>{$data_father_module['module_name']}</option>";
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
                    <td><input name="module_name" type="text" /></td>
                    <td>
                        Please enter a new block name
                    </td>
                </tr>
                <tr>
                    <td>Block Information</td>
                    <td><textarea name="info"></textarea></td>
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
                    <td><input name="sort" value="0" type="text" /></td>
                    <td>
                        please enter a number
                    </td>
                </tr>
            </table>
            <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="Add" />
        </form>
	</div>
</body>
</html>