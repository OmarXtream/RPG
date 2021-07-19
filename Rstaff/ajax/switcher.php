<?php
$amstaff = true;
require_once("../../inc/db.php");
require_once("../../inc/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع من فضلك أعد تحميل الصفحة', 'tp'=>'error', 'b' => true));
	}

	if(isset($_POST['id'],$_POST['to'])){
		$option = $_POST['to'];
		if(!filter_var($option, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>4))) OR !ctype_digit($_POST['id'])){
			returnJSON(array('t' => 'خطأ', 'm' => 'من فضلك تأكد من القيم المرسلة', 'tp'=>'error', 'b' => true));
		}elseif(antiSpam('sitesettings.php:changeSettings')){
			returnJSON(array('t' => 'خطأ', 'm' => 'من فضلك أنتظر بين محاولاتك', 'tp'=>'error', 'b' => true));
		}else{
	        $conn= Database::getInstance();
			
		$insertData = $conn->prepare("UPDATE apply SET status = :to WHERE id= :id");
		$insertData->bindValue(':to', $_POST['to']);
		$insertData->bindValue(':id', $_POST['id']);
		$insertData->execute();

			if($insertData->rowCount() > 0){

			returnJSON(array('t' => 'تم', 'm' => 'تم تغيير الحالة بنجاح', 'tp'=>'success', 'b' => true));
			}else{
			returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع من فضلك أعد تحميل الصفحة', 'tp'=>'error', 'b' => true));
				
			}
		}
	}
}



?>