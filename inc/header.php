<?php
if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}
require 'req.php';
if(isset($nologin)){
	
	if(isset($_SESSION['memberId:rpg'])){
	exit(header('Location: index'));
}else if(isset($_SESSION['account'])){
	exit(header('Location: index'));
}else{}

	
}
if(isset($_SESSION['memberId:rpg'])){ 

$conn = Database::getInstance();
$sql = $conn->query("SELECT username,email,rank,createdTime FROM Customers WHERE id='{$_SESSION['memberId:rpg']}'");

if($sql->rowCount() > 0){
	
	$row = $sql->fetch();
		$clientnickname = htmlspecialchars($row['username']);
		$clientemail = htmlspecialchars($row['email']);
		$clientrank = (int)$row['rank'];
		$clienttime = $row['createdTime'];
}
}

if(!isset($_SESSION['_token'])) {
$_SESSION['_token']=bin2hex(openssl_random_pseudo_bytes(16));
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <link rel="stylesheet" href="css/style.css">
	<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>

        <meta name="description" content="<?=$Config["description"];?>">
        <meta name="author" content="Masafat">
        <meta name="token" content="<?php if(isset($_SESSION['_token'])) { echo $_SESSION['_token']; } ?>">
        <meta property="og:title" content="<?=$Config["title"];?>">
        <meta property="og:site_name" content="<?=$Config["title"];?>">
        <meta property="og:description" content="<?=$Config["description"];?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="Masafat.co">
        <meta property="og:image" content="<?=$Config["icon"];?>">
        <link rel="shortcut icon" href="<?=$Config["icon"];?>">
        <link rel="icon" href="<?=$Config["icon"];?>">
        <link rel="apple-touch-icon-precomposed" href="<?=$Config["icon"];?>">

    <title><?=$Config["title"];?></title>
  </head>
  <body>
    <div class="toTop d-none" id="totop">
      <i class="fas fa-arrow-up"></i>
    </div>
    <div class="preload d-flex justify-content-center align-items-center">
      <div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
    </div>
	
	<!-- Start Nav -->
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="index"><img src="imgs/logo.png" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarList" aria-controls="navbarList" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarList">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index">الرئيسية</a>
        </li>
<?php if(isset($index)) { ?>
        <li class="nav-item">
          <a class="nav-link" href="#aboutus">من نحن</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#launcher">اللانشر</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#rules">القوانين</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#registration">التقديم</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#donation">الدعم</a>
        </li>

<?php } ?>
        <li class="nav-item">
          <a href="https://discord.gg/pyMK9yB" target="_blank" class="nav-link">الدسكورد</a>
        </li>
<?php if(isset($_SESSION['memberId:rpg'])){ ?>
		<li class="nav-item">
          <a href="logout" class="nav-link">تسجيل الخروج</a>
        </li>
		<?php
				if(rankPermission($_SESSION['memberId:rpg'],1)){
				?>
		        <li class="nav-item">
                 <a href="Rstaff" class="nav-link"><i class="fa fa-user-cog"></i> التحكم</a>
				</li>
				<?php }?>

<?php } ?>
      </ul>
<?php if(!isset($_SESSION['memberId:rpg']) and !isset($nologin)){ ?>
      <div class="dropdown">
        <a href="#" class="navLogin" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">تسجيل دخول</a>
        <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="dLabel">
		  <form class="px-4 py-3 clearfix" id="loginform" data-parsley-validate="" data-parsley-required-message="هذا الحقل مطلوب">

            <div class="form-group">
              <label for="emaillogin">البريد الإلكتروني</label>
              <input type="email" class="form-control" name="emaillogin" id="emaillogin" data-parsley-trigger="keyup" data-parsley-type="email" data-parsley-type-message="يجب عليك كتابة إيميل صحيح " required>
            </div>
            <div class="form-group">
              <label for="passwordlogin">كلمة المرور</label>
              <input type="password" class="form-control" name="passlogin" id="passlogin" data-parsley-trigger="keyup" required>
            </div>

	          <div class="form-group">
			        <div class="g-recaptcha" data-sitekey="<?=$Config["reCAPTCHA"];?>"></div>
            </div>

            <button type="submit" class="btn btn-primary float-right">تسجيل دخول</button>
          </form>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="register">لا تملك حساب؟</a>
        </div>
      </div>
<?php 
}else{
	if(isset($clientnickname)){
echo $clientnickname;
	}
}
?>
    </div>
  </div>
</nav>
<!-- End Nav -->