$(document).ready(function() {
    setTimeout(function(){
        animateCSS('.preload', 'fadeOut', function() {
          $('body').css('overflow', 'auto');
          $('.preload').addClass('v-none');
        });
    }, 2000); //Incase errors or low speed.
});

$(function () {
  'use strict';

  var wH = $(window).height(),
      navH = $('.navbar').innerHeight(),
      footerH = 0;
    $('.main').height(wH - (navH)+100);
    $('.register, .registrationP, .admin').css('min-height', (wH - navH));
    // $('.register, .registrationP').height(wH - navH);

  $('.rules .rChoose, .admin .aChoose').on('click', function () {
    $(".rules .rChoose, .admin .aChoose").removeClass("active");
    $(this).addClass('active');
    var tog = $(this).data("class");
    animateCSS(".rules .rulesS, .admin .adminS", "fadeOut", function() {
      $(".rules .rulesP, .admin .adminP").addClass("d-none");
      $(tog).removeClass("d-none");
      animateCSS(tog, "fadeIn");
    });
  });
});

var btn = $('#totop');
$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.removeClass('d-none');
  } else {
    btn.addClass('d-none');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

$(document).ready(function(){



  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 250, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});

function animateCSS(element, animationName, callback) {
    const node = document.querySelector(element)
    node.classList.add('animated', animationName)

    function handleAnimationEnd() {
        node.classList.remove('animated', animationName)
        node.removeEventListener('animationend', handleAnimationEnd)

        if (typeof callback === 'function') callback()
    }

    node.addEventListener('animationend', handleAnimationEnd)
}

function changeSection(a, b) {
	animateCSS("#"+a, "fadeOut", function() {
		$('#'+a).addClass("d-none");
		$('#'+b).removeClass("d-none")
		animateCSS("#"+b, "fadeIn");
	});
}


 	var xmlhttp;
	var token=document.getElementsByTagName('meta')["token"].content;
	var ajax_location = 'ajax/';

  function handleResponse(response) {
  	response.then(function(response) {
  		if(typeof response.updatetoken != 'undefined') {
  			document.getElementsByTagName('meta')["token"].content = response.updatetoken;
  		}
  	});
  	return response;
  }

  function sendData(url = ``, data = '', method = 'POST',token = true) {
  	if(token){
  		data = data+'&token='+document.getElementsByName('token')[0].getAttribute('content');
  	}
      if(method == 'POST'){
      return fetch(ajax_location + url, {
          method: method, // *GET, POST, PUT, DELETE, etc.
          mode: "cors", // no-cors, cors, *same-origin
          cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
          credentials: "same-origin", // include, same-origin, *omit
          headers: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          redirect: "follow", // manual, *follow, error
          body: data // body data type must match "Content-Type" header
      })
      .then(response => handleResponse(response.json())); // parses response to JSON
      } else if(method == 'GET'){

          return fetch(ajax_location + url + '?' + data).then(response => handleResponse(response.json()));
      }
  }

	if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
	} else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	

	
