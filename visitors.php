<?php
	/**
	 * Created by PhpStorm.
	 * User: Al
	 * Date: 08.12.2017
	 * Time: 14:55
	 */

	/**
	 *  РАБОЧАЯ ФУНКЦИЯ сортировки ассоц массивов по ключу

	$people = [
	12345 => [
	'id' => 12345,
	'first_name' => 'Joe',
	'surname' => 'Bloggs',
	'age' => 23,
	'sex' => 'm'
	],
	12346 => [
	'id' => 12346,
	'first_name' => 'Adam',
	'surname' => 'Smith',
	'age' => 18,
	'sex' => 'm'
	],
	12347 => [
	'id' => 12347,
	'first_name' => 'Amy',
	'surname' => 'Jones',
	'age' => 21,
	'sex' => 'f'
	]
	];
	echo '<pre>';
	print_r(array_sort($people, 'first_name', SORT_ASC)); // Sort by oldest first
	echo '</pre>';

	function array_sort($array, $on, $order)
	{
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
	foreach ($array as $k => $v) {
	if (is_array($v)) {
	foreach ($v as $k2 => $v2) {
	if ($k2 == $on) {
	$sortable_array[$k] = $v2;
	}
	}
	} else {
	$sortable_array[$k] = $v;
	}
	}

	switch ($order) {
	case SORT_ASC:
	asort($sortable_array);
	break;
	case SORT_DESC:
	arsort($sortable_array);
	break;
	}

	foreach ($sortable_array as $k => $v) {
	$new_array[$k] = $array[$k];
	}
	}

	return $new_array;
	}
	 */

	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');
	$id= $emailText = '';

	$userID_to_get = []; // определяем массив для списка юзер айди
	$email_array = [];


	$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);

	if (!empty($open_data_file)) {
		$open_data_file = array_reverse($open_data_file); // меняет порядок элементов массива от конца к началу
	}

	if (isset($_POST['deleteUser']) || isset($_POST['editUser']) || isset($_POST['sendmail_from_checkbox']) && !empty($_POST['checkbox_array']))
	{
		$checkboxID = $_POST['checkbox_array'];        // создаем массив $checkboxID из значений массива $_POST['checkbox_array'], где записаны $userID
		$checkboxID_counter = count($checkboxID);    // считаем количество элементов массива
	}

	if (isset($_POST['deleteUser']) && !empty($_POST['checkbox_array']))
	{
		for ($i = 0; $i < $checkboxID_counter; $i++) {
			$userID = $checkboxID[$i];
			unset($open_data_file[$userID]);
		}
		file_put_contents(USER_DATA_DIR . 'data.json', json_encode($open_data_file, JSON_UNESCAPED_UNICODE));
	}
	if (isset($_POST['editUser']) && !empty($_POST['checkbox_array']))
	{
		for ($i = 0; $i < $checkboxID_counter; $i++) {
			$userID = $checkboxID[$i];
			//$userID_to_get = $userID_to_get. '?'.'id='.$userID;
			$userID_to_get [] = $userID;
		}

		// решение для отправки массива через GET - запрос с помощью http_build_query ()
		$query_string = http_build_query($userID_to_get);
		$url = 'edituser.php?' . $query_string;
		header("Location: $url");

		// решение для отправки массива через GET - запрос сериализируя массив в строку с помощью serialize()
		/*$url = 'edituser.php?ID=' . serialize($userID_to_get);
		header("Location: $url");*/
	}
	if (isset($_POST['sendmail_from_checkbox']) && !empty($_POST['checkbox_array'])) {	// кнопка отправить почту по выделенным чекбоксам
			echo $_POST['emailText'];
			/**
			 * создаем цикл, где итератор $i = 0, $checkboxID_counter - количество элементов массива с ID пользователей полученных через POST (с отмеченными чекбоксами)
			 * $userID = $checkboxID[$i]; - получаем строку с ID пользователя
			 * $open_data_file[$userID]['email'] - получаем из массива пользователей (файл JSON) email пользователя по его ID (ключи массива $open_data_file),
			 * которое пришло из массива $checkboxID, который сформирован в свою очередь по отмеченным checkbox и переданных через POST-запрос
			 * создаем массив $email_array [] в который записываем EMAIL пользователей, отмеченных чекбоксами
			 */
			for ($i = 0; $i < $checkboxID_counter; $i++) {
				$userID = $checkboxID[$i];
				$email_array [] = $open_data_file[$userID]['email'];
			}
			echo "<pre>";
			print_r($email_array);
			echo "</pre>";
	}

	if (isset($_POST['change'])) {
		if ($_POST['change'] == 'place'){
			// array_column делает выборку значений массива $open_data_file по ключам (например 'place')
			// array_multisort сортирует многомерный массив, или несколько массивов
			array_multisort(array_column($open_data_file, 'place'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'institution'){
			array_multisort(array_column($open_data_file, 'institution'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'time'){
			array_multisort(array_column($open_data_file, 'time'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'age'){
			array_multisort(array_column($open_data_file, 'age'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'lastname'){
			array_multisort(array_column($open_data_file, 'lastname'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'firstname'){
			array_multisort(array_column($open_data_file, 'firstname'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'email'){
			array_multisort(array_column($open_data_file, 'firstname'), SORT_ASC, $open_data_file);
		}
		if ($_POST['change'] == 'phone'){
			array_multisort(array_column($open_data_file, 'phone'), SORT_ASC, $open_data_file);
		}
	}

	/**
	 * фильтрует массив по заданному фильтру в значениях массива, возвращает новый массив

	$like = '18';
	$result = array_filter($open_data_file, function ($item) use ($like) {
		if (stripos($item['age'], $like) !== false) {
			return true;
		}
		return false;
	});
	echo "<pre>";
	print_r($result);
	echo "</pre>";
	 */

	// array_column - создает новый массив из исходного ассоциативного вложенного массива со значениями ключей (тут place)
	//

	/**
	 *	$array ['массив'] =
	 *					['place'=>'kiev',
	 *					'name' => 'alex',
	 *					],
	 * 					['place'=>'toronto',
	 *					'name' => 'alex',
	 * 					];
	 *
	 *  array_column - создает новый массив из исходного ассоциативного вложенного массива со значениями ключей (тут place)
	 */
	//print_r($column=array_column($array,'place'));
?>

<!doctype html>
<html lang="uk">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Зареєстровані учасники</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<style>
		.btn-custom {
			margin-bottom: 5px;
			width: 100%;
			max-width: 100%;
			padding: 10px 0;
		}
		th {
			vertical-align: middle !important;
		}
		th:first-child {
			width: 80px;
		}
	</style>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-12" style="margin: 15px 0;">
			<h4>Адмінпанель проекту ПортретиUA</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<form id="tableForm" method='post'>
				<table class="table table-bordered table-hover table-sm" style="font-size: 14px;"> <!-- table-sm table-responsive -->
					<thead class="thead-inverse">
					<tr>
						<th><button id="selectAll" class='btn btn-success btn-custom btn-sm' type='submit' name='change'>Відмітити</button></th>
						<!-- <th><input type="checkbox" id="selectall"/></th>-->
						<th>&nbsp;#&nbsp;</th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='place'>Населений пункт</button></th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='institution'>Заклад</button></th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='firstname'>Ім'я</button></th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='lastname'>Прізвище</button></th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='age'>&nbsp;Вік&nbsp;</button></th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='email'>Email</button></th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='phone'>Телефон</button></th>
						<th>Коментар</th>
						<th><button class='btn btn-success btn-custom btn-sm' type='submit' name='change' value='time'>Дата</button></th>
					</tr>
					</thead>
					<tbody>
					<?php
						$arrayCount = count($open_data_file);
						$counter = 0;
						foreach ($open_data_file as $userID => $userData) {
							$counter++;
							echo "<tr><td style='text-align: center;'>
									<div class='form-check'>
  										<label class='form-check-label'>
											<input class='form-check-input checkbox' type='checkbox' name='checkbox_array[]' value='$userID'> <!-- массив 
											checkbox_array[] -->
										</label>
									</div>
									</td>
								";
							echo "<th scope='row'>$counter</th>";
							foreach ($userData as $userItem) {
								echo "<td>$userItem</td>";
							}
							//echo "<td><button class='deleteUser btn btn-danger btn-sm' type='submit' name='submit' value='$userID'>Удалить</button></td>";
							echo '</tr>';
						}
					?>
					<tr>
						<td colspan="11"><b>Всього зареєстровано: <?= $arrayCount ?></b></td>
					</tr>
					</tbody>
				</table>

				<button class='deleteUser btn btn-danger btn-sm' type='submit' name='deleteUser' value=''>Удалить отмеченных пользователей</button>
				<button class='editUser btn btn-primary btn-sm' type='submit' name='editUser' value=''>Редактировать отмеченных пользователей</button>

				<div class="row" style="margin: 50px 0;">
					<div class="col-5">
						<div class="form-group">
							<label for="exampleFormControlTextarea1">Надіслати пошту відміченим учасникам</label>
							<textarea class="form-control" name="emailText" id="exampleFormControlTextarea1" value='' rows="7"></textarea>
						</div>
						<button class='sendmail_from_checkbox btn btn-primary' form="tableForm" type='submit' name='sendmail_from_checkbox'>Відправити відібраним учасникам</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>
      // $('#tableForm').submit(function() {
      //     return confirm("Удалить пользователя?");
      // });
		$( '.deleteUser' ).click(function() {
          if (confirm ("Удалить участника?")) {
              $('#tableForm').submit();
          }else {
              return false;
          }
        });

      $( '.editUser' ).click(function() {
          if (confirm ("Редагувати участника?")) {
              $('#tableForm').submit();
          }else {
              return false;
          }
      });

      	$( '.sendmail_from_checkbox' ).click(function() {
          if (confirm ("Отправить почту выбранным пользователям?")) {
              $('#tableForm').submit();
          }else {
              return false; // или event.preventDefault();
          }
      	});



      $('#selectAll').click(function() {
          event.preventDefault();
          var checkbox = $('.checkbox');
              if ($(checkbox).length !== $('.checkbox:checked').length) {
                  $(checkbox).attr("checked", '');
                  $('#selectAll').text('Відмінити');
                  $('#selectAll').toggleClass('btn-success').toggleClass('btn-danger');
			  }
              else {
                  $(checkbox).removeAttr("checked");
                  $('#selectAll').text('Відмітити');
                  $('#selectAll').toggleClass('btn-success').toggleClass('btn-danger');
			  }
      });
      // $('.checkbox').click(function () {
      //     if ($(this).prop('checked')) {
      //         $(this).attr("checked", "checked");
      //     }
      //     else {
      //         $(this).removeAttr("checked");
      //     }
      // });

          // if($(checkbox).length !== $('.checkbox:checked').length) {
          //     $(checkbox).attr("checked", "checked");
          //     $('#selectAll').text('Відмінити');
          //     $('#selectAll').toggleClass('btn-success').toggleClass('btn-danger');
          // } else {
          //     $(checkbox).removeAttr("checked");
          //     $('#selectAll').text('Відмітити');
          //     $('#selectAll').toggleClass('btn-success').toggleClass('btn-danger');
          // }

</script>
</html>
