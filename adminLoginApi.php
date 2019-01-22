<?php 
session_start();
$postdata = file_get_contents("php://input");
require_once ("api/DbConnection.php");
$db_handle = new DBConnection();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Content-Type: application/json; charset=UTF-8');
//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400'); 
$request = json_decode($postdata);

    if($_POST['request_type'] == 'web'){
        $email = $_POST['email'];
        $password = $_POST['password'];
    }else{
        $email = $request->email;
        $password = $request->password;
    }
    $_SESSION['user_name']=$email;
    $_SESSION['user_password']=$password;
    //print_r($_SESSION);die();
    //Email validation
    if(!empty($email)){
        if(!preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/",$email)){
            $msg = array('status'=>"204",'message' => "Invalid Email Id");
        }else{
            $email = $email;
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

    $query = "SELECT * FROM `admin` WHERE `adminEmail`='".$email."' AND `adminPassword`='".$password."'";
    $results = $db_handle->numRows($query);
    $results2 = $db_handle->runQuery($query);
    //print_r($results2);die();
    $a=$results2[0];
    $un=$a['adminName'];
    $_SESSION['name']=$un;
    if ($results > 0) {
        if($_POST['request_type'] == 'web'){
           header("Location: /rd-admin/dashboard.php");
           //http://localhost/remainderApp/rd-admin/login.php
        }else{
    	   $msg = array('status'=>"200",'message' => "Login Successfully",'email' => $email,'password' => $password);
           echo json_encode($msg);
        }
    }else{
        if($_POST['request_type'] == 'web'){
            header("Location: /rd-admin/login.php");
        }else{
    	   $msg = array('status'=>"204",'message' => "Login fails",'email' => $email,'password' => $password);
           echo json_encode($msg);
        }   
    }
    

?>