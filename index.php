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

<!DOCTYPE html>
<html lang="uk">
<head>
	<meta charset="UTF-8">
	<title>Portraits.ua</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="/assets/css/normalize.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/materialize.css" media="screen,projection">
	<link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body>
<div id="page-wrapper"> <!-- page wrapper for footer calculate-->
<?php
	include_once INCLUDES_DIR.'header.html';
?>

<main>
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
			<div class="col s12 m3 l3">
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
			<div class="col s12 m3 l3">
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
			<div class="col s12 m3 l3">
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
			<div class="col s12 m3 l3">
				<div class="card z-depth-2">
					<div class="card-image">
						<img src="img/news/1/4.jpg">
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
</main>
</div> <!-- end of page wrapper -->

<footer class="page-footer lime darken-2">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">Footer Content</h5>
				<p>м. Київ, вул. Лаврська, 27
					Тел.: (044) 185 94 52
					Моб. (098) 771 27 66</p>
				<p>email: portraitsua@gmail.com
					www.warmuseum.kiev.ua</p>
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
<script>
    $(document).ready(function () {

        // smooth scroll to the anchor Id income from another page
        //if(window.location.hash) {
            //var margin = ($(document).height() / $(anchor).offset().top);
            //console.log (margin);

          //  $('html, body').animate({
            //    scrollTop: $(window.location.hash).offset().top + 'px'
            //}, 500, 'swing');
        //}

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
                //constrainWidth: true, // Does not change width of dropdown to that of the activator
                hover: false, // Activate on hover
                //gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                //alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false // Stops event propagation
            }
        );
        $('.button-collapse').sideNav();
        $('.matchheight').matchHeight();
        stickyFooter();
        sizeImgMediaInside();
        // offsetAnchor();
        // function offsetAnchor() {
        //     if (location.hash.length !== 0) {
        //         window.scrollTo(window.scrollX, window.scrollY - 100);
        //     }
        // }

        function sizeImgMediaInside() {
            var windowHeight = window.innerHeight;
            var imgHeight = Math.round(windowHeight / 10 * 5);
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

<!--<section class="container" style="margin-top: 50px; margin-bottom: 70px;">
		<div class="row">
			<div class="col s12 m6 l6">
				<h5 class="center-align matchheight">Хто рятує одне життя, рятує цілий світ</h5>
				<p><img src="img/1session/shulezhko.jpg" class="fitImage"></p>
				<h6 class="center-align">2017-2018 рр. Перша сесія проекту.</h6>
<p>Олександра Шулежко народилася 1903 р. в селі Михайлівка Драбівського району (нині — Черкащина). Походила з заможної родини селян Шелудьків, закінчила гімназію, потім — педучилище. 1921 р. вийшла заміж за Федора Шулежка, який згодом став священиком Української автокефальної православної церкви. Його репресували 1937 р. Олександра залишилася сама з чотирма дітьми. Один син помер немовлям, другий став танкістом, згорів заживо під час війни, а дві доньки, Алла і Лариса, вижили.</p>
<p>У роки війни Олександра Шулежко врятувала від смерті й голоду 102 дитини; з них 25 були євреями. Вона зуміла організувати притулок для дітей-безхатченків у Черкасах. Після окупації Черкас Олександра Максимівна бачила багато бездомних і сиріт. До рішення створити притулок спонукала зустріч з маленьким хлопчиком. Він сидів біля померлої жінки на вулиці. Олександра Максимівна привела дитину до себе додому. Згодом з'явився ще один знайда. Вона звернулася до гебітскомісара Черкас із пропозицією створити дитячий будинок. Ініціатива знайшла відгук. Із часом Олександра змогла якимось дивом розжитися й на фінансові вливання від німецької влади для дитбудинку. Організувала на невеличкій земельній ділянці господарство. Усім тим опікувалися вихованці.</p>
<p>Завдяки хоробрості, винахідливості й піклуванню Олександри Шулежко діти вижили. Вона приймала у притулок усіх без винятку. Поміж інших дітей з'явилися й єврейські. Їх записували як українців, греків, вірмен або татар залежно від особливостей зовнішності. Цій мужній жінці було що втрачати: вона ризикувала власним життям і життям своїх дітей. Черкаські поліцаї написали на неї донос, і німецька поліція частенько навідувала притулок. Єврейських дітей переховували в ізоляторі. Німцям казали, що там тримають інфекційних хворих. Олександра Максимівна, завдяки доброму знанню німецької мови, переконала гебітскомісара у безпідставності підозр поліцая Руднєва.</p>
<p>Коли німці відступали, вони примусово евакуювали й дитячий будинок. Гебітскомісар виділив дві машини. Олександра Шулежко прилаштувала частину вихованців у навколишніх селах, але з іншими мусила рушати з німцями. Вони доїхали до Вінницької області. Звідти Олександра Максимівна зуміла знову дістатися з дітьми до Черкас. Та тут її чекали. У місто повернулася радянська влада. Виховательку відсторонили від спілкування з дітьми, заборонили працювати за фахом. Олександра Максимівна влаштувалася на роботу до реєстратури. До 1968 р. її підозрювали у співпраці з нацистами. Натомість вихованці жінки завжди тепло згадували свою другу маму.</p>
<p>Олександра Шулежко померла 1994 р. Через рік їй присвоїли почесне звання Праведник народів світу.</p>
</div>
<div class="col s12 m6 l6">
	<h5 class="center-align matchheight">Українці – Праведники народів світу: призабута історія</h5>
	<p><img src="img/1session/pravedniki.jpg" class="fitImage"></p>
	<p>2017-2018 рр. Перша сесія проекту присвячена дослідженню життєвих історій українців, які, ризикуючи власним життям, рятували євреїв під час Другої світової війни та отримали. Державою Ізраїль нагороджені дипломами та медалями Праведників народів світу.</p>
	<p>В Ізраїлі й дотепер вивчають документи часів Другої світової війни. Пошук людей, які врятували євреїв, триває. Щорічно впродовж понад 25 років проводить урочисті церемонії нагородження дипломами та медалями Праведників народів світу.</p>
	<p>За даними Посольство Держави Ізраїль в Україні на 1 січня 2017 р., звання Праведника народів світу присвоєно 2573 громадянам України, за кількістю Праведників Україна посідає четверте місце у світі після Польщі, Нідерландів та Франції.</p>
	<p>Уже вдруге урочиста церемонія проводитиметься в Національному музеї історії України у Другій світовій війні. Це стає доброю традицією, оскільки тема Голокосту, зокрема трагедії Бабиного Яру в Києві, є предметом наукових досліджень співробітників музею, вона рельєфно представлена в головній експозиції. Відвідувачі мають можливість ознайомитися з винятковими історіями та оригінальними матеріалами Праведників народів світу.</p>
</div>
</div>
</section>-->