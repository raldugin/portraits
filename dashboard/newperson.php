<?php
// ctrl + alt + t - оборачиваем в конструкцию языка
// ctrl + о - темплейты языка
// ctrl + clik на переменной показывает где она используется
// ctrl + alt + j - заворачиваем в html tag
//var_dump(function_exists('exif_imagetype'));


require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/params.php');
//require_once '../includes/params.php';
require_once INCLUDES_DIR . 'arrays.php';
require_once INCLUDES_DIR . 'database.php';
require_once INCLUDES_DIR . 'filesUpload.php';

$persona_id = $persona_photo_avatar = $persona_avatarka_text = $persona_zagolovok =
$persona_photo_author = $persona_author_name = $persona_author_place = $persona_author_age =
$persona_promo_video = $persona_collection_link = $persona_other_video =
$persona_library = $ckeditor = $persona_photo_avatar = $persona_photo_author = $persona_images = '';

// конвертор из UTF-8 в CP1251 кодировку (имя файлов и директориев на UNIX системах)
function utf8_to_cp1251($string)
{
	return iconv('utf-8', 'cp1251', $string);
}
function removeDir($dir)
{
	$files = array_diff(scandir($dir), array('.', '..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? removeDir("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

if (isset($_POST['persona_id'])) {
	if (!empty($_POST['persona_id'])) {
		$persona_dir = utf8_to_cp1251($portraits_dir . $_POST['persona_id']);
		$persona_image_dir = $persona_dir . '/img/';
		$persona_photo_avatar_dir = $persona_image_dir . '/avatar/';
		$persona_photo_author_dir = $persona_image_dir . '/author/';
		$persona_pdf_dir = $persona_dir . '/pdf/';

		$persona_id = mysqli_real_escape_string($_POST['persona_id']);
		$persona_zagolovok = $_POST['persona_zagolovok'];
		$persona_avatarka_text = $_POST['persona_avatarka_text'];
		$persona_main_text_ckeditor = $_POST['ckeditor'];
		$persona_author_name = $_POST['persona_author_name'];
		$persona_author_place = $_POST['persona_author_place'];
		$persona_author_age = $_POST['persona_author_age'];
		$persona_promo_video = $_POST['persona_promo_video'];
		$persona_collection_link = $_POST['persona_collection_link'];
		$persona_other_video = $_POST['persona_other_video'];
		$persona_library = $_POST['persona_library'];

		$persona_main_data [$persona_id] =
			//'persona_photo_avatar' => $persona_photo_avatar,
			[
				'persona_zagolovok' => $persona_zagolovok,
                'persona_avatarka_text' => $persona_avatarka_text,
				'persona_main_text' => $persona_main_text_ckeditor
            ];
		$persona_info_data ['info_data'] =
			[
			    'persona_images' => [],
				'persona_photo_avatar' => '',
                'persona_photo_author' => '',
                'persona_author_name' => $persona_author_name,
                'persona_author_place' => $persona_author_place,
				'persona_author_age' => $persona_author_age,
                'persona_promo_video' => $persona_promo_video,
                'persona_collection_link' => $persona_collection_link,
                'persona_other_video' => $persona_other_video,
                'persona_library' => $persona_library,
                'persona_pdf' => []
		    ];

		if (!is_dir($persona_dir)) {
			mkdir($persona_dir);
			mkdir($persona_image_dir);
			mkdir($persona_photo_avatar_dir);
			mkdir($persona_photo_author_dir);
			mkdir($persona_pdf_dir);
		} else {
			echo 'директорий уже создан или не получилось создать';
		}


		if (isset($_POST['delete'])) {
			removeDir($persona_dir);
		}



		if (!empty($_FILES['persona_photo_avatar']['name'])) {
			upload_single_image($_FILES['persona_photo_avatar'], $persona_photo_avatar_dir, 'persona_photo_avatar');
		}
		if (!empty($_FILES['persona_photo_author']['name'])) {
			upload_single_image($_FILES['persona_photo_author'], $persona_photo_author_dir, 'persona_photo_author');
		}
		if (!empty($_FILES['persona_panorama']['name'])) {
			upload_single_image($_FILES['persona_panorama'], $persona_image_dir, 'persona_panorama');
		}
		if (!empty($_FILES['persona_images']['name'][0])) {
			upload_multiple_image($_FILES['persona_images'], $persona_image_dir);
		}
		if (!empty($_FILES['persona_pdf']['name'][0])) {
			upload_single_file($_FILES['persona_pdf'], $persona_pdf_dir);
		}


		/*echo '<pre>';
		echo '<hr>';
		echo 'array main data';
		print_r($persona_main_data);
		echo '<hr>';
		echo 'array info data';
		print_r($persona_info_data);
		echo '<hr>';
		echo 'Post data';
		print_r($_POST);
		echo '<hr>';
		echo 'FILES data';
		print_r($_FILES);
		echo '</pre>';*/

		// создаем базу и таблицу, если еще не созданы
		create_DB_table ($servername,$username,$password,$dbname);

		// инсертим в таблицу подготовленные данные
		$persona_info_data = serialize($persona_info_data);
		insert_DB_data ($servername,$username,$password,$dbname, $persona_id, $persona_zagolovok, $persona_avatarka_text, $persona_main_text_ckeditor, $persona_info_data);

        // // читаем данные из таблицы
		read_DB_data ($servername,$username,$password,$dbname); // var для поиска по Фамилии $search_string='...'

	} else {
		die('Укажите Фамилию и Имя персоналии');
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
    <link rel="stylesheet" href="/assets/css/bootstrap.css" media="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <style>
        .btn-custom {
            margin-bottom: 5px;
            width: 100%;
            max-width: 100%;
            padding: 10px 0;
        }

        .BtnRemove_off {
            display: none;
        }

        .form-group {
            margin-bottom: 30px;
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        input:focus:-moz-placeholder {
            color: transparent;
        }

        textarea:focus::-webkit-input-placeholder {
            color: transparent;
        }

        textarea:focus:-moz-placeholder {
            color: transparent;
        }
        [contenteditable="false"]::after{
            content:"Edit Me!";
            outline: 1px solid Red;
        }

    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="margin-bottom: 20px; padding: 20px 0; background: #afb42b; text-align: center;">
            <h4>Інформація про нову персоналію та автора</h4>
        </div>
    </div>
    <form id='mainForm' method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-8">
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Прізвище та Ім'я Персоналії</b></label>
                            <input type="text" class="form-control" name="persona_id"
                                   placeholder="Введіть Прізвище та Ім'я">
                            <small id="emailHelp" class="form-text text-muted">Перше - Прізвище, друге - Ім'я</small>
                        </div>
                    </div>
                </div>
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputFile"><b>Аватар персоналії</b></label>
                            <input type="file" class="form-control-file" name="persona_photo_avatar">
                            <small id="fileHelp" class="form-text text-muted">Размер фото - 400х267 пикселей</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea"><b>Опис під аватаром</b></label>
                            <textarea class="form-control" name="persona_avatarka_text" placeholder="Введіть цитату под аватаркой" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Заголовок статті</b></label>
                            <input type="text" class="form-control" name="persona_zagolovok"
                                   placeholder="Введіть заголовок статті">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile"><b>Фотографії основної статті</b></label>
                            <input type="file" class="form-control-file" name="persona_images[]" multiple="">
                            <small id="fileHelp" class="form-text text-muted">Размер фото - 1000х667 пикселей</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile"><b>Фото панорами статті</b></label>
                            <input type="file" class="form-control-file" name="persona_panorama">
                            <small id="fileHelp" class="form-text text-muted">Размер фото - 1000х667 пикселей</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea"><b>Текст статті</b></label>
                            <textarea class="form-control" name="ckeditor" placeholder=""></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-4">
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputFile"><b>Аватар автора</b></label>
                            <input type="file" class="form-control-file" name="persona_photo_author">
                            <small id="fileHelp" class="form-text text-muted">Размер фото - 267х267 пикселей</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Місцезнаходження</b></label>
                            <input type="text" class="form-control" name="persona_author_place"
                                   placeholder="Його місцезнаходження">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Автор або заклад</b></label>
                            <input type="text" class="form-control" name="persona_author_name"
                                   placeholder="Введіть І'мя або заклад">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Вік</b></label>
                            <input type="text" class="form-control" name="persona_author_age"
                                   placeholder="Вік автора">
                        </div>
                    </div>
                </div>
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Головне відео про персоналію</b></label>
                            <input type="text" class="form-control" name="persona_promo_video"
                                   placeholder="Адреса відео на YOUTUBE">
                            <small id="emailHelp" class="form-text text-muted">В форматі -
                                https://www.youtube.com/embed/OSWAWEcRvbg?rel=0
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Артефакти (Посилання на колекцію)</b></label>
                            <input type="text" class="form-control" name="persona_collection_link"
                                   placeholder="Лінк на колекцію">
                        </div>
                    </div>
                </div>

                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="otherVideo"><b>Відео (Посилання на додаткове відео)</b></label>
                            <input id="otherVideo" type="text" class="form-control clone_more_video" name="persona_other_video[]">
                        </div>
                        <button type="button" class="btn btn-success add" data-clone="clone_more_video">+</button>
                        <button type="button" class="btn btn-success remove BtnRemove_off"
                                data-remove="clone_more_video" data-count="1">-
                        </button>
                    </div>
                </div>

                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Бібліотека</b></label>
                            <input type="text" class="form-control clone_library" name="persona_library[]"
                                   placeholder="Матеріали">
                        </div>
                        <button type="button" class="btn btn-success add" data-clone="clone_library">+</button>
                        <button type="button" class="btn btn-success remove BtnRemove_off" data-remove="clone_library"
                                data-count="1">-
                        </button>
                    </div>
                </div>
                <div class="card card-outline-secondary mb-3">
                    <div class="card-block">
                        <div class="form-group">
                            <label for="exampleInputFile"><b>Файли бібліотеки (pdf)</b></label>
                            <input type="file" class="form-control-file clone_library_file" name="persona_pdf[]" multiple="" accept="application/pdf">
                        </div>
                        <button type="button" class="btn btn-success add" data-clone="clone_library_file">+</button>
                        <button type="button" class="btn btn-success remove BtnRemove_off"
                                data-remove="clone_library_file" data-count="1">-
                        </button>
                    </div>
                </div>


            </div>
        </div>
        <div style="margin-bottom: 50px;">
            <button class="btn btn-primary" type='submit'>Создать</button>
<!--            <button class="btn btn-primary" type='submit' name="delete">Удалить дир</button>-->
        </div>
    </form>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

<script src="/ckeditor/ckeditor.js"></script>
<script>

    $(document).ready(function () {

        /*
        CKEDITOR.editorConfig = function( config ) {
			 //the name of the styles to load.
			 //NOTE: all the default styles will be overridden.
			 config.stylesSet = 'my_styles';
		 };
        */

        // изменение дефолтных стилей
        CKEDITOR.stylesSet.add('default', [
            /* My Block Styles */
            {name: 'My Div Class', element: 'div', attributes: {'class': 'my-div-class-name1'}},
            {name: 'My Div Style', element: 'div', styles: {'padding': '10px 20px', 'background': '#f2f2f2', 'border': '1px solid #ccc'}},
            {name: 'panorama', element: 'div', attributes: {'class': 'panorama'}},

            {name: 'My p Class', element: 'p', attributes: {'class': 'p-class'}},
            {name: 'My P Style', element: 'p', styles: {'background': '#aaaaaa', 'text-align': 'center'}},

            /* My Inline Styles */
            {name: 'My Span Class', element: 'span', attributes: {'class': 'my-span-class-name'}},
            {name: 'My Span Style', element: 'span', styles: {'font-weight': 'bold', 'font-style': 'italic'}}

        ]);
/*
        // ========= старты редактора ==============
        CKEDITOR.replace( 'ckeditor' );
*/
        CKEDITOR.replace('ckeditor', {
            //uiColor: '#9AB8F3',
            //stylesSet: 'my_styles'
            filebrowserUploadUrl: "/ckeditor/imgupload/my_upload.php",
            // прослушиваем изменения которые внесены в редакторе и выводим на консоль
            on: {
                change: function( evt ) {
                    console.log( 'Total bytes: ' + evt.editor.getData().length );
                }
            },
            //fullPage: true
        });

        //CKEDITOR.config.uploadUrl = '/ckeditor/imgupload/my_upload.php';

        /*CKEDITOR.config.templates = 'default';
        CKEDITOR.config.templates_files = [ '/mytemplates/mytemplates.js' ];
        CKEDITOR.config.templates_replaceContent = true;*/

        // отключаем фильтрацию контента, т.е. доступны все HTML-тэги из входящего потока
        CKEDITOR.config.allowedContent = true;
        // разрешить использовать тэги PHP
        CKEDITOR.config.protectedSource.push(/<\?[\s\S]*?\?>/g); // PHP Code
        // разрешить использовать определенный тэг (тут STYLE)
        //CKEDITOR.config.protectedSource.push(/<(style)[^>]*>.*<\/style>/ig);
        // язык интерфейса
        CKEDITOR.config.language = 'ru';
        // загрузка плагинов в редактор
        CKEDITOR.config.extraPlugins = 'showblocks,justify,stylesheetparser,dialog,htmlwriter,templates,div,popup,filetools,filebrowser,imagebrowser,lineutils,widgetselection,widget,simplebox';
        // imagebrowser,
        // slideshow,
        // ,filebrowser,simpleImageUpload
        // ,imageCustomUploader
        // ,toolbar,widget,widgetselection,lineutils,notification,clipboard'
        // загрузка кастомных CSS стилей в редактор
        CKEDITOR.config.contentsCss = '/assets/css/bootstrap.css';
        // загрузка контента в редактор
        CKEDITOR.instances.ckeditor.setData('', function () { //  '<\?= $tmp ?>'
            this.checkDirty();
        });

        CKEDITOR.config.autoParagraph = false;
        CKEDITOR.config.fillEmptyBlocks = false;
        //CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_P;
        //CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.ignoreEmptyParagraph = false;
        // по нажатию кнопки SUBMIT формы '#mainForm', получаем данные из CKEDITOR-text area с name="ckeditor",
        // ищем искомое значение ('Фото панорамы') и меняем его на другое (тут экранированны PHP-код <\?= $panoramaImg \?>)
        // устанавливаем новые данные в ckeditor
        $('#mainForm').submit(function(){
            var content = CKEDITOR.instances['ckeditor'].getData();
            var replacedContent = content.replace('Фото панорамы', ''); // <\?= $panoramaImg \?>
            CKEDITOR.instances.ckeditor.setData(replacedContent, function () {
                this.checkDirty();
            });
        });


        // получить данные из textarea к которой подключен CKEDITOR (ckeditor - значение атрибута name='' textarea)
        //var data = CKEDITOR.instances.ckeditor.getData();

        // прослушиваем изменения которые внесены в редакторе и выводим на консоль
        /*
            CKEDITOR.instances.ckeditor.on('change', function() {
            console.log("TEST");
        });
        */

        /* -------------------------------- ADD or Remove element --------------------------------- */
        var counter;
        $('.add').click(function () {
                // клонируем элемент, получая его класс, например clone_more_video, прописанный в data-clone кнопки
                // <button type="button" class="btn btn-success" id="add" data-clone="clone_more_video">+</button>
                var item = '.' + $(this).attr('data-clone');
                var lastitem = $(item).filter(':last');

                counter = $(this).next().attr('data-count');
                counter++;
                $(this).next().attr('data-count', counter);
                // находим последний элемент $(item).filter(':last')
                // клонируем, вставляем его после исходного и очищаем его значение value ( для INPUT тэгов)
                $(item).filter(':last').clone().insertAfter(lastitem).val('');
                $(this).next().one().removeClass('BtnRemove_off');

            }
        );
        // удаляем элемент
        $('.remove').click(function () {
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
        /* -------------------------------- END ADD or Remove element --------------------------------- */



    });

</script>
</html>


