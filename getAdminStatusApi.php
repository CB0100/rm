<?php 
$postdata = file_get_contents("php://input");
require_once ("DbConnection.php");
$db_handle = new DBConnection();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Content-Type: application/json; charset=UTF-8');
//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400'); 
$query = "SELECT `status` FROM `admin`";
$res = $db_handle->runQuery($query);
foreach($res as $re){
   $adminStatus = $re["status"]; 
}
echo json_encode($adminStatus);?>