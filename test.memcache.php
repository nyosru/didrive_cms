<?php

ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки


if ($_SERVER['HTTP_HOST'] == 'photo.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'a2.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
) {
    date_default_timezone_set("Asia/Omsk");
} else {
    date_default_timezone_set("Asia/Yekaterinburg");
}

define('IN_NYOS_PROJECT', true);

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/all/ajax.start.php';





echo '<a href="/test.memcache.php" >/test.memcache.php</a><hr>';


echo '<form action="" method="post" >'
 . 'удалить все ключи где есть<Br/>'
 . '<textarea name=del ></textarea>'
 . '<input type="submit" name="go" value="go" >'
 . '</form>';

echo '<a href="?delete=all" >удалить всё</a>';


echo '<hr>';

// \f\pa($_POST);

if (isset($_REQUEST['go']) && $_REQUEST['go'] == 'go') {

    $filtr = explode("\n", $_POST['del']);
    // \f\pa($e);

    \f\Cash::deleteKeyPoFilter($filtr);

    echo 'удалили по ключам';
} elseif (isset($_REQUEST['delete']) && $_REQUEST['delete'] == 'all') {

    \f\Cash::allClear();
    echo 'Удалили все';
    die('готово');
}


$e1 = \f\Cash::getVar('keys');
\f\pa($e1, 2);

exit;





//        echo '<br/>tt '.$_SERVER['REQUEST_TIME'];

$new = 1234;
$var = 'wer' . rand(1, 9999999);

$e1 = \f\Cash::getVar('keys');
\f\pa($e1, 2);

$var = 'wer5927055';
$var = 'wer59270551';

$e = \f\Cash::getVar($var);
\f\pa($e);

if (empty($e)) {

    $t = \f\Cash::setVar($var, '121212', 10);
    \f\pa($t);
}

die('--');







//try {
//    $memcache_obj = new \Memcached;
////Соединяемся с нашим сервером
//    $memcache_obj->connect('127.0.0.1', 11211) or die("MemcacheD Could not connect");

$memcache_obj = new \Memcache;
//Соединяемся с нашим сервером
$memcache_obj->connect('127.0.0.1', 11211) or die("Memcache Could not connect");

//Попытаемся получить объект с ключом our_var
//    $var_key = @$memcache_obj->get($cash_var);
//Выведем закэшированные данные
if ($e = $memcache_obj->get('our_var')) {

    echo '<br/>записанные данные';
    echo '<br/>' . $e;
} else {

    echo '<br/>записали новые данные на 20 сек';
    //Если в кэше нет объекта с ключом our_var, создадим его
    //Объект our_var будет храниться 5 секунд и не будет сжат
    $memcache_obj->set('our_var', date('G:i:s'), false, 20);
}

//Закрываем соединение с сервером Memcached
$memcache_obj->close();

//} catch (MemcachedException $ex) {
//
//    $text = '<br/>ошибка<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//            . PHP_EOL . $ex->getTraceAsString()
//            . '</pre>';
//} catch (Exception $ex) {
//
//    $text = '<br/>ошибка<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//            . PHP_EOL . $ex->getTraceAsString()
//            . '</pre>';
//}


