<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Portraits.ua</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/materialize.css" media="screen,projection">
	<style>
		.imgMediaInside {
			display: block;
			position: relative;
			border-radius: 0 0 10px 10px;
			width: 100%;
			height: 700px;
			margin-bottom: 5%;
			background-repeat: no-repeat;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			background-position: 50% 50%;
		}
		.imgMediaInsidePromoText{
			position: absolute;
			left: 50%;
			top: 50%;
			z-index: 1;
			color: white;
			font-size: 20px;
			transform: translate(-50%, -50%);
			-moz-transform: translate(-50%, -50%);
			-webkit-transform: translate(-50%, -50%);
			-o-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
		}

		nav {
			box-shadow: none;
			margin: 20px 0;
		}

		.black-text li a {
			color: #404040;
			font-size: 16px;
		}
		.fitImage {
			max-width: 100%;
		}
		.logo{
			height: 65px;
		}
		.linkDisabled {
			pointer-events: none;
			opacity: 0.6;
		}
		.materil-icon-custom {
		/color: #4527a0; /* фиолетовый */
			color: #afb42b; /* кислотный */
			font-size: 45px;
		}
		.promo-caption {
			color: #4527a0; /* фиолетовый */
			font-size: 20px;
			font-weight: bold;
		}

		.fitImage {
			max-width: 100%;
		}

		.colorLineBack {
			width: 100%;
			height: 10px;
			position: relative;
		}

		.noMargin {
			margin: 0;
			padding: 15px;
		}
		.footer-bar-fixed-bottom{
			position: absolute;
			bottom: 0;
			width: 100%;
			/*padding: 5px 5px 25px 5px;			*/
		}
		nav {
			box-shadow: none;
			margin: 20px 0;
		}

		.black-text li a {
			color: #404040;
			font-size: 16px;
		}
		.fitImage {
			max-width: 100%;
		}
		.logo{
			height: 65px;
		}
		.linkDisabled {
			pointer-events: none;
			opacity: 0.6;
		}
		.materil-icon-custom {
		/color: #4527a0; /* фиолетовый */
			color: #afb42b; /* кислотный */
			font-size: 45px;
		}
		.promo-caption {
			color: #4527a0; /* фиолетовый */
			font-size: 20px;
			font-weight: bold;
		}

		.fitImage {
			max-width: 100%;
		}

		.colorLineBack {
			width: 100%;
			height: 10px;
			position: relative;
		}

		.noMargin {
			margin: 0;
			padding: 15px;
		}
		.footer-bar-fixed-bottom{
			position: absolute;
			bottom: 0;
			width: 100%;
			/*padding: 5px 5px 25px 5px;			*/
		}
		.red {
			color: Red;
			background: none !important;
		}
		.card .card-action a:not(.btn):not(.btn-large):not(.btn-large):not(.btn-floating) {
			color: #4527a0;
		}

		.card .card-action a:not(.btn):not(.btn-large):not(.btn-large):not(.btn-floating):hover {
			color: #afb42b;
		}
		@media screen and (max-width: 1366px) {
			.imgMediaInsidePromo {
				width: 500px;
			}
		}

	</style>
</head>
<body>
<div id="page-wrapper"> <!-- page wrapper for footer calculate-->
	<header>
		<section class="container">
			<nav class="white">
				<div class="nav-wrapper">
					<a href="index.php" class="brand-logo"><img src="assets/logo/logo_ua.svg" class="logo"></a>
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons black-text" style="font-size: 35px;">menu</i></a>
					<ul class="right hide-on-med-and-down black-text">
						<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Про проект<i class="material-icons right">arrow_drop_down</i></a>
							<ul id="dropdown1" class="dropdown-content">
								<li><a href="project/about/index.html">Опис проекту</a></li>
								<li class="divider"></li>
								<li><a href="#">Умови участі</a></li>
								<li class="divider"></li>
								<li><a href="#">Реєстрація</a></li>
								<li class="divider"></li>
								<li><a href="#">Партнери</a></li>
							</ul>
						</li>
						<li class="linkDisabled"><a href="#">Банк портретів</a></li>
						<li><a class="dropdown-button" href="#!" data-activates="dropdown2">Довідкові матеріали<i class="material-icons right">arrow_drop_down</i></a>
							<ul id="dropdown2" class="dropdown-content">
								<li><a href="#">Словничок</a></li>
								<li class="divider"></li>
								<li><a href="#">Статті</a></li>
								<li class="divider"></li>
								<li><a href="#">Відео</a></li>
								<li class="divider"></li>
								<li><a href="#">Лекції</a></li>
								<li class="divider"></li>
								<li><a href="#">Виставки</a></li>
							</ul>
						</li>
						<li><a href="#">Контакти</a></li>
					</ul>
					<!-- мобильное меню -->
					<ul class="side-nav" id="mobile-demo">
						<li><a class="dropdown-button-mobile" href="#" data-activates="dropdown1-mobile">Про проект<i class="material-icons right">arrow_drop_down</i></a>
							<ul id="dropdown1-mobile" class="dropdown-content">
								<li><a href="project/about/index.html">Опис проекту</a></li>
								<li class="divider"></li>
								<li><a href="#">Умови участі</a></li>
								<li class="divider"></li>
								<li><a href="#">Реєстрація</a></li>
								<li class="divider"></li>
								<li><a href="#">Партнери</a></li>
							</ul>
						</li>
						<li class="linkDisabled"><a href="#">Банк портретів</a></li>
						<li><a class="dropdown-button-mobile" href="#" data-activates="dropdown2-mobile">Довідкові матеріали<i class="material-icons right">arrow_drop_down</i></a>
							<ul id="dropdown2-mobile" class="dropdown-content">
								<li><a href="#">Словничок</a></li>
								<li class="divider"></li>
								<li><a href="#">Статті</a></li>
								<li class="divider"></li>
								<li><a href="#">Відео</a></li>
								<li class="divider"></li>
								<li><a href="#">Лекції</a></li>
								<li class="divider"></li>
								<li><a href="#">Виставки</a></li>
							</ul>
						</li>
						<li><a href="#">Контакти</a></li>
					</ul>
					<!-- end мобильное меню -->
				</div>
			</nav>
		</section>
	</header>

