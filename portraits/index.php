<?php
	//require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/params.php');
    //require_once (INCLUDES_DIR.'arrays.php');
    //require_once (INCLUDES_DIR.'header.html');
    require_once '../includes/params.php';
    require_once '../includes/arrays.php';
    require_once '../includes/header.html';
?>



<section class="container-fluid">
    <div class="colorLineBack deep-purple darken-3"></div>
    <div class="indigo lighten-2">
        <div class="container">
            <h5 class="white-text noMargin">Банк портретів</h5>
        </div>
    </div>
</section>

<!--<div class="tmpBlock">
    skew block
</div>-->

	<section class="container" style="margin-top: 30px; margin-bottom: 30px;">
		<div class="row">
			<div class="col s12 m8 l8">
				<div class="card-panel grey lighten-4 matchheight " style="padding-top: 10px; padding-bottom: 10px;">
					<div class="left-align">
						<p>Метою проекту є залучення молоді до дослідження новітньої історії України. Через вивчення персональних історій учасники матимуть можливість ознайомитися з історією свого регіону та долею тих, хто різними шляхами та вчинками сприяв боротьбі з тоталітаризмом, відстоював демократичні та громадянські переконання, своїм прикладом втілював в життя ідеали миру та гуманізму. Детальне дослідження цих історій дасть змогу провести історичний та міжнародний ребрендінг виміру українського народу у подіях Другої світової війни.</p>
					</div>
				</div>
			</div>
			<div class="col s12 m4 l4">
				<div class="row">
					<div class="card-panel white z-depth-0 matchheight" style="padding-top: 0;">
                        <?php
                        $alphabetCount = count($alphabet_DataBase);
                        for ($i=0; $i<$alphabetCount; $i++)
                        {
                            $button = checkAlphabets($alphabet_DataBase[$i], $persons_DataBase);
                            echo $button;
                        }
                        /**
                         * @param $alpabet - элемент массива (буквы украинского языка)
                         * @param $persons_DataBase - массив с данными персоналий, где ключи ассоциативного массива - фамилии
                         * @return string - возвращает html кнопку активную (class='on'), если буква $alpabet,
                         *                  совпадае с первой буквой фамилии (ключа массива $persons_DataBase),
                         *                  иначе возвращает неактивную кнопку
                         */
                        function checkAlphabets($alpabet, $persons_DataBase )
                        {
                            foreach ($persons_DataBase as $person => $data) {
                                // возвращает 1 символ из ключа массива (фамилии), в кодировке UTF-8
                                $firstchar = mb_substr($person, 0, 1);
                                if ($firstchar === $alpabet) {
                                    // активная кнопка добавлен class=on
                                    $button = "<button class='alphabetButton on'>$alpabet</button>";
                                    return $button;
                                }
                            }
                            // неактивная кнопка
                            $button = "<button class='alphabetButton'>$alpabet</button>";
                            return $button;
                        }
                        ?>
					</div>
			</div>
		</div>
	</section>

	<section class="container lastElementMargin">
	<div class="row">

		<!-- блок с персоной -->
		<div class="col s12 m6 l4 xl3">
			<a href="/portraits/shulezhko/" class="cardCustom">
				<div class="card matchheight">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="/portraits/shulezhko/img/first/1.jpg">
					</div>
					<div class="card-content">
						<span class="card-title activator card-title-20 ">Шулежко Олександра</span>
						<p class="black-text custom-content-size">Її називають «черкаським Шиндлером». Проте якщо ім’я німецького підприємця Оскара Шиндлера відоме як ім’я одного з визначних   Праведників народів світу,  Олександру Шулежко до 1968 р. називали не інакше, як  «зрадницею», переслідували за «співпрацю з окупантами».  І лише врятовані  діти завжди називали її -  «мама».</p>
					</div>
				</div>
			</a>
		</div>

		<!-- блок с персоной -->
		<div class="col s12 m6 l4 xl3">
			<a href="/portraits/shulezhko/" class="cardCustom">
				<div class="card matchheight">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="/portraits/dejneko/img/first/1.jpg">
					</div>
					<div class="card-content">
						<span class="card-title activator card-title-20 ">Родина Дейнеко</span>
						<p class="black-text custom-content-size">«З трьох родин, які рятували приречених, вони були другими, проте найвідповідальнішими й найсумліннішими. Відчували свою відповідальність не лише за життя, а й долю врятованих. Це змусило вже після війни ініціювати судовий процес і свідчити на ньому, аби єврейське дитя повернулося до своєї матері»</p>
					</div>
				</div>
			</a>
		</div>

		<!-- блок с персоной -->
		<div class="col s12 m6 l4 xl3">
			<a href="/portraits/shulezhko/" class="cardCustom">
				<div class="card matchheight">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="/portraits/marchuk/img/first/1.jpg">
					</div>
					<div class="card-content">
						<span class="card-title activator card-title-20 ">Марчук Ганна</span>
						<p class="black-text custom-content-size">Євтихій народився у 1909 р. у родині Демида і Магдалени Марчуків в с. Щитинська Воля на Волині. Крім нього у сім’ї були ще діти – Наталка, Іван та Катерина. Магдалена померла в часи Першої світової війни.</p>
					</div>
				</div>
			</a>
		</div>

		</div>
	</section>

<?php
	include_once '../includes/footer.php';
?>
