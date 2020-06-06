<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$link=connect();
include_once 'inc/check_administrator_login.inc.php';
if(isset($_POST['submit'])){
    include_once 'inc/check_manage.inc.php';
    $query="insert into sfk_manage(name,pw,create_time,level) values('{$_POST['name']}',md5('{$_POST['pw']}'),now(),{$_POST['level']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('administrator.php','ok','Added Successfully!');
    }else{
        skip('manage_add.php','error','Please try it again');
    }
}
?>

<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Add New Administrator</div>
    <form method="post">
            <table class="au">
                <tr>
                    <td>New Administrator*</td>
                    <td><input name="name" type="text" /></td>
                    <td>
                        Please enter a new name
                    </td>
                </tr>
                <tr>
                    <td>Password*</td>
                    <td><input name="pw" type="password" /></td>
                    <td>
                        please do not over 20 characters
                    </td>
                </tr>
                <tr>
                    <td>Level*</td>
                    <td><select name="level">
                        <option value="1">Standard Administrator</option>
                        <option value="2">Super Administrator</option>
                    </select></td>
                    <td>
                        Choose an administrative level
                    </td>
                </tr>
            </table>
            <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="Add" />
        </form>
	</div>
</body>
</html>