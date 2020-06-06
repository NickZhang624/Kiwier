<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';
//add new data
if(isset($_POST['submit'])){
    $check_flag="add";
    //check user's input
    include_once 'inc/check_father_module.inc.php';
    
    //add new data
    $query="insert into sfk_father_module(module_name,sort) values('{$_POST['module_name']}',{$_POST['sort']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('father_module.php','ok','Added Successfully!');
    }else{
        skip('father_module_add.php','error','Please try it again');
    }
      
};

?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Add New Main Block</div>
    <form method="post">
            <table class="au">
                <tr>
                    <td>New Block Name*</td>
                    <td><input name="module_name" type="text" /></td>
                    <td>
                        Please enter a new block name
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