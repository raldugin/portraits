<?php
	require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/params.php');

	$firstname = $lastname = $place = $institution = $age = $phone = $email = $persona = $checkbox_status = $error = '';
	$userdata = [];

	// ( / ) - разделитель в начале и в конце выражения,
	// \D+ - запрещает ввод всех цифры,
	// [а-яА-яІіЇїЄєҐґ'] - разрешает ввод всех букв, в том числе ІіЇїЄєҐґ'
	// \p{Cyrillic} - разрешает ввод только кириллицей ( или \p{C} )
	// {0,} - правило для количества символов, которые подходят условию (тут 2!)
	// /g - означает глобальную переменную
	$pattern_textonly = '/\D+[а-яА-ЯІіЇїЄєҐґ\']{0,}\p{Cyrillic}/g';

	// [0-9+()+] - разрешает ввод только цифр 0-9, +, (, ), в конце + означает, что правило для любого количества
	$pattern_digitonly = '/[0-9+()+]/g';

	// preg_replace - для отсечки ненужных символов, букв, язфков и цифр из строки
	$str="ABC abc --- <<< ....-- + 1234 АБsD-В абв іііsDЇ <br> < > &? (+)";
	// jgthfnjh(^) означает вырезать все, кроме цифр и +, (, )
	$pattern  = "/[^0-9+()+]/";
	// вырезает все, кроме букв а-яА-Я и ІіЇїЄєҐґ
	$pattern1  = "/[^а-яА-ЯІіЇїЄєҐґ']/u";
	$result = preg_replace($pattern, '', $str);
	$result1 = preg_replace($pattern1, '', $str);
	$finish = clear_data($result);

	//		echo "$result1".'<br>';
	//		echo "$finish";


	$labels = [
		'firstname' => 		['Ваше Ім\'я',
			'<span class="red">Введіть Ваше Ім\'я</span>'
		],
		'lastname' => 		['Ваше прізвище',
			'<span class="red">Введіть Ваше прізвище</span>'
		],
		'place' => 			['Населений пункт',
			'<span class="red">Введіть населений пункт</span>'
		],
		'institution' => 	['Навчальний заклад',
			'<span class="red">Введіть навчальний заклад</span>'
		],
		'age' =>			['Ваш вік (необов’язкове поле)',
			'<span class="red">Введіть валідний вік</span>'
		],
		'phone' => 			['Номер телефону',
			'<span class="red">Введіть номер телефону</span>'
		],
		'email' => 			['Електронна пошта',
			'<span class="red">Введіть електронну пошту</span>'
		],
		'persona' => 			['Оберіть постать (необов’язкове поле)',
			'<span class="red">Введіть обрану постать</span>'
		],
		'checkbox' => 		['Дозволяю використовувати персональні дані співробітниками Національного музею історії України у Другій світовій війні.',
			'<span class="red">Дозволяю використовувати персональні дані співробітниками Національного музею історії України у Другій світовій війні.</span>'
		]
	];

	// устанавливает дефалтные значения для всех <LABEL> из массива $labels. Например, <label for="firstname"><?= $label_firstname </label>
	$label_firstname = $labels ['firstname'][0];
	$label_lastname = $labels ['lastname'][0];
	$label_place = $labels ['place'][0];
	$label_institution = $labels ['institution'][0];
	$label_age = $labels ['age'][0];
	$label_phone = $labels ['phone'][0];
	$label_email = $labels ['email'][0];
	$label_persona = $labels ['persona'][0];
	$label_checkbox = $labels ['checkbox'][0];

	if(isset($_POST['submit'])) {
		/*
		--------------------------------------------------------------------------
		упрощенная логика реализовання в универсальной функции setForm_Label_Value
		--------------------------------------------------------------------------
		if (!empty($_POST['firstname']))
		{
			$label_firstname = $labels ['firstname'][0];
			$firstname = clear_data($_POST['firstname']);
		}
		else {
			$firstname = '';
			$label_firstname = $labels ['firstname'][1];
		}
		*/

//			$firstname = !empty($_POST['firstname']) ? clear_data($_POST['firstname']) : $firstname = ''; $label_firstname = $labels ['firstname'][1];


		/**
		 * отправляем в функцию
		 */
		$firstname = setForm_Label_Value ($_POST['firstname'], 'firstname', $labels, $label_firstname, $error);
		$lastname = setForm_Label_Value ($_POST['lastname'], 'lastname', $labels, $label_lastname, $error);
		$place = setForm_Label_Value ($_POST['place'], 'place', $labels, $label_place, $error);
		$institution = setForm_Label_Value ($_POST['institution'], 'institution', $labels, $label_institution, $error);
		//$age = setForm_Label_Value ($_POST['age'], 'age', $labels, $label_age, $error);
		$age = clear_data($_POST['age']);
		$phone = setForm_Label_Value ($_POST['phone'], 'phone', $labels, $label_phone, $error);
		$email = setForm_Label_Value ($_POST['email'], 'email', $labels, $label_email, $error);
		$persona = clear_data($_POST['persona']);

		if (!empty($age))
		{
			if ($age < 7 ) {
				$label_age = $labels ['age'][1];
				$age = '';
				$error = 'error_detected';
			}
		}
		// проверяем checkbox, елси отмечен, устанавливаем дефолтное значение его <LABEL>, иначе, подсвечиваем его <LABEL> красным
		if (!isset($_POST['checkbox']) ) {
			$label_checkbox = $labels ['checkbox'][1];
			$checkbox_status = '';
			$error = 'error_detected';
		}
		else {
			$label_checkbox = $labels ['checkbox'][0];
			$checkbox_status = 'checked';
		}

		/*function validate_user_data ($age, $fieldname, $labels, &$label_age) // $firstname, $lastname, $place, $institution, $age, $phone, $email
		{
			if ( $age <= 7 ) {
				$label_age = $labels [$fieldname][1];
				return $error='error_detected';
			}
		}
		$error = validate_user_data ($age, 'age', $labels, $label_age);*/

		if ($error == '') {
			$time = date('d.m.y', time());
			$timeStamp = 'id_'.time();
			$userdata [$timeStamp] =
									['place'=>$place,
									'institution'=>$institution,
									'firstname'=>$firstname,
									'lastname'=>$lastname,
									'age'=>$age,
									'email'=>$email,
									'phone'=>$phone,
									'persona'=>$persona,
									'time'=>$time
									];

			if (is_dir(USER_DATA_DIR)) {
				$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);
				// объединяем записи массива из файла с массивом данных нового пользователя
				$save_data_file = array_merge($open_data_file, $userdata);
				// конвертим в JSON и записываем в файл
				file_put_contents(USER_DATA_DIR . 'data.json', json_encode($save_data_file, JSON_UNESCAPED_UNICODE));
			}
			// если такого дира не существует, создаем его и пишем в файл регистрационные данные первого пользака
			else {
				mkdir(USER_DATA_DIR, 0755, true);
				file_put_contents(USER_DATA_DIR . 'data.json', json_encode($userdata, JSON_UNESCAPED_UNICODE));
			}

			//redirect the the page to the view-post-direct-page.php
			$string = '<script type="text/javascript">';
			$string .= 'window.location = "' . 'index.php' . '"';
			$string .= '</script>';
			echo $string;

		}
	}
	/**
	 * @param $postdata 		- приходит содержимое &_POST[ 'данные из поля ввода формы с именем name (<INPUT name="...")' ]
	 * @param $fieldname		- имя поля ввода <INPUT name="...имя... ")
	 * @param $labels			- массив со строковыми значениями тєга <LABEL for="имя поля ввода"> ...подставляемое значение... </label>
	 * @param &$label_firstname	- подставляемое значение из массива $labels, которое присваивается значению <LABEL>
	 * @param &$error			- флаг состояние переменной $error, по умолчанию false.
	 * @return string			- возвращает значение <INPUT value=" введенные пользователем данные" текущего поля ввода &_POST[ 'данные из поля ввода формы
	 * 							- с именем name (<INPUT name="...")' ] или возвращает пустое значение, если пользователь ничего не ввел в текущее поле ввода
	 *
	 * 							- IF проводит проверку, если поле ввода $postdata не пустое, то ставим исходное значение <LABEL>, например 'Ваше Ім\'я'
	 *							- и присваивем переменной $fieldvalue очищенное от мусора $postdata
	 * 							- ELSE иначе присваивем переменной $fieldvalue пустое значение и присваиваем <LABEL>
	 *							- из массива $labels с сообщением об ошибке, например '<span class="red">Введіть Ваше Ім\'я</span>'
	 */
	function setForm_Label_Value ($postdata, $fieldname, $labels, &$label_firstname, &$error)
	{
		if (!empty($postdata)) {
			$label_firstname = $labels [$fieldname][0];
			$fieldvalue = clear_data($postdata);
		}
		else {
			$fieldvalue = '';
			$label_firstname = $labels [$fieldname][1];
			$error = 'error_detected';
		}
		return $fieldvalue;
	}
	function clear_data($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<?php
require_once (INCLUDES_DIR.'header.html');
?>

	<section class="container">
		<div class="imgMediaInside" style="background-image: url(img/panoramas/panorama_1800x1000.jpg);">
			<div class="imgMediaInsidePromo"><img type="image/svg+xml" src="/img/panoramas/first_session.svg" class="transform"></div>
		</div>
	</section>

	<section class="container" style="margin-bottom: 70px;">
		<div class="row">
			<div class="col s12 m4 l4">
				<div class="center card-panel matchheight grey lighten-4">
					<i class="material-icons material-icon-custom">announcement</i>
					<h3 class="promo-caption">Освітня програма</h3>
					<div class="left-align">
						<p>Мета – історичний та міжнародний ребрендинг українського виміру в Другій світовій війні через долі людей, які своїми вчинками сприяли боротьбі з тоталітаризмом, відстоювали демократичні ідеали та громадянські переконання; втілювали ідеали миру, гуманізму й толерантності.</p>
						<p>Завдання – формування широкої наративної бази, комплектування музейної колекції, підготовка видань, популяризація  досліджень.</p>
						<p>Очікувані результати –  міжнародне визнання високого ступеня звитяги та жертовності українців у роки Другої світової війни.</p>
					</div>
				</div>
			</div>
			<div class="col s12 m4 l4">
				<div class="center card-panel matchheight grey lighten-4">
					<i class="material-icons material-icon-custom">assignment</i>
					<h3 class="promo-caption">Cесія 2018</h3>
					<div class="left-align">
						<p>Тема: Українці – Праведники народів світу.</p>
						<p>Присвячується українцям, які в роки Другої світової війни рятували євреїв від знищення.</p>
						<p>За добу нацизму було знищено бл. 6 млн євреїв. Понад 1,4 млн загиблих припадає на Україну. Однак поруч з найбільшим злом траплялися й прояви  найвищого добра та моральної сили. Відомі понад 26,5 тис. Праведників народів світу. З них понад 2,5 тис. –  українці.</p>
							<p>Завдання сесії – зробити відомими якомога більше історій порятунку та імен рятівників, зберегти взірці їхньої людяності та  гуманності в історичній пам’яті різних націй.</p>
					</div>
				</div>
			</div>
			<div class="col s12 m4 l4">
				<div class="center card-panel matchheight grey lighten-4">
					<i class="material-icons material-icon-custom">assessment</i>
					<h3 class="promo-caption">Порядок дій</h3>
					<div class="left-align">
						<p>Крок 1. Реєстрація, ознайомлення з темою сесії, вибір персоналії для  дослідження.</p>
						<p>Крок 2. Робота під керівництвом кураторів. Дослідження  має включати: біографічний нарис, презентацію артефактів, відеозаписи спогадів.</p>
						<p>Крок 3.  Презентація робіт у Національному музеї історії України у Другій світовій війні (м. Київ). Підготовка тематичного виставкового проекту, формування збірки, зустрічі з провідними вітчизняними  істориками, письменниками, журналістами та громадськими діячами.</p>
						<p>Запрошуються всі небайдужі до вітчизняної історії.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="container" style="margin-bottom: 70px;">
		<div class="row">
			<h5 class="center-align">Новини проекту</h5>  <!--lime-text text-darken-4-->
			<div class="col s12 m4 l4">
				<div class="card z-depth-2">
					<div class="card-image">
						<img src="img/news/1/1.jpg">
					</div>
					<div class="card-content matchheight">
						<span class="card-title color-black">Презентація «ПортретиUA»</span>
						<p>Першим про новий освітній проект ми розповіли друзям – учням «Школи Миру» Федерації всесвітнього миру...</p>
						<p style="margin-top: 10px;"><b>15.11.2207</b></p>
							<!--<p>Ідея  зібрання та популяризації історій українців – Праведників народів світу дуже сподобалася аудиторії. Це завдання тісно перегукується із завданням самої «Школи Миру» – поширення ідеї миру та формування миротворчого іміджу України.</p>-->
						<!--<p>Під час презентації підлітки дізналися окремі історії порятунку євреїв у роки Другої світової війни, обговорили персоналії своїх майбутніх досліджень. Також, аби 13-18 річні громадяни краще осягнули дилему вибору:  чи рятувати іншу людину, коли на кону стоїть власне життя, їм запропонували інтерактивну гру «Тримай мене». Тренінг сподобався його учасникам. Обговорення показало високий ступінь усвідомлення ними важливості подвигу Праведників народів світу.</p>
						<p>Історичні портрети від учнів «Школи миру»  незабаром з’являться на сайті проекту.</p>-->
					</div>
					<div class="card-action">
						<a href="news.html">Переглянути</a>
					</div>
				</div>
			</div>
			<div class="col s12 m4 l4">
				<div class="card z-depth-2">
					<div class="card-image">
						<img src="img/news/1/2.jpg">
					</div>
					<div class="card-content matchheight">
						<span class="card-title color-black">Презентація «ПортретиUA»</span>
						<p>Першим про новий освітній проект ми розповіли друзям – учням «Школи Миру» Федерації всесвітнього миру...</p>
						<p style="margin-top: 10px;"><b>15.11.2207</b></p>
						<!--<p>Ідея  зібрання та популяризації історій українців – Праведників народів світу дуже сподобалася аудиторії. Це завдання тісно перегукується із завданням самої «Школи Миру» – поширення ідеї миру та формування миротворчого іміджу України.</p>-->
						<!--<p>Під час презентації підлітки дізналися окремі історії порятунку євреїв у роки Другої світової війни, обговорили персоналії своїх майбутніх досліджень. Також, аби 13-18 річні громадяни краще осягнули дилему вибору:  чи рятувати іншу людину, коли на кону стоїть власне життя, їм запропонували інтерактивну гру «Тримай мене». Тренінг сподобався його учасникам. Обговорення показало високий ступінь усвідомлення ними важливості подвигу Праведників народів світу.</p>
						<p>Історичні портрети від учнів «Школи миру»  незабаром з’являться на сайті проекту.</p>-->
					</div>
					<div class="card-action">
						<a href="news.html">Переглянути</a>
					</div>
				</div>
			</div>
			<div class="col s12 m4 l4">
				<div class="card z-depth-2">
					<div class="card-image">
						<img src="img/news/1/3.jpg">
					</div>
					<div class="card-content matchheight">
						<span class="card-title color-black">Презентація «ПортретиUA»</span>
						<p>Першим про новий освітній проект ми розповіли друзям – учням «Школи Миру» Федерації всесвітнього миру...</p>
						<p style="margin-top: 10px;"><b>15.11.2207</b></p>
						<!--<p>Ідея  зібрання та популяризації історій українців – Праведників народів світу дуже сподобалася аудиторії. Це завдання тісно перегукується із завданням самої «Школи Миру» – поширення ідеї миру та формування миротворчого іміджу України.</p>-->
						<!--<p>Під час презентації підлітки дізналися окремі історії порятунку євреїв у роки Другої світової війни, обговорили персоналії своїх майбутніх досліджень. Також, аби 13-18 річні громадяни краще осягнули дилему вибору:  чи рятувати іншу людину, коли на кону стоїть власне життя, їм запропонували інтерактивну гру «Тримай мене». Тренінг сподобався його учасникам. Обговорення показало високий ступінь усвідомлення ними важливості подвигу Праведників народів світу.</p>
						<p>Історичні портрети від учнів «Школи миру»  незабаром з’являться на сайті проекту.</p>-->
					</div>
					<div class="card-action">
						<a href="news.html">Переглянути</a>
					</div>
				</div>
			</div>
		</div>
	</section>



	<!--<div class="container"><div class="divider"></div></div> &lt;!&ndash; линия &ndash;&gt;-->


	<div id="form" class="container"><div class="divider"></div></div>

	<section class="container" style="margin-top: 10vh; margin-bottom: 70px;">
		<h5 class="center-align">Реєстраційна форма</h5>  <!--lime-text text-darken-4-->
		<div class="row">
			<div class="col s12">
<!--			<form action="--><?php //$location = $_SERVER['PATH_INFO']; echo ''.$location.'#form';?><!--" method="post">-->
				<form action="index.php#form" method="post">
					<div class="row">
						<div class="input-field col s6">
							<input id="firstname" type="text" name="firstname" class="validate" value="<?= $firstname ?>">
							<label for="firstname"><?= $label_firstname ?></label>
						</div>
						<div class="input-field col s6">
							<input id="lastname" type="text" name="lastname" class="validate" value="<?= $lastname ?>">
							<label for="lastname"><?= $label_lastname ?></label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input id="place" type="text" name="place" class="validate" value="<?= $place ?>">
							<label for="place"><?= $label_place ?></label>
						</div>
						<div class="input-field col s6">
							<input id="institution" type="text" name="institution" class="validate" value="<?= $institution ?>">
							<label for="institution"><?= $label_institution ?></label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input id="age" type="number" name="age" min="7" class="validate" value="<?= $age ?>">
							<label for="age"><?= $label_age ?></label>
						</div>
						<div class="input-field col s6">
							<input id="phone" type="number" name="phone" class="validate" value="<?= $phone ?>">
							<label for="phone"><?= $label_phone ?></label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input id="email" type="email" name="email" class="validate" value="<?= $email ?>">
							<label for="email"><?= $label_email ?></label>
						</div>
						<div class="input-field col s6">
							<input id="persona" type="text" name="persona" class="validate" value="<?= $persona ?>">
							<label for="persona"><?= $label_persona ?></label>
						</div>
						<!--<div class="input-field col s12">
							<textarea id="textarea" name="comment" class="materialize-textarea"><?/*= $comment */?></textarea>
							<label for="textarea">Тема роботи в рамках проекту (необов’язкове поле)</label>
						</div>-->
					</div>
					<p>
						<input type="checkbox" class="filled-in" name="checkbox" id="filled-in-box" <?= $checkbox_status ?>/>
						<label for="filled-in-box"><?= $label_checkbox ?></label>
					</p>
					<p class="center">
						<button class="btn waves-effect waves-light" type="submit" name="submit" style="margin-top: 30px;">Зареєструватися</button>
						<!--<button class="btn waves-effect waves-light" type="reset" value="Reset">Очистити</button>-->
					</p>
				</form>

			</div>
		</div>
	</section>

<?php
include_once(INCLUDES_DIR . 'footer.php');
?>