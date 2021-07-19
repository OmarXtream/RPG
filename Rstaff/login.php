<?php
require_once("../inc/config.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.name','STAFFSESSID');
    ini_set('session.cookie_httponly', true);
	ini_set('session.cookie_domain', '.'.$Config['domain'].'');
    session_start();
}
$nohead = true;
$amstaff = true;
require_once("../inc/db.php");

if(isset($_SESSION['staffId:rpg'])){
	exit(header('Location: index'));
}


$_SESSION['_token']=bin2hex(openssl_random_pseudo_bytes(16));
require_once("inc/header.php");

?>
<div class="wrapper">

  <div class="register d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="content text-center">
        <img src="../imgs/logob.png" alt="Logo">
			<h3> Staff Login </h3>
		  <form id="login" data-parsley-validate="" data-parsley-required-message="هذا الحقل مطلوب">
          <div class="form-row">
            <div class="col-md-12 mt-3">
              <input type="email" class="form-control" name="email" id="email" placeholder="البريد الإلكتروني" data-parsley-trigger="keyup" data-parsley-type="email" data-parsley-type-message="يجب عليك كتابة إيميل صحيح " required>
            </div>
            <div class="col-md-12 mt-3">
              <input type="password" class="form-control" name="password" id="password" placeholder="كلمة السر" data-parsley-trigger="keyup" required >
            </div>
            <div class="col-md-12 mt-3">
              <div id="recaptcha" class="g-recaptcha" data-sitekey="<?=$Config["reCAPTCHA"];?>"></div>
            </div>

            <div class="col-md-12 mt-3">
              <button type="submit" class="active">دخول</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
    include '../inc/footer.php';
    include '../inc/scripts.php'
   ?>
</div>
		<?php if(isset($_GET['timeout']) && $_GET['timeout'] == 1){ ?><script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script> <?php } ?>

<script>
		<?php if(isset($_GET['timeout']) && $_GET['timeout'] == 1){ ?>
		alertify.logPosition("top right");
		alertify.error("تم تسجيل خروجك بنجاح، نظرًأ لعدم تفاعلك سجل مجددا!");
		<?php } ?>

     $('#login').parsley();
     $("#login").submit(function(e) {
       e.preventDefault();
       var form = $(this);

       if($('#login').parsley().isValid())
       {
		 if (grecaptcha === undefined) {
			Swal.fire({
			  title: "خطأ",
			  text: "من فضلك تحقق من أنك لست روبوت",
			  type: "error"
			});
			throw new Error("Empty RECAPTCHA");
		}

		var response = grecaptcha.getResponse();
		if (!response) {
			Swal.fire({
				title: "خطأ",
				text: "من فضلك تحقق من أنك لست روبوت",
		     	type: "error"
			});
			throw new Error("Robot Check");
		}

         sendData("login.php", form.serialize())
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
				grecaptcha.reset();

             }
             else if(response.tp == 'success')
             {
			   setTimeout(function () { location.href = "./";}, 3000);
             }else{
				grecaptcha.reset();
			 }
           });
       }
     });
</script>

<?php include '../inc/end.php' ?>
