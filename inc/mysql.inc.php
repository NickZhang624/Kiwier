<?php 
//connet to mysql database
function connect($host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$database=DB_DATABASE,$port=DB_PORT){
	$link=@mysqli_connect($host, $user, $password, $database, $port);
	if(mysqli_connect_errno()){
		exit(mysqli_connect_error());
	}
	mysqli_set_charset($link,'utf8');
	return $link;
}
//execute SQL 
function execute($link,$query){
	$result=mysqli_query($link,$query);
	if(mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $result;
}

/*
 execute multiple SQL 
$link: database connection
$arr_sqls: return an array which included SQL
$error: this is a variable, return error msg
example：
$arr_sqls=array(
	'select * from sfk_father_module',
	'select * from sfk_father_module',
	'select * from sfk_father_module',
	'select * from sfk_father_module'
);
var_dump(execute_multi($link, $arr_sqls,$error));
echo $error;
*/
function execute_multi($link,$arr_sqls,&$error){
	$sqls=implode(';',$arr_sqls).';';
	if(mysqli_multi_query($link,$sqls)){
		$data=array();
		$i=0;
		do {
			if($result=mysqli_store_result($link)){
				$data[$i]=mysqli_fetch_all($result);
				mysqli_free_result($result);
			}else{
				$data[$i]=null;
			}
			$i++;
			if(!mysqli_more_results($link)) break;
		}while (mysqli_next_result($link));
		if($i==count($arr_sqls)){
			return $data;
		}else{
			$error=mysqli_error($link);
			return false;
		}
	}else{
		$error=mysqli_error($link);
		return false;
	}
}
//get rows 
function num($link,$sql_count){
	$result=execute($link,$sql_count);
	$count=mysqli_fetch_row($result);
	return $count[0];
}

// //make sure data are safe before sending to database
function escape($link,$data){
	if(is_string($data)){
		return mysqli_real_escape_string($link,$data);
	}
	if(is_array($data)){
		foreach ($data as $key=>$val){
			$data[$key]=escape($link,$val);
		}
	}
	return $data;
}

//close sql connection
function close($link){
	mysqli_close($link);
}

?>