<main>
	<section class="container">
		<div class="colorLineBack indigo darken-2"></div>
		<div class="indigo lighten-2"><h5 class="white-text noMargin">Банк портретів / Шулежко Олександра</h5></div>
	</section>

	<section class="container" style="margin-top: 30px; margin-bottom: 30px;">
		<div class="row">
			<div class="col s12 m12 l9">
				<div class="center card-panel matchheight grey lighten-4">
					<i class="material-icons materil-icon-custom">announcement</i>
					<h3 class="promo-caption">ПортретиUA</h3>
					<div class="left-align">
						<p>Освітня програма Національного музею історії України у Другій світовій війні. Меморіальний комплекс та партнерів.</p>
						<p>Метою проекту є залучення молоді до дослідження новітньої історії України. Через вивчення персональних історій учасники матимуть можливість ознайомитися з історією свого регіону та долею тих, хто різними шляхами та вчинками сприяв боротьбі з тоталітаризмом, відстоював демократичні та громадянські переконання, своїм прикладом втілював в життя ідеали миру та гуманізму. Детальне дослідження цих історій дасть змогу провести історичний та міжнародний ребрендінг виміру українського народу у подіях Другої світової війни.</p>
					</div>
				</div>
			</div>
			<div class="col s12 m12 l3">
				<div class="center card-panel matchheight grey lighten-4">
					<i class="material-icons materil-icon-custom">assignment</i>
					<h3 class="promo-caption">Завдання проекту</h3>
					<div class="left-align">
						<p>1. Підготовка досліджень (історичних портретів) про осіб пов’язаних з темою актуальної сесії проекту;</p>
						<p>2. Формування вітчизняної історичної наративної бази з теми дослідження;</p>
						<p>3. Комплектування фондів музею новими історичним артефактами;</p>
						<p>4. Залучення молоді до самостійного пошуку нових історичних фактів та подій, підготовка наукових досліджень та презентація їх результатів;</p>
						<p>5. За результатами сесії публікація документального видання «Портрети.UA».</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="container">
		<div class="row">
			<div class="col s12 m12 l12" style="margin-bottom: 70px;">
				<!-- disqus -->
				<div id="disqus_thread"></div>
				<script>

                    /**
                     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                    /*
					var disqus_config = function () {
					this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					};
					*/
                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document, s = d.createElement('script');
                        s.src = 'https://portraitsua.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
				</script>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				<!-- end of disqus -->
			</div>
		</div>
	</section>

</main>
</div> <!-- end of page wrapper -->

<footer class="page-footer lime darken-2">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">Footer Content</h5>
				<p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
			</div>
			<div class="col l4 offset-l2 s12">
				<!--<h5 class="white-text">Links</h5>
				<ul>
					<li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
					<li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
					<li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
					<li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
				</ul>-->
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			© 2017 Національний музей історії України у Другій світовій війні. Меморіальний комплекс.
		</div>
	</div>
</footer>

</body>

<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="assets/js/materialize.js"></script>
<script src="assets/js/jquery.matchHeight-min.js"></script>
<script id="dsq-count-scr" src="//portraitsua.disqus.com/count.js" async></script>
<script>
    $(document).ready(function () {
        $('.dropdown-button').dropdown({
                constrainWidth: true, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'left', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false // Stops event propagation
            }
        );
        $('.dropdown-button-mobile').dropdown({
                constrainWidth: true, // Does not change width of dropdown to that of the activator
                hover: false, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'left', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false // Stops event propagation
            }
        );
        $('.button-collapse').sideNav();
        $('.matchheight').matchHeight();
        stickyFooter();
        sizeImgMediaInside();

        function sizeImgMediaInside() {
            var windowHeight = window.innerHeight;
            var imgHeight = Math.round(windowHeight / 10 * 4);
            $('.imgMediaInside').height(imgHeight);
        }

        $(window).resize(function () {
            clearTimeout(t);
            var t = setTimeout(doAfterResize, 50);
        });

        function doAfterResize() {
            sizeImgMediaInside();
            stickyFooter();
        }
        function stickyFooter(){
            var footer = $(".page-footer");
            if( ($('#page-wrapper').outerHeight(true) + $(footer).outerHeight(true)) <= $(window).height() )
            {
                $(footer).addClass("footer-bar-fixed-bottom");
            }
            else{
                $(footer).removeClass("footer-bar-fixed-bottom");
            }
        }
    });
</script>
</html>