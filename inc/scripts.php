<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.0/dist/sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="js/parsley.js"></script>
<script src="js/script.js"></script>

	  <script>
	  	const toast = swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000
		});

     $('#loginform').parsley();
     $("#loginform").submit(function(e) {
       e.preventDefault();
       var form = $(this);

       if($('#loginform').parsley().isValid())
       {
		 if (grecaptcha === undefined) {
			 new toast({
				type: 'info',
				title: 'من فضلك تحقق من أنك لست روبوت'
			});	
			throw new Error("Empty RECAPTCHA");
		}

		var response = grecaptcha.getResponse();
		if (!response) {
			 new toast({
				type: 'info',
				title: 'من فضلك تحقق من أنك لست روبوت'
			});	
			throw new Error("Robot Check");
		}

         sendData("login.php", form.serialize())
           .then(function(response)
           {
			 new toast({
				type: response.tp,
				title: response.m
			});	

             if(response.tp == 'error')
             {
				grecaptcha.reset();

             }
             else if(response.tp == 'success')
             {
    animateCSS(".dropdown", "fadeOut", function() {
      $(".dropdown").addClass("d-none");
    });
	    animateCSS(".dropdown", "fadeIn", function() {
      $(".dropdown").html(response.name);
	  $(".dropdown").removeClass("d-none");
    });


		 
     		 }else{
				grecaptcha.reset();
			 }
           });
       }
     });
</script>
