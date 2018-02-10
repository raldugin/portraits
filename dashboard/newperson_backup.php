<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/params.php');
require_once (INCLUDES_DIR.'arrays.php');

$persona_id = $persona_photo_avatar = $persona_avatarka_text = $persona_zagolovok =
$persona_photo_author = $persona_author_name = $persona_author_place =
$persona_promo_video = $persona_collection_link = $persona_other_video = '';

if (isset($_POST['persona_id']))
{
    if (!empty($_POST['persona_id']))
    {
    $persona_dir = $portraits_dir . $_POST['persona_id'];
    $persona_image_dir = $persona_dir . '/img/';
    $persona_photo_avatar_dir = $persona_image_dir . '/avatar/';
    $persona_photo_author_dir = $persona_image_dir . '/author/';

    $persona_id = $_POST['persona_id'];
    $persona_avatarka_text = $_POST['persona_avatarka_text'];
    $persona_zagolovok = $_POST['persona_zagolovok'];
    $persona_author_name = $_POST['persona_author_name'];
    $persona_author_place = $_POST['persona_author_place'];
    $persona_promo_video = $_POST['persona_promo_video'];
    $persona_collection_link = $_POST['persona_collection_link'];
    $persona_other_video = $_POST['persona_other_video'];

    $persona_data [$persona_id] = [
        //'persona_photo_avatar' => $persona_photo_avatar,
        'persona_avatarka_text' => $persona_avatarka_text,
        'persona_zagolovok' => $persona_zagolovok,

        //'persona_photo_author' => $persona_photo_author,
        'persona_author_name' => $persona_author_name,
        'persona_author_place' => $persona_author_place,

        'persona_promo_video' => $persona_promo_video,
        'persona_collection_link' => $persona_collection_link,
        'persona_other_video' => $persona_other_video,
        'persona_images' => []
    ];
    echo '<pre>';
    print_r($_POST);
    //print_r($persona_data);
    print_r($_FILES);
    var_dump($_FILES['persona_images']['name']);
    echo '</pre>';

    if (!is_dir($persona_dir)) {
        mkdir($persona_dir);
        mkdir($persona_image_dir);
        mkdir($persona_photo_avatar_dir);
        mkdir($persona_photo_author_dir);
    }
    /**
     * @param $imageArray - массив атрибутов изображения из $_FILES
     *                      ['name'] - имя файла,
     *                      ['type'] - mimi тип файла
     *                      ['tmp_name'] - временное имя файла который сохранен в папке tmp php-интерпритатора
     *                      ['error'] - 0 когда нет ошибок, если 1-4 означает коды ошибок
     *                      ['size'] - размер файла в Кб
     * @param $pathToUpload - путь куда надо сохранять файл если нет ошибок по проверке MIME типу файла
     * @param $key          - имя нового ключа массива $persona_data [$persona_id],
     *                      где его значение на выходе это имя файла, которое залито в директорию
     */
    function upload_single_image ($imageArray, $pathToUpload, $key)
    {
        echo '<pre>';
        print_r($imageArray);
        echo '</pre>';

        global $persona_data, $persona_id;
        $imageName = $imageArray['name'];
        $imageTmpName = $imageArray['tmp_name'];
        //  exif_imagetype - читает первые байты изображения и проверяет его подпись
        $imageMimeType = exif_imagetype($imageTmpName);
        $checkedMimeType = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

        if (in_array($imageMimeType, $checkedMimeType) && ($imageArray['error'] < 1) )
        {
            move_uploaded_file($imageTmpName,$pathToUpload . $imageName);
            $persona_data [$persona_id]=array_merge($persona_data [$persona_id], [$key=>$imageName]);
        }
        else {
            die('ошибка загрузки файлов');
        }
    }

    /**
     * @param $imageArray       - $imageArray - массив атрибутов изображения из $_FILES
     * @param $pathToUpload     - путь куда надо сохранять файл если нет ошибок по проверке MIME типу файла
     */
    function upload_multiple_image ($imageArray, $pathToUpload)
    {
        global $persona_data, $persona_id;
        // считаем количество элементов массива, что равно кол-ву загруженных изображений
        $imageCounter = count($imageArray['name']);
        $checkedMimeType = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

        for ($i=0; $i < $imageCounter; $i++)
        {
            $imageName = $imageArray['name'][$i];
            $imageTmpName = $imageArray['tmp_name'][$i];
            $imageMimeType = exif_imagetype($imageTmpName);

            // если нет ошибок в сравнению MIME типов и нет ошибок (число 0) в массиве ошибок загруженного изображения
            if ( in_array($imageMimeType, $checkedMimeType) && ($imageArray['error'][$i] < 1) )
            {
                move_uploaded_file($imageTmpName,$pathToUpload . $imageName);
                array_push($persona_data [$persona_id]['persona_images'], $imageName);
            }
            else {
                die('ошибка загрузки файлов');
            }
        }
    }

    if (!empty($_FILES['persona_photo_avatar']['name']))
    {
        upload_single_image ($_FILES['persona_photo_avatar'], $persona_photo_avatar_dir, 'persona_photo_avatar');
    }
    if (!empty($_FILES['persona_photo_author']['name']))
    {
        upload_single_image ($_FILES['persona_photo_author'], $persona_photo_author_dir, 'persona_photo_author');
    }
    if (!empty($_FILES['persona_images']['name'][0]))
    {
        upload_multiple_image ($_FILES['persona_images'], $persona_image_dir);
    }

    echo '<pre>';
    print_r($persona_data);
    echo '</pre>';
    }
    else {
        die('не указана персоналия');
    }
}

