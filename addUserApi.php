<?php 
require_once ("api/DbConnection.php");
$db_handle = new DBConnection();
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$fullname = $fname ."".$lname;
$uname = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['confarm_password'];
$request_type = $_POST['request_type'];
$id = $_POST['id'];

//First Name Validation
if(!empty($fname)){
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        $msg = array('status'=>"204",'message' => "First Name allowed only letters and white space allowed");
    }else{
        $fname = $fname;   
    }
}else{
    $msg = array('status'=>"204",'message' => "First Name Field can't empty");
}

//Last Name Validation
if(!empty($lname)){
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        $msg = array('status'=>"204",'message' => "Last Name allowed only letters and white space allowed");
    }else{
        $lname = $lname;   
    }
}else{
    $msg = array('status'=>"204",'message' => "Last Name Field can't empty");
}

//User Name Validation
if(!empty($uname)){
    if (!preg_match("/^[a-zA-Z ]*$/",$uname)) {
        $msg = array('status'=>"204",'message' => "User Name allowed only letters and white space allowed");
    }else{
        $uname = $uname;   
    }
}else{
    $msg = array('status'=>"204",'message' => "User Name Field can't empty");
}

//Email validation
if(!empty($email)){
	$result = "SELECT * FROM `registration` WHERE `userEmail`='$email'";
	$row_cnt = $result->num_rows;
	if ($row_cnt > 0) {
		$msg = array('status'=>"204",'message' => "Email already exists");
	}else{
		if(!preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/",$email)){
        $msg = array('status'=>"204",'message' => "Invalid Email Id");
	    }else{
	        $email = $email;
	    }
	}
}else{
    $msg = array('status'=>"204",'message' => "Email Field can't empty");
}
//Password validation
if(!empty($password)){
    $password = md5($password);
}else{
    $msg = array('status'=>"204",'message' => "Password Field can't empty");
}
if($request_type == 'add'){
    $status = "Active";
    $timeZone = "IST";
    $currentDate =  date("Y/m/d");
    $loginCount = 0;
    if(!empty($uname) && !empty($email) && !empty($password)){
        $query = "INSERT INTO `registration` (`id`, `fName`, `lName`, `userName`, `userPassword`, `userEmail`, `status`, `created_at`, `timeZone`, `updated_at`) VALUES (NULL, '".$fname."', '".$lname."', '".$uname."', '".$password."', '".$email."', '".$status."', '".$currentDate."', '".$timeZone."', '')";
        $results = $db_handle->insertQuery($query);
        //if ($results > 0) {
        if($results == true){
            $querys = "INSERT INTO `login` (`id`, `userName`, `userPassword`, `userEmail`, `status`, `created_at`, `loginCount`, `updated_at`) VALUES (NULL, '".$uname."', '".$password."', '".$email."', '".$status."', '".$currentDate."', '".$loginCount."', '')";
            $resultss = $db_handle->insertQuery($querys);
            if($resultss == true){
                echo "<script>alert ('Added successfully')</script>";
                echo "<script> window.location.href = '/rd-admin/viewUser.php';</script>";
            }else{

            }
         }else{
            echo "<script>alert ('Added successfully')</script>";
            echo "<script> window.location.href = '/rd-admin/addUser.php';</script>";
         }
    }   
}else{
    if(!empty($uname) && !empty($email)){
        $reg_query = "UPDATE `registration` SET `userName`='".$uname."',`fName`='".$fname."',`lName`='".$lname."',`userEmail`='".$email."',`updated_at`='".$currentDate."' WHERE `id`=".$id;
        $exe_query = $db_handle->updateQuery($reg_query);
        if($exe_query == true){
            $login_query = "UPDATE `login` SET `userName`='".$uname."',`userEmail`='".$email."',`updated_at`='".$currentDate."' WHERE `id`=".$id;
            $log_exe_query = $db_handle->updateQuery($login_query);
            if($log_exe_query == true){
                echo "<script>alert ('Updated successfully test')</script>";
                echo "<script> window.location.href = '/rd-admin/viewUser.php';</script>";
            }    
         }else{
            echo "<script>alert ('Updated fail')</script>";
            echo "<script> window.location.href = '/rd-admin/addUser.php';</script>";
         }
    }
}
?>