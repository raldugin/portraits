<?php
	require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/params.php');
	require_once (INCLUDES_DIR.'header.html');
?>
	<section class="container">
		<div class="colorLineBack indigo darken-2"></div>
		<div class="indigo lighten-2"><h5 class="white-text noMargin">Банк портретів / Шулежко Олександра</h5></div>
	</section>

	<section class="container" style="margin-top: 30px; margin-bottom: 30px;">
		<div class="row">
			<div class="col s12 m12 l9 xl9">

						<h5>Шулежко Олександра</h5>

				</div>

			<div class="col s12 m12 l3 xl3 pushpin_card">

					<div class="center card-panel grey lighten-4">
						<img src="/portraits/shulezhko/img/author/1.jpg" alt="" class="circle responsive-img responsive-img-size_50">

						<div class="center-align">
							<p>
								Колектив Нацмузею
								<br>
								м. Київ
							</p>
						</div>
					</div>
				<div class="video-container video-container-memory">
					<iframe width="853" height="480" src="https://www.youtube.com/embed/OSWAWEcRvbg?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>
				<div id="pushpin">
					<ul class="collapsible collapsible-size100" data-collapsible="accordion">
						<li>
							<div class="collapsible-header"><i class="material-icons">fingerprint</i>Артефакти</div>
							<div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
						</li>
						<li>
							<div class="collapsible-header"><i class="material-icons">theaters</i>Відео</div>
							<div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
						</li>
						<li>
							<div class="collapsible-header"><i class="material-icons">subject</i>Бібліотека</div>
							<div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
						</li>
						<li>
							<div class="collapsible-header linkTO" data-link="#comments"><i class="material-icons">comment</i>Коментарі</div>
						</li>
					</ul>
				</div>

			</div>


		</div>
	</section>

	<section id="comments" class="container">
		<div class="row">
			<div class="col s12 m12 l12" style="margin-bottom: 70px;">

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

			</div>
		</div>
	</section>

<?php
	include_once (INCLUDES_DIR.'footer.html');
?>