?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Нова персона</title>
    <link rel="stylesheet" href="/assets/css/normalize.css" media="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <style>
        .btn-custom {
            margin-bottom: 5px;
            width: 100%;
            max-width: 100%;
            padding: 10px 0;
        }
        .BtnRemove_off{
            display: none;
        }
        th {
            vertical-align: middle !important;
        }
        th:first-child {
            width: 80px;
        }
        .form-group {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="margin-bottom: 20px; padding: 20px 0; background: #d1d1d1; text-align: center;">
            <h4>Інформація про нову персоналію та автора</h4>
        </div>
    </div>
    <form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-7">
                <div class="form-group">
                    <label for="exampleInputEmail1"><b>Прізвище та Ім'я Персоналії</b></label>
                    <input type="text" class="form-control" name="persona_id" placeholder="Введіть Прізвище та Ім'я">
                    <small id="emailHelp" class="form-text text-muted">Перше - Прізвище, друге - Ім'я</small>
                </div>
            <div class="form-group">
                <label for="exampleInputFile"><b>Аватар персоналії</b></label>
                <input type="file" class="form-control-file" name="persona_photo_avatar">
                <small id="fileHelp" class="form-text text-muted">Размер фото - 400х267 пикселей</small>
            </div>
            <div class="form-group">
                <label for="exampleTextarea"><b>Опис під аватаром</b></label>
                <textarea class="form-control" name="persona_avatarka_text" placeholder="Введіть цитату под аватаркой" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1"><b>Заголовок статті</b></label>
                <input type="text" class="form-control" name="persona_zagolovok" placeholder="Введіть заголовок статті">
            </div>
            <div class="form-group">
                <label for="exampleInputFile"><b>Основні фотографії</b></label>
                <input type="file" class="form-control-file" name="persona_images[]" multiple="">
                <small id="fileHelp" class="form-text text-muted">Размер фото - 1000х667 пикселей</small>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label for="exampleInputFile"><b>Аватар автора</b></label>
                <input type="file" class="form-control-file" name="persona_photo_author">
                <small id="fileHelp" class="form-text text-muted">Размер фото - 267х267 пикселей</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1"><b>Автор або заклад</b></label>
                <input type="text" class="form-control" name="persona_author_name" placeholder="Введіть І'мя або заклад">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1"><b>Місцезнаходження</b></label>
                <input type="text" class="form-control" name="persona_author_place" placeholder="Його місцезнаходження">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1"><b>Головне відео про персоналію</b></label>
                <input type="text" class="form-control" name="persona_promo_video" placeholder="Адреса відео на YOUTUBE">
                <small id="emailHelp" class="form-text text-muted">В форматі - https://www.youtube.com/embed/OSWAWEcRvbg?rel=0</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1"><b>Артефакти (Посилання на колекцію)</b></label>
                <input type="text" class="form-control" name="persona_collection_link" placeholder="Лінк на колекцію">
            </div>

            <div class="form-group clone_more_video">
                <label for="exampleInputEmail1"><b>Відео (Посилання на додаткове відео)</b></label>
                <input type="text" class="form-control" name="persona_other_video[]" placeholder="Адреса відео">
            </div>
            <button type="button" class="btn btn-success add" data-clone="clone_more_video">+</button>
            <button type="button" class="btn btn-success remove BtnRemove_off" data-remove="clone_more_video" data-count="1">-</button>

            <div class="form-group clone_library">
                <label for="exampleInputEmail1"><b>Бібліотека</b></label>
                <input type="text" class="form-control" name="persona_library[]" placeholder="Матеріали">
            </div>
            <button type="button" class="btn btn-success add" data-clone="clone_library">+</button>
            <button type="button" class="btn btn-success remove BtnRemove_off" data-remove="clone_library" data-count="1">-</button>
        </div>
    </div>
        <button class="btn btn-primary" type='submit'>Создать</button>
    </form>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){


            var counter;
            $('.add').click(function()
                {
                    // клонируем элемент получая его класс, например clone_more_video, прописанный в data-clone кнопки
                    // <button type="button" class="btn btn-success" id="add" data-clone="clone_more_video">+</button>
                    var item = '.' + $(this).attr('data-clone');
                    var lastitem = $(item).filter(':last');

                    counter = $(this).next().attr('data-count');
                    counter++;
                    $(this).next().attr('data-count', counter);

                    $(item).filter(':last').clone().insertAfter(lastitem);
                    $(this).next().one().removeClass('BtnRemove_off');

                }
            );
            // удаляем элемент
            $('.remove').click(function()
                {
                    var item = '.' + $(this).attr('data-remove');

                    counter = $(this).attr('data-count');
                    counter--;
                    $(this).attr('data-count', counter);

                    $(item).filter(':last').remove();
                    if (counter <= 1) {
                        $(this).addClass('BtnRemove_off');
                    }
                }
            );
    });

</script>
</html>


