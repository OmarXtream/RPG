<?php
$withOutProtection = true;
$nologin = true;
include 'inc/header.php';
?>
<div class="wrapper">

  <div class="register d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="content text-center">
        <img src="imgs/logob.png" alt="Logo">
		  <form id="registerform" data-parsley-validate="" data-parsley-required-message="هذا الحقل مطلوب">
          <div class="form-row">
            <div class="col-md-12 mt-2">
              <input type="text" class="form-control" name="username" id="username" placeholder="الإسم الكامل"  data-parsley-trigger="keyup" data-parsley-minlength="6" data-parsley-minlength-message="يجب عليك كتابة ستة أحرف على الأقل" required>
            </div>

            <div class="col-md-12 mt-3">
              <input type="email" class="form-control" name="email" id="email" placeholder="البريد الإلكتروني" data-parsley-trigger="keyup" data-parsley-type="email" data-parsley-type-message="يجب عليك كتابة إيميل صحيح " required>
            </div>

            <div class="col-md-12 mt-3">
              <input type="password" class="form-control" name="password" id="password" placeholder="كلمة السر" data-parsley-trigger="keyup" required >
            </div>

            <div class="col-md-12 mt-3">
              <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="تأكيد كلمة السر" data-parsley-trigger="keyup" data-parsley-equalto="#password" data-parsley-erorr-message="كلمات السر لا تتطابق" required>
            </div>

            <div class="col-md-12 mt-3">
              <div id="recaptcha" class="g-recaptcha" data-sitekey="<?=$Config["reCAPTCHA"];?>"></div>
            </div>

            <div class="col-md-12 mt-3">
              <button type="submit" class="active">تسجيل</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
    include 'inc/footer.php';
    include 'inc/scripts.php'
   ?>
</div>
<script>
     $('#registerform').parsley();
     $("#registerform").submit(function(e) {
       e.preventDefault();
       var form = $(this);

       if($('#registerform').parsley().isValid())
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

         sendData("req.php", form.serialize())
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

<?php include 'inc/end.php' ?>
