<?php

date_default_timezone_set("Asia/Yekaterinburg");

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// my token
$token = "381744869:AAGADX_OJ_bMq_HUxgnJLhOGd1C66ijvwxU";
$bot = new \TelegramBot\Api\Client($token);

// если бот еще не зарегистрирован - регистрируем
if (!file_exists("registered.trigger")) {

    /**
     * файл registered.trigger будет создаваться после регистрации бота.
     * если этого файла нет существует, значит бот не
     * зарегистрирован в Телеграмм
     */
    
// URl текущей страницы
    
    $page_url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    $result = $bot->setWebhook($page_url);
    if ($result) {
        file_put_contents("registered.trigger", time()); // создаем файл дабы остановить повторные регистрации
    }

}