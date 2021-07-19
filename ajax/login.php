<?php
$withOutProtection = true;
require_once("../inc/req.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
	  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	}else if (isset($_SESSION['memberId:rpg'])) {
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'أنت مسجل بالفعل','b' => true));
	} else if(isset($_POST['emaillogin'],$_POST['passlogin'],$_POST['g-recaptcha-response'])){
		if(antiSpam("login:login.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 's'=>'error', 'b'=>'موافق'));
		}
		$post = http_build_query(
			array (
				'response' => $_POST['g-recaptcha-response'],
				'secret' => $Config["SecreTreCAPTCHA"],
				'remoteip' => $_SERVER['REMOTE_ADDR']
			)
		);
		$opts = array('http' => 
				array (
					'method' => 'POST',
					'header' => 'application/x-www-form-urlencoded',
					'content' => $post
				)
		);
		$context = stream_context_create($opts);
		$response = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);
		if (!$result -> success) {
			returnJSON(array('tp' => 'error', 't' => 'خطأ','m' => 'رجاءَ تحقق من أنك لست روبوت','b' => true));
		}
		
		if(empty($_POST['emaillogin']) OR empty($_POST['passlogin'])){
			returnJSON(array('tp' => 'error', 't' => 'خطأ','m' => 'تاكد من المدخلات','b' => true));
		} else if(strlen($_POST['emaillogin']) > 260){
			returnJSON(array('tp' => 'error', 't' => 'خطأ','m' => 'تاكد من المدخلات','b' => true));
		} else if(strlen($_POST['passlogin']) > 36 || strlen($_POST['passlogin']) < 8){
			returnJSON(array('tp' => 'error', 't' => 'خطأ','m' => 'تاكد من المدخلات','b' => true));
		} else if (!filter_var($_POST['emaillogin'], FILTER_VALIDATE_EMAIL)) {
			returnJSON(array('tp' => 'error', 't' => 'خطأ','m' => 'تاكد من المدخلات','b' => true));
				

		} else {
                       $conn = Database::getInstance();
			if (filter_var($_POST['emaillogin'], FILTER_VALIDATE_EMAIL)) {
			$check = $conn->prepare("SELECT username,password,id FROM Customers WHERE email=:email");
			$check->bindValue(":email", $_POST['emaillogin']);
			$check->execute();
			}
			/*else{
			$check = $conn->prepare("SELECT verify,username,password,id FROM Customers WHERE username=:username");
			$check->bindValue(":username", $_POST['emaillogin']);
			$check->execute();
			}*/
			if($check->rowCount() !== 0){
				$row = $check->fetch();
				$id = $row['id'];
				$nm = $row['username'];
				$password = $row['password'];
				$passwordd = password_verify($_POST['passlogin'], $password);
				if($passwordd){
						$_SESSION['memberId:rpg'] = $id;
						$_SESSION['clientnickname'] = $nm;
						returnJSON(array('t' => 'حسناً','m' => 'تم تسجيل الدخول بنجاح.','tp' => 'success','name' => $nm, 'b' => false));	
				}else{
					returnJSON(array('t' => 'خطأ','m' => 'تفاصيل تسجيل الدخول الخاصة بك خاطئة ، حاول مرة أخرى.','tp' => 'error', 'b' => true));	
				}
			}else{
				returnJSON(array('t' => 'خطأ','m' => 'تفاصيل تسجيل الدخول الخاصة بك خاطئة ، حاول مرة أخرى.','tp' => 'error', 'b' => true));	
			}
		}
	}
}
?>