<?php
	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');
	$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);

	// решение получить массив из GET после того как он был сериализирован с помощью serialize()
	/*if ( isset($_GET['ID']) && !empty($_GET['ID']) ) {
		$userID_array = unserialize($_GET['ID']);
		$userID_array_counter = count($userID_array);
	}*/

	// решение олучить массив из GET после того, как данные были сформированы с помощью http_build_query()
	// !!!!!! попробовать с функцией filter_input ()
	// или parse_str ()
	// или parse_url()
	if ( isset($_GET) && !empty($_GET) ) {
		$userID_array = $_GET;
		$userID_array_counter = count($userID_array);
	}

	if (isset($_POST['newinfo'])) {
		$new_user_info = $_POST['newinfo']; // массив полученных значений из полей ввода (input) с данными пользователя
		for ($i=0; $i<$userID_array_counter; $i++ ) {
			$userID = $userID_array[$i];
			$save_new_info_to_file = array_replace_recursive($open_data_file, $new_user_info); // Рекурсивно заменяет элементы первого массива элементами переданных массивов
		}
		file_put_contents(USER_DATA_DIR . 'data.json', json_encode($save_new_info_to_file, JSON_UNESCAPED_UNICODE));
		header('Location: visitors.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<style>
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
			<h4>Редагувати інформацію учасника</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<form method='post'>
				<table class="table table-bordered table-hover table-sm" style="font-size: 14px;"> <!-- table-sm table-responsive -->
					<thead class="thead-inverse">
					<tr>
						<th>Населений пункт</th>
						<th>Заклад</th>
						<th>Ім'я</th>
						<th>Прізвище</th>
						<th>&nbsp;Вік&nbsp;</th>
						<th>Email</th>
						<th>Телефон</th>
					</tr>
					</thead>
					<tbody>
					<?php
						for ($i=0; $i<$userID_array_counter; $i++ ) {
							$userID = $userID_array[$i];
							//echo "$userID".'<br>';
							echo '<tr>';
								foreach ($open_data_file[$userID] as $fieldname => $item) {
									if ($fieldname !== 'comment' && $fieldname !== 'time') {
										echo "<td><input type='text' name='newinfo[$userID][$fieldname]' value='$item'></td>";
									}
								}
							echo '</tr>';
						}
					?>
					</tbody>
				</table>

				<button class='editUser btn btn-primary' type='submit' name='submitUserInfo' value='<?php ?>'>Внести зміни</button>

			</form>
		</div>
	</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</html>