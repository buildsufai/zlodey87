<?php

class Helper
{

    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses self::ruEnding(...)
     * http://habrahabr.ru/post/53210/
     */
    public static function num2str($num)
    {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array(// Units
            array('тиын', 'тиына', 'тиын', 1),
            array('тенге', 'тенге', 'тенге', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v))
                    continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1)
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];# 20-99
                else
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];# 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1)
                    $out[] = self::ruEnding($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        }
        else
            $out[] = $nul;
        $out[] = self::ruEnding(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        //$out[] = $kop . ' ' . self::ruEnding($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Переводит первый символ в строке в верхний регистр, в т.ч.
     * для многобайтных кодировок.
     * @param string $string
     * @return string
     */
    public static function mb_ucfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }

    // подсказки
    public static function hintReplace($v)
    {
        $pattern = '/\s|\.|,|-|"|\>|\</';
        $hints = Hint::getAll();
        foreach ($hints as $hint) {
            $k = 0;
            if (mb_stripos($v, $hint["q"]) !== false) {
                $words = preg_split($pattern, $v, 0, PREG_SPLIT_OFFSET_CAPTURE);
                foreach ($words as $word) {
                    if (mb_strtolower($word[0]) == mb_strtolower($hint["q"])) {
                        $img = '<a href="#" title="' . $hint["hint"] . '" class="replaceTooltip" ><img src="/css/images/q.png" /></a>';
                        $v = substr_replace($v, $word[0] . $img, $word[1] + $k, strlen($word[0]));
                        $k += strlen($img);
                    }
                }
            }
        }
        echo $v;
    }

    // очистка данных пришедших через jquery ajax
    public static function ajaxClear($v)
    {
        return trim(urldecode($v));
    }

    // отладка кода
    public static function dbg($v)
    {
        echo '<pre>';
        var_dump($v);
        exit();
    }

    // проверить данные на целое число
    public static function isInt($v)
    {
        $v = trim($v);
        if (!empty($v)) {
            if (strpos($v, '.') === false && strpos($v, ',') === false) {
                if ($v === 0 || $v > 0) {
                    return true;
                }
            }
        } else {
            return true;
        }
        return false;
    }

    // сохранить изображение с помощью curl из https
    public static function saveImageFromHttpsWithCurl($url, $image)
    {
        $ch = curl_init($url);
        $fp = fopen($image, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        $response = curl_exec($ch);
        curl_close($ch);
        fwrite($fp, $response);
        fclose($fp);
    }

    // перевести данные в массив
    public static function dataToConfig($v)
    {
        return explode(',', rtrim($v, ','));
    }

    // выполнить sql запрос
    public static function execute($sql)
    {
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    // построить sql запрос
    public static function update($sql, $field, $v, $v2, $cache = '')
    {
        if ($v[0] != '' || $v2[0] != '') {
            $sql .= $field . ' = CASE id ';
            if ($v[0] != '') {
                foreach ($v as $v) {
                    list($id, $value) = explode('=', $v);
                    if ($cache != '') {
                        Yii::app()->cache->delete($cache . $id);
                    }
                    $sql .= 'WHEN ' . rtrim($id, ' selected') . ' THEN ' . $value . ' ';
                }
            }
            if ($v2[0] != '') {
                foreach ($v2 as $v2) {
                    list($id2, $value2) = explode('=', $v2);
                    if ($cache != '') {
                        Yii::app()->cache->delete($cache . $id2);
                    }
                    $sql .= 'WHEN ' . rtrim($id2, ' selected') . ' THEN ' . $value2 . ' ';
                }
            }
            $sql .= 'END';
        }
        return $sql;
    }

    // построить sql запрос
    public static function update2($sql, $field, $v, $cache = '')
    {
        if (count($v)) {
            $sql .= ', ' . $field . ' = CASE id ';
            foreach ($v as $v) {
                list($id, $value) = explode('=', $v);
                if ($cache != '') {
                    Yii::app()->cache->delete($cache . $id);
                }
                $sql .= 'WHEN ' . rtrim($id, ' selected') . ' THEN ' . $value . ' ';
            }
            $sql .= 'END';
        }
        return $sql;
    }

    public static function getItemsByParent($items)
    {
        //create new list grouped by parent id
        $itemsByParent = array();
        foreach ($items as $item) {
            if (!isset($itemsByParent[$item['parent_id']])) {
                $itemsByParent[$item['parent_id']] = array();
            }

            $itemsByParent[$item['parent_id']][] = $item;
        }
        return $itemsByParent;
    }

    // print list recursively 
    public static function printList($items, $parentId = 0, $level = 0)
    {
        ob_start();
        foreach ($items[$parentId] as $item) {
            if ($item['parent_id'] == 0) {
                echo '<tr id="' . $item['id'] . '"><td class="icon-box">';
                echo '<a href="/admin/page/delete/' . $item['id'] . '" title="удалить запись" class="delete"><img alt="удалить запись" src="/css/gridview/delete.png"></a></td>';
                echo '<td>' . $item['title'] . '</td><td class="icon-box"></td>';
                echo '<td class="icon-box"><a href="/admin/subpage/' . $item['id'] . '/create" title="создать подрубрику" class="subcat"><img alt="редактировать запись" src="/css/gridview/subcat.png"></a></td>';
                echo '<td class="icon-box"><a href="/admin/page/' . $item['id'] . '" title="редактировать запись" class="update"><img alt="редактировать запись" src="/css/gridview/update.png"></a></td>';
                echo '<td class="sort-cell"><input value="' . $item['sort'] . '" id="' . $item['id'] . '" class="sort" type="text" name="sort" /></td><td class="inmenu-cell">';
                if ($item['menu'] == 1) {
                    echo '<input value="1" checked="checked" id="' . $item['id'] . '" class="menu" type="checkbox" name="menu[]" id="menu" />';
                } else {
                    echo '<input value="0" id="' . $item['id'] . '" class="menu" type="checkbox" name="menu[]" id="menu" />';
                }
                echo '</td></tr>';
            } else {
                $sub = $level - 1;
                echo '<tr class="sub" id="' . $item['id'] . '"><td class="none">&nbsp;</td>';
                echo '<td class="sub' . $sub . '">';
                echo '<a href="/admin/page/delete/' . $item['id'] . '" title="удалить запись" class="del"><img alt="удалить запись" src="/css/gridview/del.gif"></a>';
                echo $item['title'] . '</td><td class="icon-box"></td>';
                echo '<td class="icon-box"><a href="/admin/subpage/' . $item['id'] . '/create" title="создать подрубрику" class="subcat"><img alt="редактировать запись" src="/css/gridview/subcat.png"></a></td>';
                echo '<td class="icon-box"><a href="/admin/page/' . $item['id'] . '" title="редактировать запись" class="update"><img alt="редактировать запись" src="/css/gridview/update.png"></a></td>';
                echo '<td class="sort-cell"><input value="' . $item['sort'] . '" id="' . $item['id'] . '" class="sort" type="text" name="sort" /></td><td class="inmenu-cell">';
                if ($item['menu'] == 1) {
                    echo '<input value="1" checked="checked" id="' . $item['id'] . '" class="menu" type="checkbox" name="menu[]" id="menu" />';
                } else {
                    echo '<input value="0" id="' . $item['id'] . '" class="menu" type="checkbox" name="menu[]" id="menu" />';
                }
                echo '</td></tr>';
            }

            $curId = $item['id'];
            //if there are children
            if (!empty($items[$curId])) {
                self::printList($items, $curId, $level + 1);
            }
        }
        ob_end_flush();
    }

    /**
     * Осуществить прямую (из русского в английский) транслитерацию переданной методу строки.
     */
    public static function transliterate($str)
    {
        static $lookupTable = array(
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'CSH', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '', 'Э' => 'E', 'Ю' => 'YU',
        'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',
        'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'csh', 'ь' => '', 'ы' => 'y', 'ъ' => '', 'э' => 'e',
        'ю' => 'yu', 'я' => 'ya',
        );
        return str_replace(array_keys($lookupTable), array_values($lookupTable), $str);
    }

    /**
     * По переданной в метод строке возвращает строку, пригодную для использования в ссылках.
     * Пример: передали "Тестовая строка 123", получили "testovaya-stroka-123".
     */
    public static function url($str)
    {
        // транслитерация строки
        $url = self::transliterate($str);

        // убираем whitespace символы на концах и переводим в нижний регистр
        $url = mb_strtolower(trim($url));

        // убираем дублирующиеся пробелы в центре строки
        for ($i = 0; $i < 10; $i++)
            $url = str_replace('  ', ' ', $url);

        // пробелы заменяем на дефисы
        $url = str_replace(' ', '-', $url);

        // оставляем только латинские цифры, буквы и дефисы
        $url = preg_replace('#[^A-Za-z0-9\-]#ui', '', $url);

        // убираем дублирующиеся дефисы в центре строки
        for ($i = 0; $i < 10; $i++)
            $url = str_replace('--', '-', $url);

        // если в результате получилась пустая строка или строка длиной в два символа то просто
        // сгенерируем md5 хэш от оригинальной строки с примесью случайности и вернем его
        if (!$url || mb_strlen($url) <= 2)
            $url = mb_substr(md5($str), 0, 8) . self::random(8, 8, true, true);

        // строка для ссылки свыше 45 символов не совсем удобно
        if (mb_strlen($url) > 45)
            $url = mb_substr($url, 0, 40);

        return $url;
    }

    /**
     * Генерирует случайную строку.
     * @param integer $minLength минимальная длина строки
     * @param integer $maxLength максимальная длина строки
     * @param boolean $letters добавлять ли в случайную строку буквы
     * @param boolean $numbers добавлять ли в случайную строку числа
     */
    public static function random($minLength = 10, $maxLength = 20, $letters = true, $numbers = true)
    {
        // символы
        $chars = '';
        if ($letters)
            $chars.='abcdefghijklmnopqrstuvwxyz';
        if ($numbers)
            $chars.='0123456789';

        // длина
        $stringLength = mt_rand($minLength, $maxLength);

        $result = '';
        for ($i = 0; $i < $stringLength; $i++)
            $result.=$chars[mt_rand(0, mb_strlen($chars) - 1)];

        return $result;
    }

    // транслитерация
    public static function rus2translit($string)
    {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            ' ' => '-'
        );
        $string = strtr($string, $converter);
        $string = preg_replace("/[^a-zA-Z0-9-]/", '', $string);
        return $string;
    }

    // русская дата
    public static function ruDate($date)
    {
        $months = array('01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля',
            '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа',
            '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря');
        $day = ltrim(substr($date, 8, 2), '0');
        $month = $months[substr($date, 5, 2)];
        $year = substr($date, 0, 4);
        $ruDate = $day . ' ' . $month . ' ' . $year;
        return $ruDate;
    }

    // русская дата 2
    public static function ruDate2($date)
    {
        $months = array('01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля',
            '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа',
            '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря');
        $day = ltrim(substr($date, 8, 2), '0');
        $month = $months[substr($date, 5, 2)];
        $ruDate = $day . ' ' . $month;
        return $ruDate;
    }

    // дата в формате datetime = 'yyyy-mm-dd'
    public static function datetime($date)
    {
        $date = substr($date, 0, 10);
        return $date;
    }

    // удалить все файлы из директории
    public static function cleanDirectory($dir)
    {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                unlink($obj);
            }
        }
    }

    // удалить все файлы из директории b саму директорию
    public static function removeDirRec($dir)
    {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                unlink($obj);
            }
        }
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }

    // функция для отправки сооб-я в utf-8
    public static function mail_utf8($to, $from, $subject, $message)
    {
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From: $from\r\n";

        return mail($to, $subject, $message, $headers);
    }

    // mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    public static function my_mb_ucfirst($str, $e = 'utf-8')
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1, $e), $e);
        return $fc . mb_substr($str, 1, mb_strlen($str, $e), $e);
    }

    // нативная сорт-ка по ключам массива
    public static function knatsort(&$array)
    {
        $array_keys = array_keys($array);
        natsort($array_keys);
        $new_natsorted_array = array();
        $array_keys_2 = '';
        foreach ($array_keys as $array_keys_2) {
            $new_natsorted_array[$array_keys_2] = $array[$array_keys_2];
        }
        $array = $new_natsorted_array;
        return true;
    }

    // список категорий в админке
    public static function printCatList($items, $parentId = 0, $level = 0)
    {
        ob_start();
        foreach ($items[$parentId] as $item) {
            if ($item['parent_id'] == 0) {
                echo '<tr id="' . $item['id'] . '"><td class="icon-box">';
                echo '<a href="' . Yii::app()->createUrl('admin/category/delete/' . $item['id']) . '" title="удалить категорию товаров" class="delete"><img alt="удалить категорию товаров" src="/css/gridview/delete.png"></a></td>';
                echo '<td>' . $item['title'] . '</td><td class="icon-box"></td>';
                echo '<td class="icon-box"><a href="' . Yii::app()->createUrl('admin/subcat/' . $item['id']) . '/create" title="создать подкатегорию" class="subcat"><img alt="редактировать категорию товаров" src="/css/gridview/subcat.png"></a></td>';
                echo '<td class="icon-box"><a href="' . Yii::app()->createUrl('admin/category/' . $item['id']) . '" title="редактировать запись" class="update"><img alt="редактировать категорию товаров" src="/css/gridview/update.png"></a></td>';
                echo '<td class="sort-cell"><input value="' . $item['sort'] . '" id="' . $item['id'] . '" class="sort" type="text" name="sort" /></td><td class="inmenu-cell">';
                if ($item['status'] == 1) {
                    echo '<input value="1" checked="checked" id="' . $item['id'] . '" class="status" type="checkbox" name="status[]" id="status" />';
                } else {
                    echo '<input value="0" id="' . $item['id'] . '" class="status" type="checkbox" name="status[]" id="status" />';
                }
                echo '</td></tr>';
            } else {
                $sub = $level - 1;
                echo '<tr class="sub" id="' . $item['id'] . '"><td class="none">&nbsp;</td>';
                echo '<td class="sub' . $sub . '">';
                echo '<a href="' . Yii::app()->createUrl('admin/category/delete/' . $item['id']) . '" title="удалить категорию товаров" class="del"><img alt="удалить категорию товаров" src="/css/gridview/del.gif"></a>';
                echo $item['title'] . '</td><td class="icon-box"></td>';
                echo '<td class="icon-box"><a href="' . Yii::app()->createUrl('admin/subcat/' . $item['id']) . '/create" title="создать подкатегорию" class="subcat"><img alt="редактировать категорию товаров" src="/css/gridview/subcat.png"></a></td>';
                echo '<td class="icon-box"><a href="' . Yii::app()->createUrl('admin/category/' . $item['id']) . '" title="редактировать запись" class="update"><img alt="редактировать категорию товаров" src="/css/gridview/update.png"></a></td>';
                echo '<td class="sort-cell"><input value="' . $item['sort'] . '" id="' . $item['id'] . '" class="sort" type="text" name="sort" /></td><td class="inmenu-cell">';
                if ($item['status'] == 1) {
                    echo '<input value="1" checked="checked" id="' . $item['id'] . '" class="status" type="checkbox" name="status[]" id="status" />';
                } else {
                    echo '<input value="0" id="' . $item['id'] . '" class="status" type="checkbox" name="status[]" id="status" />';
                }
                echo '</td></tr>';
            }

            $curId = $item['id'];
            //if there are children
            if (!empty($items[$curId])) {
                self::printCatList($items, $curId, $level + 1);
            }
        }
        ob_end_flush();
    }

    // список категорий на сайте
    public static function printCatListF($items, $parentId = 0, $level = 0)
    {
        ob_start();
        foreach ($items[$parentId] as $item) {
            if ($item['parent_id'] == 0) {
                echo "<li><a href='{$item->getUrl()}'>{$item['title']}</a></li>";
            } else {
                echo "<li>" . str_repeat('&nbsp;', $level * 3) . "<a href='{$item->getUrl()}'>{$item['title']}</a></li>";
            }
            $curId = $item['id'];
            //if there are children
            if (!empty($items[$curId])) {
                self::printCatListF($items, $curId, $level + 1);
            }
        }
        ob_end_flush();
    }

    /**
     * Возвращает 1 из 3 переданных параметров на основе анализа параметра $num.
     * Если $num попадает в группу числительных, генерирующих окончания русского
     * языка типа "1 предмет" - возвращает $v1, если "2 предмета" - $v2, если
     * "5 предметов" - $v5.
     *
     * @param int $num  число
     * @param mixed $v1 результат 1
     * @param mixed $v2 результат 2
     * @param mixed $v5 результат 5
     *
     * @return mixed
     */
    public static function ruEnding($num, $v1, $v2, $v5 = null)
    {
        $mod = $num % 10;
        $cond = floor(($num % 100) / 10) != 1;
        if ($mod == 1 && $cond) {
            return $v1;
        } elseif ($mod >= 2 && $mod <= 4 && $cond || $v5 === null) {
            return $v2;
        } else {
            return $v5;
        }
    }

}
