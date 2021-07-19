<?php require_once("inc/header.php");?>


      <?php
	    include 'staff/info.php';
        include 'staff/nav.php';
       ?>

      <div class="adminS">
        <?php
          include 'staff/applicants.php';
          include 'staff/accepted.php';
          include 'staff/rejected.php';
          include 'staff/donors.php';
          include 'staff/questions.php';
          include 'staff/search.php';
         ?>
      </div>
    </div>
  </div>
  <?php
    include '../inc/footer.php';
    include '../inc/scripts.php';
   ?>
</div>
<script>

$(document).ready( function () {
    $('.js-dataTable-full').DataTable();
} );

function getinfo(id){
	
	         sendData("getinfo.php","id="+id,'GET')
           .then(function(response)
           {
			 new toast({
				type: response.tp,
				title: response.m
			});	

             if(response.tp == 'error')
             {

             }
             else if(response.tp == 'success')
             {

Swal.fire({
  title: '<strong>إجابات '+response.name+' </strong>',
  html: response.info
});

		 
     		 }
           });
       }
	   
	  function switcher(id,to){
	
	         sendData("switcher.php","id="+id+"&to="+to)
           .then(function(response)
           {
			 new toast({
				type: response.tp,
				title: response.m
			});	

             if(response.tp == 'error')
             {

             }
             else if(response.tp == 'success')
             {
           animateCSS(".ap-"+id, "fadeOut", function() {
      $(".ap-"+id).addClass("d-none");
    });

		 
     		 }
           });
       }
	   
	   
	   
	   
	   function edit(tid){
	new swal({
		title: 'قم بإدخال السؤال الجديد',
		type: 'question',
		input: 'textarea',
		inputPlaceholder: 'انت وش انت .؟',
		showCancelButton: true,
		confirmButtonText: 'تعديل',
		cancelButtonText: 'إلغاء الأمر',
		showLoaderOnConfirm: true,
		inputValidator: (value) => {
			return !value && 'من فضلك ادخل السؤال'
		},
		preConfirm: (text) => {
			return fetch(`ajax/Qedit`, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				redirect: "follow",
				body: "newtext="+text+"&id="+tid+"&token="+document.getElementsByTagName('meta')["token"].content
			}).then(response => {
				if(response.value.tp == 'error'){
					Swal.showValidationError("من فضلك تأكد من القيم المرسلة.")
				} else if(response.value.tp == 'warning'){
					Swal.showValidationError("من فضلك انتظر قليلا ثم حاول مجدداً")
				}
				return response.json()
			  });
		 },
		inputAttributes: {
			autocapitalize: 'off',
			autocorrect: 'off'
		},
		allowOutsideClick: () => !swal.isLoading()
	}).then((result) => {
		if(typeof result.value.updatetoken != 'undefined'){
			document.getElementsByTagName('meta')["token"].content = result.value.updatetoken;
		}
		if(result.value.done){
		toast({
			 type: result.value.tp,
			 title: '<b>'+result.value.m+'</b>',

		});

		}
	});
}


</script>
<?php include '../inc/end.php' ?>
