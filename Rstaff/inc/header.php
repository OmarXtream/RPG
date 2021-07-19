<?php
error_reporting(0);
if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}
if(!isset($nohead)){
	
$amstaff = true;
require_once("req.php");

	
	$conn= Database::getInstance();	
$homeInfo= $conn->query('Select (select count(*) from apply WHERE status = 1) as Py, (select count(*) from apply WHERE status = 2) as Paccept, (select count(*) from apply WHERE status = 3) as Preject, (select count(*) from donations) as donaters')->fetch();
$All = $conn->query('SELECT p.id AS id,p.status,p.cid,c.email,c.id AS coid,c.username FROM apply p LEFT JOIN Customers c ON p.cid = c.id ORDER BY p.id ASC');
$allp = $conn->query('SELECT p.id AS id,p.status,p.cid,c.email,c.id AS coid,c.username FROM apply p INNER JOIN Customers c ON p.cid = c.id AND p.status = 1 ORDER BY p.id ASC ');
$AAccept = $conn->query('SELECT p.id AS id,p.status,p.cid,c.email,c.id AS coid,c.username FROM apply p INNER JOIN Customers c ON p.cid = c.id AND p.status = 2 ORDER BY p.id ASC ');
$AReject = $conn->query('SELECT p.id AS id,p.status,p.cid,c.email,c.id AS coid,c.username FROM apply p INNER JOIN Customers c ON p.cid = c.id AND p.status = 3 ORDER BY p.id ASC ');
$questions = $conn->query('Select * FROM questions ORDER BY ID ASC');
$dons = $conn->query('Select id,email,discord,amount FROM donations ORDER BY ID ASC');

$clientData=$conn->query("SELECT rank,username FROM Customers WHERE id={$_SESSION['staffId:rpg']} and isStaff = 1");
	
if($clientData->rowCount() > 0){
		$row = $clientData->fetch();
		$username=htmlspecialchars($row["username"]);
		$img='https://png.icons8.com/color/128/000000/user-male-circle.png';
		$rank=(int)$row["rank"];
} else { exit; }
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	
    <link rel="stylesheet" href="../css/style.css">
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

    <title>RPG &bull; Staff</title>
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
    <a class="navbar-brand" href="index"><img src="../imgs/logo.png" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarList" aria-controls="navbarList" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarList">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index">الرئيسية</a>
        </li>
        <li class="nav-item">
          <a href="https://discord.gg/pyMK9yB" target="_blank" class="nav-link">الدسكورد</a>
        </li>
		<?php if(isset($_SESSION['staffId:rpg'])){ ?>
		<li class="nav-item">
          <a href="logout" class="nav-link">تسجيل الخروج</a>
        </li>
		<?php } ?>
      </ul>
<?=$username;?>

    </div>
  </div>
</nav>
<!-- End Nav -->