<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
if(!isset($_GET['delete_data']) || !isset($_GET['return_url']) || !isset($_GET['message'])){
exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Confirm</title>
<meta name="keywords" content="Confirm" />
<meta name="description" content="Confirm" />
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic ask"></span> <?php echo $_GET['message']?> <a style="color:red;" href="<?php echo $_GET['delete_data']?>">Yes</a> | <a style="color:#666;" href="<?php echo $_GET['return_url']?>">Cancel</a></div>
</body>
</html>