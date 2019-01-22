<//img src=”http://reminderapi.mobile-codingbrains.com/phpjobscheduler/firepjs.php?return_image=1″
border=”0″ alt=”phpJobScheduler”>
<?php // http://reminderapi.mobile-codingbrains.com/api/loginApi.php
$content = file_get_contents("http://reminderapi.mobile-codingbrains.com/getAdminStatusApi.php");
$mainContent = json_decode($content);
if($mainContent == 'login'){
	echo '<script type="text/javascript">
           window.location = "http://reminderapi.mobile-codingbrains.com/rd-admin/dashboard.php"
      </script>';
}else{
	echo '<script type="text/javascript">
           window.location = "http://reminderapi.mobile-codingbrains.com/rd-admin/login.php"
      </script>';
}?>