<?php
/**
 * Created by PhpStorm.
 * User: IO
 * Date: 19.02.2018
 * Time: 23:47
 */
error_reporting(E_ALL);

if (file_exists("images/" . $_FILES["upload"]["name"]))
{
	echo $_FILES["upload"]["name"] . " already exists. ";
}
else
{
	move_uploaded_file($_FILES["upload"]["tmp_name"],
		"images/" . $_FILES["upload"]["name"]);
	echo "Stored in: " . "images/" . $_FILES["upload"]["name"];
}

echo '<pre>';
print_r($_POST);
echo '<hr>';
print_r($_FILES);
echo '<hr>';
echo '<pre>';

//$a = $_POST . '----' . $_GET;
//file_put_contents('dumpUploadCkedit.txt', $a );
die();

// перенести файл из одной папки в другую
$source_file = 'foo/image.jpg';
$destination_path = 'bar/';
rename($source_file, $destination_path . pathinfo($source_file, PATHINFO_BASENAME));