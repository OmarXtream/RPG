<?php
$amstaff = true;
require_once("../../inc/db.php");
require_once("../../inc/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	if(!isset($_SESSION['_token']) OR !isset($_GET['token']) OR $_GET['token'] != $_SESSION['_token']){
		returnJSON(array('t'=>'خطأ', 'm'=>'حدث خطأ غير متوقع ، رجاءً قم بتحديث الصفحة.', 'tp'=>'error'));
	}

	if(isset($_GET['id'],$_SESSION['staffId:rpg'])){
			if(antiSpam('staffInfo:info')){
				returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => 'موافق'));		
			} else	if(!ctype_digit($_GET['id']) OR strlen($_GET['id']) > 32 OR filter_var($_GET['id'], FILTER_VALIDATE_INT) === false){
				returnJSON(array('t' => 'خطأ','m' => 'محاولة جيدة، نرجو عدم تكرارها','tp' => 'error','b' => 'موافق'));		
			}
	        $conn= Database::getInstance();	
			$check = $conn->prepare("SELECT cid FROM apply WHERE id= :id");
			$check->bindValue(":id", $_GET['id']);
			$check->execute();
			if($check->rowCount() > 0){
				$dataCheck=$check->fetch();
				$user =(int)$dataCheck["cid"];
				$fetch = $conn->query("SELECT username FROM Customers WHERE id= ".$user."")->fetch();
                $username = htmlspecialchars($fetch['username']);
				
				
		        $stmt = $conn->query("Select QID,answer FROM answers WHERE cid= ".$user." ORDER BY QID ASC");
				if($stmt->rowCount() == 0){
                 returnJSON(array('t' => 'خطأ','the' =>$key,'m' => 'لم يتم العثور على إجابات!','tp' => 'error','b' => true));
                }else{
				$qs = $stmt->fetchAll();
				}
				
				
				
    $form = "<p style='text-align: right !important'>";
    foreach($qs as $key){
        $form .= '
		<h5> السؤال '.$key['QID'].'</h5> 
<br> '.$key['answer'].' <br><br>
		
		';
    }
    $form .= '</p>';



				
				returnJSON(array('tp' => 'success','name' => $username,'m' => 'تم الاستدعاء', 'info' => $form));
			} else {
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'لم يتم العثور على الشخص ...'));
			}
	}
}



?>