<?php
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

	$query = "UPDATE admin SET status='logout' WHERE id='$request->id'";
	$results = $db_handle->updateQuery($query);

	    if ($results === "Updated successfully") 
		    {
		    	$msg = array('status'=>"200",'message' => "Logout Successfully",'id' => $request->id);
		    }
	    else
		    {
		    	$msg = array('status'=>"204",'message' => "Logout fails",'id' => $request->id);
		    }				    
	    echo json_encode($msg);
?>