profileRefId = "profileRef"
loginRefId = "loginRef"


$(document).ready(function () {
	// Header Scroll
	$(window).on('scroll', function () {
		var scroll = $(window).scrollTop();

		if (scroll >= 50) {
			$('#header').addClass('fixed');
		} else {
			$('#header').removeClass('fixed');
		}
	});

	// Fancybox
	$('.work-box').fancybox();

	// Flexslider
	$('.flexslider').flexslider({
		animation: "fade",
		directionNav: false,
	});

	// Page Scroll
	var sections = $('section')
	nav = $('nav[role="navigation"]');

	$(window).on('scroll', function () {
		var cur_pos = $(this).scrollTop();
		sections.each(function () {
			var top = $(this).offset().top - 76
			bottom = top + $(this).outerHeight();
			if (cur_pos >= top && cur_pos <= bottom) {
				nav.find('a').removeClass('active');
				nav.find('a[href="#' + $(this).attr('id') + '"]').addClass('active');
			}
		});
	});
	nav.find('a').on('click', function () {
		var $el = $(this)
		id = $el.attr('href');
		$('html, body').animate({
			scrollTop: $(id).offset().top - 75
		}, 500);
		return false;
	});

	// Mobile Navigation
	$('.nav-toggle').on('click', function () {
		$(this).toggleClass('close-nav');
		nav.toggleClass('open');
		return false;
	});
	nav.find('a').on('click', function () {
		$('.nav-toggle').toggleClass('close-nav');
		nav.toggleClass('open');
	});
});

function showLogin(elementId) {
	const logOver = document.getElementById("login_overlay");
	logOver.style.display = "flex";
	logOver.classList.remove("opacity-show-animation");
	logOver.classList.add("opacity-show-animation");
}

function hideLogin() {
	const logOver = document.getElementById("login_overlay");
	logOver.classList.remove("opacity-hide-animation");
	logOver.classList.add("opacity-hide-animation");
	setTimeout(function () { logOver.style.display = "none"; logOver.classList.remove("opacity-hide-animation"); }, 500);
}

function animateShow(elementId) {
	const element = document.getElementById(elementId);
	element.style.display = "flex";
	element.classList.remove("opacity-show-animation");
	element.classList.add("opacity-show-animation");
}

function animateHide(elementId) {
	const element = document.getElementById(elementId);
	element.classList.remove("opacity-hide-animation");
	element.classList.add("opacity-hide-animation");
	setTimeout(function () { element.style.display = "none"; element.classList.remove("opacity-hide-animation"); }, 500);
}

function youShallNotPass() {
	document.body.innerHTML = `<div class="black-overlay" style="display: flex;" id="nopass_overlay">
	<div class="overlay-form banner-text text-center">
		<form method="post" action="">
			<h1>Вы кто такие? Я вас не звал</h1>
			<p>Это место для зарегистрированных пользователей</p>
			<p>Войдите в существующий аккаунт или зарегистрируйте новый</p>
			<h1 id="countdown">5</h1>
		</form>
	</div>
</div>` + document.body.innerHTML;
	mainPagecountdown("countdown", 5);
}

function mainPagecountdown(countdownViewId, time) {
	countdownView = document.getElementById(countdownViewId);
	//setInterval(function () { countdownView.innerHTML = time; if (time < 1) { window.location.replace("/index.php"); }; time--; }, 1000)
	setInterval(function() {
		time = time - 1;
		countdownView.innerHTML = time;
		if(time < 1) {
			window.location.replace("index.php");
		}
	},1000);
}
