<?php
ini_set('session.cookie_httponly', true);
ini_set('session.cookie_secure', true);
session_name('__Secure-PHPSESSID');

session_start();
require_once("../inc/db.php");
require_once("../inc/functions.php");
#require_once("../inc/vendor/autoload.php");

#use PHPMailer\PHPMailer\PHPMailer;
#use PHPMailer\PHPMailer\Exception;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	} else if (isset($_SESSION['memberId:rpg'])) {
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => '.حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	} else if(isset($_POST['username'],$_POST['password'],$_POST['email'],$_POST['g-recaptcha-response'])){
		if(antiSpam("register:reg.php")){
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
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);
		if (!$result -> success) {
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'رجاءَ تحقق من أنك لست روبوت','b' => true));
		}
		
	if(empty($_POST['username']) OR empty($_POST['password']) OR empty($_POST['email']) ){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'تاكد من المدخلات','b' => true));
	}elseif(!preg_match("/^[A-Za-z0-9_]+$/", (string)$_POST['username'])){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يحتوي الإسم على حروف إنجليزية وارقام','b' => true));
	}elseif(strlen($_POST['username']) < 3 || strlen($_POST['username']) > 16){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يكون اسم المستخدم مكون من 3 حروف ولا يتعدى 16 حرف','b' => true));
	}elseif(!password_strength($_POST['password'])){
		returnJSON(array('isSuccess' => false,'tp' => 'error','t' => 'خطأ','m' => 'يجب إن تحتوي كلمة المرور على حروف كبيرة وصغيره وأرقام.','s' => 'error', 'b' => 'موافق'));	
	}elseif(strlen($_POST['password']) > 36 || strlen($_POST['password']) < 8){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن تكون كلمة مرورك أكبر من 8 إحرف ولا تتعدى 36 حرف','b' => true));
	}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يكون بريد الإلكتروني الخاص بك صحيح. يرجى التأكد','b' => true));
	}else{
		
              $conn = Database::getInstance();
		$stmt=$conn->prepare("SELECT username,email FROM Customers WHERE username=:user or email=:email");
		$stmt->bindValue(":user", $_POST['username']);
		$stmt->bindValue(":email", $_POST['email']);
		$stmt->execute();
		
		if($stmt->rowCount() == 0){
			$passwordHashed=password_hash($_POST['password'], PASSWORD_DEFAULT);
			$stmtz=$conn->prepare("INSERT INTO Customers (username,password,email,createdTime) VALUES (:username,:password,:email,".time().")");
			$stmtz->bindValue(":username", $_POST['username']);
			$stmtz->bindValue(":password", $passwordHashed);
			$stmtz->bindValue(":email", $_POST['email']);
			$stmtz->execute();
			
			if($stmtz->rowCount() > 0){
				$_SESSION['account'] = true;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['email'] = $_POST['email'];

				
				/*ob_start();
				include_once 'email/index.php';
				$body = ob_get_clean();
				$mail = new PHPMailer();
				$mail->CharSet = 'UTF-8';
				$mail->isSMTP();
						$mail->Host = $Config['Mailhost'];
						$mail->SMTPAuth = true;
						$mail->Username = $Config['MailUserName'];
						$mail->Password = $Config['MailPassword'];
						$mail->SMTPSecure = 'tls';
						$mail->Port = $Config['MailPort'];
						$mail->setFrom("support@".$Config['domain']."", 'Masafat');
				$mail->addAddress($_POST['email'], $_POST['username']);
				$mail->isHTML(true);
				$mail->Subject = 'Confirm your  account, '.$_POST['username'];
				$mail->MsgHTML($body);
				if(!$mail->send()) {
					$stmtq=$conn->prepare("DELETE FROM Customers WHERE username=:username");
					$stmtq->bindValue(":username", $_POST['username']);
					$stmtq->execute();

					returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدثت مشكلة إثناء إرسال رسالة تاكيد لبريدك الإلكتروني يرجى مراجعة الإدارة','b' => true));
				} else {
				}*/
				
				returnJSON(array('tp' => 'success', 't' => 'حسنآ', 'm' => 'تم تسجيل حسابك بنجاح , سجل دخولك الآن','b' => true));

			}
			
		}else{
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'إسم المستخدم أو البريد الإلكتروني مستخدم مسبقاً','b' => true));
		}
		
	}
} else {}}
?>