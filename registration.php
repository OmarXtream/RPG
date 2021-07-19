<?php 
include 'inc/header.php'; 
?>
<div class="wrapper">
  <div class="registrationP d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="content text-center">
        <div class="section animate" id="main">
          <h2>مرحلة التقديم</h2>
<?php


		$conn = Database::getInstance();
			$check=$conn->prepare('SELECT id,status FROM apply WHERE cid =:id');
			$check->bindParam(":id", $_SESSION['memberId:rpg'], PDO::PARAM_INT);
			$check->execute();
			if($check->rowCount() > 0 ){
			$order =$check->fetch(PDO::FETCH_ASSOC);
			$status = Cstatus($order['status']);
			}
		if($check->rowCount() > 0 and $order['status'] != 3){
?>
          <h5>حالة الطلب: <?=$status?> </h5>
          <br>
		  </div>
		<?php }else{ 
		if($check->rowCount() > 0 ){
		?>
	
          <h5>حالة الطلب: <?=$status?> </h5>
		  
		<?php } ?>
          <br>
          <button type="button" class="btn btn-secondary btn-lg" onclick="changeSection('main', 'form')">تقديم</button>
        </div>
        <form method="post" class="animate d-none" id="form" data-parsley-validate="" data-parsley-required-message="هذا الحقل مطلوب">
          <div class="form-row">
            <div class="col-md-12 mt-2">
						<?php 
	
			$statement = $conn->query('SELECT id,text FROM questions ORDER BY id ASC');
			
$counter = 0; 
$countit = $statement->rowCount();
$last = $countit - 1;
				if($statement->rowCount() == 0){
					echo'No questions at the moment';
				}else{
					foreach($statement as $key => $q){
					$QID = (int)$q['id'];
					$QIDmm = $QID - 1;
					$QIDm = 'qe'.$QIDmm;
					$QIDp = $QID + 1;
					$Qtext = htmlspecialchars($q['text']);
					
			if($QID == 1){
				$QIDm = 'main';
				$QIDf = 'form';
				$div='<div class="form-group animate" id="qe'.$QID.'">';
			}else{
			$QIDf = 'qe'.$QID;
			$div = '<div class="form-group animate d-none" id="qe'.$QID.'">';	
			}
?>

              <?=$div?>
                <h3> السؤال <?=$QID?></h3>
                <h5><?=$Qtext?></h5>
                <textarea name="<?=$QID?>" id="<?=$QID?>" class="form-control" placeholder="الإجابة" required></textarea>
                <br>
                <button type="button" class="btn btn-outline-secondary btn-lg" onclick="changeSection('<?=$QIDf?>', '<?=$QIDm?>')">العودة</button>
		<?php if( $counter == $last) { ?>
				<button type="submit" class="btn btn-success btn-lg">تقديم</button>
		<?php }else{ ?>
                <button type="button" class="btn btn-secondary btn-lg" onclick="changeSection('qe<?=$QID?>', 'qe<?=$QIDp?>')">التالي</button>
		<?php } ?>
				
              </div>

			  
			  
<?php
    $counter = $counter + 1; 

						
					}
			
			
				}
			?>
            </div>
          </div>
        </form>
		
		<?php } ?>
      </div>
    </div>
  </div>

  <?php
    include 'inc/footer.php';
    include 'inc/scripts.php'
   ?>
</div>
<script>
     $('#form').parsley();
     $("#form").submit(function(e) {
       e.preventDefault();
       var form = $(this);
       if($('#form').parsley().isValid())
       {
         sendData("question.php", form.serialize())
           .then(function(response)
           {
             Swal.fire(
               {
                 title: response.t,
                 text: response.m,
                 type: response.tp,
                 showConfirmButton: response.b,
                 confirmButtonText: 'حسناً'
               });

             if(response.tp == 'error')
             {

             }
             else if(response.tp == 'success')
             {
               $('#form')[0].reset();
               $('#form').parsley().reset();
			   setTimeout(function () { location.href = "./";}, 3000);
             }
           });
       }else{
		   
		      Swal.fire(
               {
                 title: 'فضلا',
                 text: 'تأكد من المدخلات',
                 type: 'info',
                 confirmButtonText: 'حسناً'
               });

	   }
     });
</script>

<?php include 'inc/end.php' ?>
