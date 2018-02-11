<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/params.php');
require_once (INCLUDES_DIR.'arrays.php');
require_once (INCLUDES_DIR.'header.html');

/*echo '<pre>';
var_dump($persons_DataBase);
echo '<br>';
echo '</pre>';*/
?>


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
                            // возвращает 1 символ из строки со значением ключа массива (фамилии), в кодировке UTF-8
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

<?php
	include_once (INCLUDES_DIR.'footer.html');
?>
<!--<button class="alphabetButton <?/*=$status*/?>">А</button>
<button class="alphabetButton <?/*=$status*/?>">Б</button>
<button class="alphabetButton <?/*=$status*/?>">В</button>
<button class="alphabetButton">Г</button>
<button class="alphabetButton">Ґ</button>
<button class="alphabetButton">Д</button>
<button class="alphabetButton">Е</button>
<button class="alphabetButton">Є</button>
<button class="alphabetButton">Ж</button>
<button class="alphabetButton">З</button>
<button class="alphabetButton">И</button>
<button class="alphabetButton">І</button>
<button class="alphabetButton">Ї</button>
<button class="alphabetButton">Й</button>
<button class="alphabetButton">К</button>
<button class="alphabetButton">Л</button>
<button class="alphabetButton">М</button>
<button class="alphabetButton">Н</button>
<button class="alphabetButton">О</button>
<button class="alphabetButton">П</button>
<button class="alphabetButton">Р</button>
<button class="alphabetButton">С</button>
<button class="alphabetButton">Т</button>
<button class="alphabetButton">У</button>
<button class="alphabetButton">Ф</button>
<button class="alphabetButton">Х</button>
<button class="alphabetButton">Ц</button>
<button class="alphabetButton">Ч</button>
<button class="alphabetButton">Ш</button>
<button class="alphabetButton">Щ</button>
<button class="alphabetButton">Ю</button>
<button class="alphabetButton">Я</button>
-->
