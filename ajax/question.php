<?php
require_once("../inc/req.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	}
	
		if(antiSpam("open:apply.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 's'=>'error', 'b'=>'موافق'));
		}
		
		
		$conn = Database::getInstance();
	    $stmt = $conn->query("SELECT id FROM apply WHERE cid={$_SESSION['memberId:rpg']} AND status != 3");
		if($stmt->rowCount() > 0){
			returnJSON(array('t' => 'خطأ','m' => 'لا يمكنك التقديم الآن','tp' => 'error','b' => true));
		}

		foreach ( $_POST as $key => $value ) {
      if(empty($value)){
		returnJSON(array('t' => 'خطأ','m' => 'تأكد من المدخلات!','tp' => 'error','b' => true));
	     }
		 if($key != 'token'){
		    $stmt2 = $conn->prepare("SELECT id FROM questions WHERE id = :theid");
			$stmt2->bindValue(':theid', $key);
			$stmt2->execute();
				if($stmt2->rowCount() == 0){
                 returnJSON(array('t' => 'خطأ','the' =>$key,'m' => 'تأكد من المدخلات!','tp' => 'error','b' => true));
                }
				
		 }
        }
		
		$insertData = $conn->prepare("INSERT INTO apply (cid, createdTime) VALUES (:creator,".time().")");
		$insertData->bindValue(':creator', $_SESSION['memberId:rpg']);
		$insertData->execute();
	 if($insertData->rowCount() > 0){
		  
		 foreach ( $_POST as $key => $value ) {
		 if($key != 'token'){

		$insertData2 = $conn->prepare("INSERT INTO answers (QID,cid,answer,createdTime) VALUES (:q,:creator,:an,".time().")");
		$insertData2->bindValue(':q', $key);
		$insertData2->bindValue(':creator', $_SESSION['memberId:rpg']);
		$insertData2->bindValue(':an', $value);
		$insertData2->execute();

		  
		  
	    }
		 
		 
		}
		returnJSON(array('t' => 'حسناً','m' => 'تم التقديم بنجاح.','tp' => 'success','b' => false));	

		}else{
			
	     returnJSON(array('t' => 'خطأ','m' => 'تأكد من المدخلات','tp' => 'error','b' => true));

		}
		
	

}
?>