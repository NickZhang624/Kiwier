<?php
function upload($path,$Max_file_size,$key_name,$type=array('JPG','JPEG','GIF','PNG')){
    /*get configuration data from php*/
    $phpini=ini_get('upload_max_filesize');/*40M*/
    $phpini_unit=strtoupper(substr($phpini,-1));/*unit:M*/
    $phpini_numbers=substr($phpini,0,-1);/*40*/
    switch($phpini_unit){
        case 'K':
            $multiple=1024;
        break;
        case 'M':
            $multiple=1024*1024;
        break;
        case 'G':
            $multiple=1014*1024*1024;
    }
    $phpini_bytes=$phpini_numbers*$multiple;

    /*custom file size*/
    $custom_unit=strtoupper(substr($Max_file_size,-1));
    $custom_numbers=substr($Max_file_size,0,-1);
    switch($custom_unit){
        case 'K':
            $custom_multiple=1024;
        break;
        case 'M':
            $custom_multiple=1024*1024;
        break;
        case 'G':
            $custom_multiple=1014*1024*1024;
    }
    $custom_bytes=$custom_numbers*$custom_multiple;

    /*check uploaded file with php configuration file*/
    if($custom_bytes>$phpini_bytes){
        $return_data['error']="error";
        $return_data['return']=false;
        return $return_data;
    }
        $arr_errors=array(
            1=>'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2=>'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            3=>'The uploaded file was only partially uploaded.',
            4=>'No file was uploaded.',
            6=>'Missing a temporary folder',
            7=>'Failed to write file to disk',
        );
        /*check if it is existed*/
        if(!isset($_FILES[$key_name]['error'])){
            $return_data['error']="file is not existed";
            $return_data['return']=false;
        return $return_data;
        }
        if($_FILES[$key_name]['error']!=0){
            $return_data['error']=$arr_errors[$_FILES['error']];
            $return_data['return']=false;
        return $return_data;
        }
        /*HTTP POST upload*/
        if(!is_uploaded_file($_FILES[$key_name]['tmp_name'])){
            $return_data['error']='uploaded error';
            $return_data['return']=false;
        return $return_data;
        }
        if($_FILES[$key_name]['size']>$custom_bytes){
            $return_data['error']='File size is too large';
            $return_data['return']=false;
        return $return_data;
        }
        /*get filename info*/
        $arr_filename=pathinfo($_FILES[$key_name]['name']);
        if(!strtoupper($arr_filename['extension'])){/*check type*/
            $return_data['error']='File is not exsited';
            $return_data['return']=false;
        return $return_data;
        }
        if(!in_array(strtoupper($arr_filename['extension']),$type)){
            $return_data['error']='File is not support to upload';
            $return_data['return']=false;
        return $return_data;
        }
        /*check to server path*/
        if(!file_exists($path)){
            $return_data['error']='Path error';
            $return_data['return']=false;
        return $return_data;
        }
        /*set a rand name for each image*/
        $new_filename=str_replace('.','',uniqid(mt_rand(100000,999999),true));
        if($arr_filename['extension']!=''){
            $new_filename.=".{$arr_filename['extension']}";
        }

        /*move file from tem to server*/
        if(!move_uploaded_file($_FILES[$key_name]['tmp_name'],$path.$new_filename)){
            $return_data['error']='file moveing failed';
            $return_data['return']=false;
        return $return_data;
        }
       
        $return_data['filename']=$new_filename;
        $return_data['path']=$path.$new_filename;
        $return_data['return']=true;
        return $return_data;
    }

?>
    