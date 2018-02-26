<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'portraits';
//$search_string = '';

function create_DB_table ($servername,$username,$password,$dbname)
{
	// проверяем коннект
	$conneection = new mysqli($servername, $username, $password);
	if ($conneection->connect_error) {
		die('MySQL недоступен: ' . $conneection->connect_error);
	} else {
		$conneection->set_charset('utf8');

		$sql = 'CREATE DATABASE IF NOT EXISTS `portraits` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';

		$conneection->query($sql);
		$conneection->select_db($dbname);

		$sql = 'CREATE TABLE IF NOT EXISTS `persona` (
		id INT(3) NOT NULL AUTO_INCREMENT,
		persona_id VARCHAR(100),
		persona_zagolovok TINYTEXT,
		persona_avatarka_text TEXT,
		persona_main_text_ckeditor TEXT,
		persona_info_data TEXT,
		PRIMARY KEY (id)
	) ENGINE = InnoDB'; // CHARACTER SET utf8 COLLATE utf8_unicode_ci

		$conneection->query($sql);
		$conneection->close();
	}
}

function insert_DB_data ($servername,$username,$password,$dbname, $persona_id, $persona_zagolovok, $persona_avatarka_text, $persona_main_text_ckeditor, $persona_info_data)
{
	$conneection = new mysqli($servername, $username, $password);
	// проверяем коннект
	if ($conneection->connect_error) {
		die('MySQL недоступен: ' . $conneection->connect_error);
	}
	else {
		$persona_id = mysqli_real_escape_string($dbname, $persona_id);

		$conneection->set_charset('utf8');
		$conneection->select_db($dbname);

		$sql = "INSERT INTO persona (persona_id,
									persona_zagolovok,
									persona_avatarka_text,
									persona_main_text_ckeditor, 
									persona_info_data)
			VALUES ('$persona_id', '$persona_zagolovok', '$persona_avatarka_text', '$persona_main_text_ckeditor', '$persona_info_data')";
		$conneection->query($sql);
		$conneection->close();
	}
}

function read_DB_data ($servername,$username,$password,$dbname,$search_string=null)
{
	$conneection = new mysqli($servername, $username, $password);
	// проверяем коннект
	if ($conneection->connect_error) {
		die('MySQL недоступен: ' . $conneection->connect_error);
	}
	else {
		$conneection->set_charset('utf8');
		$conneection->select_db($dbname);

		$sql = "SELECT * FROM persona WHERE persona_id LIKE '%$search_string%' ORDER BY persona_id DESC"; // ASC
		$result = $conneection->query($sql);
		//echo 'Total results: ' . $result->num_rows;
		//echo 'Total rows updated: ' . $conneection->affected_rows;

		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

			$persona_id = $row['persona_id'];
			$persona_zagolovok = $row['persona_zagolovok'];
			$persona_avatarka_text = $row['persona_avatarka_text'];
			$persona_main_text_ckeditor = $row['persona_main_text_ckeditor'];
			$persona_info_data = $row['persona_info_data'];

			echo "<pre>
			<td'>".$persona_id."</td>
			<td>".$persona_zagolovok."</td>
			<td>".$persona_avatarka_text."</td>
			<td>".$persona_main_text_ckeditor."</td>
			<td>".$persona_info_data."</td>
			</pre>";
		}
		$conneection->close();
	}
}


// Performs the $sql query on the server to create the database
/*if ($conneection->query($sql) === TRUE) {
	echo 'Database: portraits -  successfully created';
}
else {
	echo 'Error: '. $conneection->error;
}*/
/*if (!$conneection->set_charset("utf8")) {
	printf("Ошибка при загрузке набора символов utf8: %s\n", $conneection->error);
} else {
	printf("Текущий набор символов: %s\n", $conneection->character_set_name());
}*/






