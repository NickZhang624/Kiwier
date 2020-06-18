<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/check_administrator_login.inc.php';
//check the ID recevied if it is number or other characters
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('father_module.php','error',"Sorry, No ID existed!");
}

$query="select * from kiwier_father_module where id={$_GET['id']}";
$result=execute($link,$query);
// //check if this query is existed in the database
if(!mysqli_num_rows($result)){
    skip('father_module.php','error',"Sorry, No ID existed!");
}
$data=mysqli_fetch_assoc($result);
$raw_data=$data['module_name'];

//update date
if(isset($_POST['submit'])){
    $check_flag="modify";
    include_once 'inc/check_father_module.inc.php';
    $query="update kiwier_father_module set module_name='{$_POST['module_name']}',sort={$_POST['sort']} where id={$_GET['id']}";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('father_module.php','ok','Updated Successfully!');
    }else{
        skip('father_module_update.php','error','Please try it again');
    }
    
};

?>

<?php include_once 'inc/header.inc.php';?>
<div id="main">
<div class="title">Edit Main Block - <?php echo $data['module_name']?></div>
<form method="post">
            <table class="au">
                <tr>
                    <td>Block Name*</td>
                    <td><input name="module_name" type="text" value="<?php echo $data['module_name']?>" /></td>
                    <td>
                        Please enter a block name
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