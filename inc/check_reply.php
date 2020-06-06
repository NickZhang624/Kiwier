<?php
if(empty($_POST['content'])){
    skip($_SERVER['REQUEST_URI'],'error','Please try it again');
}

?>