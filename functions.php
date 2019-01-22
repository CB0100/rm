<?php 
require_once ("api/DbConnection.php");
$db_handle = new DBConnection();

function viewAllUser(){
	$query = "SELECT * FROM `registration`";
	$results = $db_handle->runQuery($query);
	foreach ($results as $data) {
		echo $data['userName'];
		/*$output .= '<tr>
		        <td></td>
		        <td>1</td>
		        <td>
		            <div class="btn-group project-list-ad">
		                <button class="btn btn-white btn-xs">Active</button>
		            </div>
		        </td>
		        <td>'.$data["userName"].'</td>
		        <td>Amvescap plc</td>
		        <td>codingbrains6@gmail.com</td>
		        <td>Jun 6, 2013</td>
		        <td>
		            <div class="btn-group project-list-action">
		                <button class="btn btn-white btn-action btn-xs"><i class="fa fa-folder"></i> Delete</button>
		                <button class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> Edit</button>
		            </div>
		        </td>
		    </tr>';*/
	 }   
	
	//return $output;    
}