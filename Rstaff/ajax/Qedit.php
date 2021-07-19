<?php
$amstaff = true;
require_once("../../inc/db.php");
require_once("../../inc/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع من فضلك أعد تحميل الصفحة', 'tp'=>'error', 'b' => true));
	}

	if(isset($_POST['id'],$_POST['newtext'])){
		$option = $_POST['id'];
		if(!filter_var($option, FILTER_VALIDATE_INT) OR !ctype_digit($_POST['id']) or empty($_POST['id'])){
		    http_response_code(997);
			returnJSON(array('t' => 'خطأ', 'm' => 'من فضلك تأكد من القيم المرسلة', 'tp'=>'warning', 'b' => true),false);
		}elseif(!filter_input_array(INPUT_POST,$_POST['newtext'],FILTER_SANITIZE_STRING) or empty($_POST['newtext'])){
			http_response_code(997);
			returnJSON(array('t' => 'خطأ', 'm' => 'من فضلك تأكد من القيم المرسلة', 'tp'=>'warning', 'b' => true),false);
		}elseif(antiSpam('Qedit.php:changeSettings')){
			http_response_code(999);
			returnJSON(array('t' => 'خطأ', 'm' => 'من فضلك أنتظر بين محاولاتك', 'tp'=>'error', 'b' => true),false);
		}else{
	        $conn= Database::getInstance();
		$insertData = $conn->prepare("UPDATE questions SET text = :to WHERE id= :id");
		$insertData->bindValue(':to', $_POST['newtext']);
		$insertData->bindValue(':id', $_POST['id']);
		$insertData->execute();

			if($insertData->rowCount() > 0){
			$new = htmlspecialchars($_POST['newtext']);

			returnJSON(array('t' => 'تم', 'm' => 'تم تحديث  السؤال بنجاح', 'tp'=>'success', 'b' => true, 'newtext' => $new));
			}else{
			returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع من فضلك أعد تحميل الصفحة', 'tp'=>'error', 'b' => true),false);
				
			}
		}
	}
}



?>