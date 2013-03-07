<?php

/*
 * Установка/получение внутренней кодировки скрипта
 * кодировка, в которую будут преобразовываться входные данные HTTP запроса, 
 * из которой будет конвертироваться HTTP вывод, а также это кодировка 
 * по умолчанию для всех функций работающих со строками, определенными в модуле mbstring
 */
mb_internal_encoding('UTF-8');
// Возвращает текущую кодировку для многобайтового регулярного выражения в виде строки
mb_regex_encoding('UTF-8');
// Определение кодировки символов входных данных HTTP-запроса
mb_http_input('UTF-8');
//  Установка/получение кодировки символов HTTP вывода
mb_http_output('UTF-8');
// Устанавливает общие настройки локали
setlocale(LC_ALL, 'ru_RU.UTF-8');
// задает символ десятичного разделения
setlocale(LC_NUMERIC, 'en_US.UTF-8');
// установка часового пояса
date_default_timezone_set('Asia/Almaty');

// change the following paths if necessary
$yii = __DIR__ . '/framework-1.1.13/yii.php';
$config = __DIR__ . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$app = Yii::createWebApplication($config);
Yii::app()->onBeginRequest = function($event)
{
	// начиная буферизацию вывода с обработчиком GZIP
	return ob_start("ob_gzhandler");
};
// присоединения обработчика к приложению конца
Yii::app()->onEndRequest = function($event)
{
	// выпуск выходного буфера
	return ob_end_flush();
};
$app->run();
//Yii::createWebApplication($config)->run();