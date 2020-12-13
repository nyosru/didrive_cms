<?php

// смотрим какие есть переменные все
// echo '<pre>';    print_r($GLOBALS);    echo '</pre>';
// wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
//echo 'wefwef';

/*
  было
  mbstring.func_overload = 2
  стало
  mbstring.func_overload = 0
  было
  mbstring.internal_encoding = -пусто-
  стало
  mbstring.internal_encoding = UTF-8
 */

if ($_SERVER['HTTP_HOST'] == 'photo.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'a2.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.dev.uralweb.info'
) {
    date_default_timezone_set("Asia/Omsk");
} else {
    date_default_timezone_set("Asia/Yekaterinburg");
}

if (1 == 1 || $_SERVER['HTTP_HOST'] == 'adomik.dev.uralweb.info' || $_SERVER['HTTP_HOST'] == 'a2.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
) {

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// if( $_SERVER['HTTP_HOST'] == '46.254.18.85' || $_SERVER['HTTP_HOST'] == '37.143.15.250' ){ die(); }

/**
 * обработка различных get
 */
if (isset($_REQUEST['info2']{2})) {
    phpinfo();
    die();
}

// переадресация внутри по ссылке goto
// if (isset($_GET['goto']) && isset($amnu[$_GET['goto']])) {
elseif (isset($_GET['goto'])) {
    $get1 = $_GET;
    $get1['level'] = $_GET['goto'];
    unset($get1['goto']);
    header('Location: /index.php?' . http_build_query($get1));
    die();
}

try {

    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/index_index.php'))
        throw new \Exception('нет файла супер старта');

    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/index_index.php';

// зе енд товарисч
} catch (\PDOException $ex) {

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $_SERVER['REQUEST_URI']
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
} catch (\EngineException $ex) {

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
} catch (\Exception $ex) {

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
} catch (\Throwable $ex) {

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
}
