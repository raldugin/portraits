<?php


function upload_single_file($filesArray, $pathToUpload)
{
	global $persona_info_data;
	$fileCounter = count($filesArray['name']);
	for ($i = 0; $i < $fileCounter; $i++) {
		$fileName = $filesArray['name'][$i];
		$fileTmpName = $filesArray['tmp_name'][$i];
		$fileError = $filesArray['error'][$i];

		if ($fileError < 1) {
			move_uploaded_file($fileTmpName, $pathToUpload . utf8_to_cp1251($fileName));
			array_push($persona_info_data['info_data']['persona_pdf'], $fileName);
		}
	}
}

/**
 * @param $imageArray - массив атрибутов изображения из $_FILES
 *                      ['name'] - имя файла,
 *                      ['type'] - mimi тип файла
 *                      ['tmp_name'] - временное имя файла который сохранен в папке tmp php-интерпритатора
 *                      ['error'] - 0 когда нет ошибок, если 1-4 означает коды ошибок
 *                      ['size'] - размер файла в Кб
 * @param $pathToUpload - путь куда надо сохранять файл если нет ошибок по проверке MIME типу файла
 * @param $key - имя нового ключа массива $persona_main_data [$persona_id],
 *                      где его значение на выходе это имя файла, которое залито в директорию
 */
function upload_single_image($imageArray, $pathToUpload, $key)
{
	global $persona_info_data;
	$imageName = $imageArray['name'];
	$imageTmpName = $imageArray['tmp_name'];
	//  exif_imagetype - читает первые байты изображения и проверяет его подпись
	$imageMimeType = exif_imagetype($imageTmpName);
	$checkedMimeType = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

	if (in_array($imageMimeType, $checkedMimeType) && ($imageArray['error'] < 1)) {
		move_uploaded_file($imageTmpName, $pathToUpload . $imageName);
		$persona_info_data['info_data'] = array_merge($persona_info_data['info_data'], [$key => $imageName]);
	} else {
		die('ошибка загрузки файлов');
	}
}

/**
 * @param $imageArray - $imageArray - массив атрибутов изображения из $_FILES
 * @param $pathToUpload - путь куда надо сохранять файл если нет ошибок по проверке MIME типу файла
 */
function upload_multiple_image($imageArray, $pathToUpload)
{
	global $persona_info_data;
	// считаем количество элементов массива, что равно кол-ву загруженных изображений
	$imageCounter = count($imageArray['name']);
	$checkedMimeType = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

	for ($i = 0; $i < $imageCounter; $i++) {
		$imageName = $imageArray['name'][$i];
		$imageTmpName = $imageArray['tmp_name'][$i];
		$imageMimeType = exif_imagetype($imageTmpName);

		// если нет ошибок в сравнению MIME типов и нет ошибок (число 0) в массиве ошибок загруженного изображения
		if (in_array($imageMimeType, $checkedMimeType) && ($imageArray['error'][$i] < 1)) {
			move_uploaded_file($imageTmpName, $pathToUpload . $imageName);
			array_push($persona_info_data['info_data']['persona_images'], $imageName);
		} else {
			die('ошибка загрузки файлов');
		}
	}
}