<?php 

//use PHPMailer\src\PHPMailer;
//use PHPMailer\src\Exception;

//require 'PHPMailer/src/Exception.php';
//require 'PHPMailer/src/PHPMailer.php';
//require 'PHPMailer/src/SMTP.php';

//require("src/PHPMailer.php");
//require("src/SMTP.php");

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
    
    //$mail = new PHPMailer(true);
    //print_r($mail);die();

    $query = "SELECT * FROM `admin` WHERE `adminEmail`='".$email."'";
    $results = $db_handle->numRows($query);
    if ($results > 0) {
        if($_POST['request_type'] == 'web'){
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $password = implode($pass);
            // the message
            $msg = "Hi Admin\n\n\n";
            $msg .= "You have requested a password reset,"."\n\n";
            $msg .= "Please use this password ::".$password;
            $msg .= " To login"."\n\n";
            $msg .= "Login Url is :: http://reminderapi.mobile-codingbrains.com/rd-admin/login.php";
            // use wordwrap() if lines are longer than 70 characters
            $msg = wordwrap($msg,70);
            $password = md5($password);
            /*$m="codingbrains62@gmail.com";
            $headers = 'From:codingbrains123@gmail.com' . "\r\n" ;
            $headers .='Reply-To: '. $m . "\r\n" ;
            $headers .='X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            */
            //$password = md5('raju');
            // send email
            if(mail($email,"Reset password",$msg)){
                $query2 = "UPDATE `admin` SET `adminPassword`='".$password."' WHERE `adminEmail` = '".$email."'";

                $results = $db_handle->updateQuery($query2);
                if ($results == TRUE) {
                    header("Location: /rd-admin/login.php");
                    //echo "Update success";
                }else{
                    header("Location: /rd-admin/forgetpass.php");
                  //  echo "update fails";
                }
            }else{
                header("Location: /rd-admin/forgetpass.php");
                //echo "email fails";
            }
           
           
        }else{
    	   $msg = array('status'=>"200",'message' => "Login Successfully",'email' => $email,'password' => $password);
           echo json_encode($msg);
        }
    }else{
        if($_POST['request_type'] == 'web'){
            header("Location: /rd-admin/forgetpass.php");
        }else{
    	   $msg = array('status'=>"204",'message' => "Login fails",'email' => $email,'password' => $password);
           echo json_encode($msg);
        }   
    }
    

?>