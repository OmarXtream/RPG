<?php 
$withOutProtection = true;
$index = true;
require_once('inc/req.php');
$req = true;
require_once('inc/class/paypal.php');
require_once('inc/class/httprequest.php');
if(isset($_POST['checkout'],$_POST['price'],$_POST['discord']) and !empty($_POST['discord'])){
		$prices = array(5,10,20,30,40,50,100);
	if(in_array((int)$_POST['price'],$prices) and ctype_digit($_POST['price'])){
		$price = (int)$_POST['price'];
		$_SESSION['hisdiscord'] = $_POST['discord'];
		$r = new PayPal(true);
		$ret = ($r->doExpressCheckout($price, ' التبرع ب '.$price.' '));
	}else{
		$error[3] == true;
	}
}
if(isset($_GET['token'],$_GET['PayerID'])){
$r = new PayPal(true);


$final = $r->doPayment();

if ($final['ACK'] == 'Success') {
	$response = $r->getCheckoutDetails($final['TOKEN']);
$db = Database::getInstance();
$price = str_replace("|USD|", "", $response['CUSTOM']);
$stmtz=$db->prepare("INSERT INTO donations (amount,email,discord,token,payerid,country,time) VALUES (:price,:email,:discord,:token,:pid,:cc,".time().")");
$stmtz->bindValue(":price", $price);
$stmtz->bindValue(":email", $response['EMAIL']);
$stmtz->bindValue(":discord", $_SESSION['hisdiscord']);
$stmtz->bindValue(":token", $response['TOKEN']);
$stmtz->bindValue(":pid", $response['PAYERID']);
$stmtz->bindValue(":cc", $response['COUNTRYCODE']);

$stmtz->execute();


$_SESSION['buystatus'] = 'success';
} else {
$_SESSION['buystatus'] = 'error';
}
}elseif(isset($_GET['token'])){
}

require_once("inc/header.php");
if(isset($error[3]) && $error[3]){ ?>
		<script>
const toast = swal.mixin({
  toast: true,
  position: 'bottom-left',
  showConfirmButton: false,
  timer: 3000
});

toast({
  type: 'info',
  title: 'من فضلك تأكد من المدخلات'
})
</script>
<?php
}
?>




<div class="wrapper">
  <?php
    require_once 'sections/main.php';
    require_once 'sections/aboutus.php';
    require_once 'sections/launcher.php';
    require_once 'sections/rules.php';
    require_once 'sections/registration.php';
    require_once 'sections/donation.php';
    require_once 'inc/footer.php';
    require_once 'inc/scripts.php';
   ?>
 </div>
 <?php 
if(isset($_SESSION['buystatus']) and  $_SESSION['buystatus'] == 'success'){

 ?>
 <script>
 Swal.fire({
  type: 'success',
  title: "شكرا لك! , لقد قمت بتبرع ب <?=$price?>$ .",
  showConfirmButton: false,
  timer: 4000
});
</script>
<?php
unset($_SESSION['buystatus']);
}elseif(isset($_SESSION['buystatus']) and  $_SESSION['buystatus'] != 'success'){
?>

		<script>
			new toast({
				type: 'info',
				title: 'فشلت العملية'
			});	
		</script>
<?php
unset($_SESSION['buystatus']);
}
?>

		<?php if(isset($_GET['status']) && $_GET['status'] == 1){ ?>	
		<script>
			new toast({
				type: 'info',
				title: 'فضلا قم بتسجيل الدخول'
			});	
		</script>
		<?php } ?>
<?php require_once 'inc/end.php' ?>
