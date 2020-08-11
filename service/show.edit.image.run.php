<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//echo '<pre>'; print_r( $_REQUEST ); echo '</pre>'; exit;
date_default_timezone_set("Asia/Yekaterinburg");
// header("Cache-control: public");
$status = '';

define('IN_NYOS_PROJECT', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/exception.php';
    
    
    
    
    
try {


if( class_exists('Memcache') ){
    
    $cash_var = 'folder_' . str_replace('www.', '', $_SERVER['HTTP_HOST']);


    //Создаём новый объект. Также можно писать и в процедурном стиле
    $memcache_obj = new Memcache;

    //Соединяемся с нашим сервером
    $memcache_obj->connect('127.0.0.1', 11211) or die('Could not connect');

    //Попытаемся получить объект с ключом our_var
    $now['folder'] = $memcache_obj->get($cash_var);


    if (!empty($now['folder'])) {

        // echo '<br/>'.__LINE__;
        //Если объект закэширован, выводим его значение
        //echo $var_key;

        define('IN_NYOS_PROJECT', true);
        // $now['folder'] = 'kl1903prachka1';
        require_once '../0.all/f/txt.2.php';
    } else {

        // echo '<br/>'.__LINE__;
//        if ($_SERVER['HTTP_HOST'] == 'acms3.ru') {
//            define('IN_NYOS_PROJECT', true);
//            $now['folder'] = 'kl1903prachka1';
//            require_once '../0.all/f/txt.2.php';
//            define('DS', DIRECTORY_SEPARATOR);
//        } else {
        require($_SERVER['DOCUMENT_ROOT'] . '/0.site/0.start.php');
//        }
        //Если в кэше нет объекта с ключом our_var, создадим его
        //Объект our_var будет храниться 5 секунд и не будет сжат
        $memcache_obj->set($cash_var, $now['folder'], false, 3600 * 24 * 25);

        //Выведем закэшированные данные
        // echo $memcache_obj->get($cash_var);
        // $now['folder'] = $memcache_obj->get($cash_var);
    }

//Закрываем соединение с сервером Memcached
    $memcache_obj->close();
// die();

    if (!defined('folder'))
        define('folder', $now['folder']);

    if (!defined('DS'))
        define('DS', DIRECTORY_SEPARATOR);



    require_once $_SERVER['DOCUMENT_ROOT'] . '/0.all/class/exception.php';
//try{
//    throw new \NyosEx('Ошибочка '.date('Y.m.d H:i:s'),rand(1,999));
//} catch ( \NyosEx $e ){
//    echo ' error: ' . $e->getMessage() . ' // ' . $e->getFile() .' / ' . $e->getLine();
//}


    if (!isset($now['folder']{0}) && !is_dir(DirSite))
        throw new \NyosEx('нет папки или проблема с путями', 3);


    $_dir1 = DS . '9.site' . DS . $now['folder'] . DS . 'download'.DS;
    //$_dir1 = DS . '9.site' . DS . $now['folder'] . DS . 'download';
    $_file1 = $_GET['uri'];
    $_file2 = \f\translit($_file1, 'uri2');

    if (!defined('DirSite'))
        define('DirSite', $_SERVER['DOCUMENT_ROOT'] . '/9.site/' . folder);

}
    
    
    
    
    if (!defined('DS'))
        define('DS', DIRECTORY_SEPARATOR);

    if (isset($_REQUEST['uri']) && strpos($_REQUEST['uri'], '.png')) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $_REQUEST['uri'])) {
            header("Content-type: image/png");
            die(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $_REQUEST['uri']));
        }
    }


// если нет картинка
    if (isset($_dir1) && isset($_file1) && !file_exists($_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1) && strpos($_file1, '@2x') !== false)
        $_file1 = strtr($_file1, '@2x', '');

// если нет картинка
    if (!isset($_dir1) || !isset($_file1) || !file_exists($_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1))
        throw new \NyosEx('нет изображения [' . $_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1 . ']', 3);

// если картинка слишком большая
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1) && filesize($_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1) > 1024 * 1024 * 10)
        throw new \NyosEx('изображение слишком большое для обработки [' . $_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1 . '] ' . round(filesize($_SERVER['DOCUMENT_ROOT'] . $_dir1 . DS . $_file1) / 1024 / 1024, 2) . ' Mb', 5);

// папска с созданными файлами
    $cash_dir0 = DirSite . DS . 'download' . DS . 'didra-nyos';

    if (!is_dir($cash_dir0))
        mkdir($cash_dir0, 0755);

    $cash_dir1 = $cash_dir0 . DS .
            ( isset($_GET['type']) ? \f\translit($_GET['type'], 'uri2') : '' )
            . '..'
            . ( isset($_GET['w_min']) ? $_GET['w_min'] : '' )
            . ( isset($_GET['w']) ? $_GET['w'] : '' )
            . '..'
            . ( isset($_GET['h']) ? $_GET['h'] : '' )
    ;

    if (!is_dir($cash_dir1))
        mkdir($cash_dir1, 0755);

    require_once '../0.all/f/file.2.php';

    $file_tmp = $cash_dir1 . \f\translit($_GET['uri'], 'uri2') . '.' . \f\get_file_ext($_GET['uri']);

    require_once($_SERVER['DOCUMENT_ROOT'] . '/0.all/class/nyos_image.php');

// включаем показ инфы 
//    if( strpos( $file_tmp, '595_1_92' ) !== false ){
//        \Nyos\nyos_image::$show = true;
//    }
// если есть ранее созданный, то показываем его
    if (file_exists($file_tmp)) {
        if (isset($_REQUEST['rewrite']) && $_REQUEST['rewrite'] == 1) {
            unlink($file_tmp);
        } else {
//            try {
                \Nyos\nyos_image::showImage($file_tmp);
//            } catch (Exception $ex) {
//                if (strpos($_REQUEST['uri'], '665_1_67') !== false) {
//                    \f\pa($ex);
//                    exit;
//                }
//            }
            exit;
        }
    }

    \Nyos\nyos_image::readImage($_SERVER['DOCUMENT_ROOT'] . $_dir1 . $_file1);

// режем квадрат из изображения с определённой длинной стороны
    if (isset($_GET['type']) && $_GET['type'] == 'min' &&
            isset($_GET['w_min']{0}) && is_numeric($_GET['w_min'])) {

        \Nyos\nyos_image::creatThumbnailProporcii(\Nyos\nyos_image::$image, $_GET['w_min']);
    }

    \Nyos\nyos_image::showImageInMemory($file_tmp);






    if (1 == 2) {

// режем квадрат из изображения с определённой длинной стороны
        if (isset($_GET['type']) && $_GET['type'] == 'p' &&
                isset($_GET['h']{0}) && is_numeric($_GET['h']) &&
                isset($_GET['w']{0}) && is_numeric($_GET['w'])) {
            require 'show.edit.image.p-h-w.php';
            die();
        }

// режем квадрат из изображения с определённой длинной стороны
        elseif (isset($_GET['type']) && $_GET['type'] == 'q' &&
                isset($_GET['h']{0}) && is_numeric($_GET['h']) &&
                isset($_GET['w']{0}) && is_numeric($_GET['w'])) {

//echo '<Br/>'.__FILE__.'-'.__LINE__;
// папска с созданными файлами
            $cash_dir1 = DirSite . 'download/didra-nyos';

            if (!is_dir($cash_dir1))
                mkdir($cash_dir1, 0755);

            $cash_dir = $cash_dir1 . DS . 'q-' . $_GET['w'] . (isset($_GET['h']) ? 'x' . $_GET['h'] : '' );

            if (!is_dir($cash_dir))
                mkdir($cash_dir, 0755);

            $list_dir = explode('/', $_file1);
// echo $_SERVER['DOCUMENT_ROOT'];
// f\pa($list_dir); exit;

            if (1 == 2 && isset($list_dir[0]) && isset($list_dir[1]) && !isset($list_dir[2])) {

                $cash_dir2 = $cash_dir . DS . $list_dir[0];

                if (!is_dir($cash_dir2))
                    mkdir($cash_dir2, 0755);
            }
            elseif (isset($list_dir[0]) && isset($list_dir[1]) && isset($list_dir[2]) && !isset($list_dir[3])) {

                $cash_dir2 = $cash_dir . DS . $list_dir[0];

                if (!is_dir($cash_dir2))
                    mkdir($cash_dir2, 0755);

                $cash_dir2 = $cash_dir . DS . $list_dir[0] . DS . $list_dir[1];

                if (!is_dir($cash_dir2))
                    mkdir($cash_dir2, 0755);
            }

            require_once($_SERVER['DOCUMENT_ROOT'] . '/0.all/class/nyos_image.php');

// die('22222');

            if (file_exists($cash_dir . DS . $_file2) && isset($_REQUEST['rewrite']) && $_REQUEST['rewrite'] == 1)
                unlink($cash_dir . DS . $_file2);

// если есть ранее созданный, то показываем его
            if (file_exists($cash_dir . DS . $_file2))
                Nyos\nyos_image::showImage($cash_dir . DS . $_file2);

// die('11111');
// echo $_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1;

            Nyos\nyos_image::new_image($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);

            Nyos\nyos_image::creatThumbnail($_GET['w'], $_GET['h']);

            Nyos\nyos_image::saveImage($cash_dir . DS . $_file2, false, true);

//$ny_image->creat_thumbnail( $_GET['w'], $_GET['w'] );
//$ny_image->save( $cash_dir . '/', $_file1, 'jpg', false, 90 );

            Nyos\nyos_image::showImage($cash_dir . '/' . $_file2);
        }

// изменение размеров и качества картинки
        elseif (isset($_GET['q']) && is_numeric($_GET['q']) &&
                isset($_GET['w']) && is_numeric($_GET['w'])) {

            if (file_exists(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1))
                die(file_get_contents(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1));

//$expires = 60*60*4;
//header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT');
// создаём исходное изображение на основе исходного файла и опеределяем его размеры
            if (strpos(strtolower($_file1), '.gif') !== false) {
                $src = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            } elseif (strpos(strtolower($_file1), '.png') !== false) {
                $src = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            } else {
                $src = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            }

// размеры реального изображения
            $ww = $w_src = imagesx($src);
            $hh = $h_src = imagesy($src);

// размеры будующего изображения
            $new_w = $_GET['w'];

            $pr1w = round($ww / 100, 2);
            $pr1h = round($hh / 100, 2);

            if ($ww > $hh) {
                $w_dest = $new_w;
                $h_dest = round($pr1h * ($new_w / $pr1w));
            } else {
                $h_dest = round($new_w / ($ww / 100) * $pr1h);
                $w_dest = round($new_w / ($ww / 100) * $pr1w);
            }

// создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest); // важно именно truecolor!, иначе будем иметь 8-битный результат

            imagecopyresized($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

// уничтожаем оригинал в памяти
            imagedestroy($src);

            if (!is_dir(DirSite . DS . 'download/didra-nyos'))
                mkdir(DirSite . DS . 'download/didra-nyos', 0755);

            if (!is_dir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w']))
                mkdir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'], 0755);

//$_file1 = '231/232/333/444/123.jpg';
            $ttr = explode('/', $_file1);
//echo '<pre>'; print_r($ttr); echo'</pre>';
            $ur = sizeof($ttr);

// выстраиваем дерево каталогов
            if ($ur > 1) {
                $ur_dop = '';
                foreach ($ttr as $k => $v) {
                    if ($k <= $ur - 2) {
                        if (!is_dir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . ( isset($ur_dop{1}) ? $ur_dop : '' ) . '/' . $v))
                            mkdir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . ( isset($ur_dop{1}) ? $ur_dop : '' ) . '/' . $v, 0755);

//echo $_SERVER['DOCUMENT_ROOT'].'/9.site/'.$domen_info['login'].'/'.$domen_info['folder'].'/download/didra-nyos/'.$_GET['q'].'-'.$_GET['w'].'/'.( isset($ur_dop{1}) ? $ur_dop : '' ).'/'.$v.'<br/>';
                        $ur_dop .= '/' . $v;
                    }
                }
            }

// вывод картинки и очистка памяти

            if (strpos(strtolower($_file1), '.gif') !== false) {
                imagegif($dest, DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1, $_GET['q']);
//imagegif($dest,'',$_GET['q']);
            }
//            elseif( strpos(strtolower($_file1),'.png') !== false )
//            {
//            imagejpeg($dest,
//                DirSite.DS.'download/didra-nyos/'.$_GET['q'].'-'.$_GET['w'].'/'.$_file1,
//                $_GET['q']);
//            }
            else {
                imagejpeg($dest, DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1, $_GET['q']);
            }

            imagedestroy($dest);

            if (strpos(strtolower($_file1), '.gif') !== false) {
                header("Content-type: image/gif");
            }
//        elseif( strpos(strtolower($_file1),'.png') !== false )
//        {
//        header("Content-type: image/gif");
//        //header("Content-type: image/png");
//        }
            else {
                header("Content-type: image/jpeg");
            }

            header("Cache-Control: public");
            header("Pragma: cache");

            $expires = 60 * 60 * 4;
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT');


            die(file_get_contents(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1));
//exit();
        }

// что то не сходится, просто показываем картинку
        else {

            if (strpos(strtolower($_file1), '.gif') !== false) {
                header("Content-type: image/gif");
            }
//        elseif( strpos(strtolower($_file1),'.png') !== false )
//        {
//        header("Content-type: image/gif");
//        //header("Content-type: image/png");
//        }
            else {
                header("Content-type: image/jpeg");
            }

            header("Cache-Control: public");
            header("Pragma: cache");

            $expires = 60 * 60 * 4;
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT');


//	file_load( './'.$_dir1.$_file1, $search_ext );

            header("Content-Length: " . filesize('./' . $_dir1 . $_file1));
//header("Location: http://".$_SERVER['HTTP_HOST']."/uralweb.redir/1".$DiUser."/2".$DiFold."--".$_file1);
//echo './'.$_dir1.$_file1; exit();

            readfile($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
//header("Location: http://".$_SERVER['HTTP_HOST']."/look/1".$domen_info['login']."/2".$domen_info['folder']."/3".$_file1);
//header("Content-type: ".$search_ext);
//echo readfile($file_in);
//$rf = filez_get_contents($file_in); echo $rf;
            exit();
        }
    }
}
// если нет картинки по ссылке или какая то ошибка
catch (NyosEx $e) {

//    if (strpos($_REQUEST['uri'], '665_1_67') !== false) {
//        echo '<h3>' . $e->getMessage() . ' <sup>code:' . $e->getCode() . ' #' . $e->getLine() . '</sup></h3>';
//        echo '<pre>';
//        var_dump($e);
//        echo '</pre>';
//        die();
//    }


    header('Content-Type: image/jpeg');
    die(file_get_contents($_SERVER['DOCUMENT_ROOT'] . DS . 'image' . DS . 'poloski.jpg'));
} catch (Exception $e) {

//    if (strpos($_REQUEST['uri'], '665_1_67') !== false) {
//        echo '<h3>' . $e->getMessage() . ' <sup>code:' . $e->getCode() . ' #' . $e->getLine() . '</sup></h3>';
//        echo '<pre>';
//        var_dump($e);
//        echo '</pre>';
//        die();
//    }


    if (2 == 1 || isset($_GET['inform'])) {
        header('Content-Type: text/html');
        echo '<h3>' . $e->getMessage() . ' <sup>code:' . $e->getCode() . ' #' . $e->getLine() . '</sup></h3>';
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
        die();
    } else {
        header('Content-Type: image/jpeg');
        die(file_get_contents($_SERVER['DOCUMENT_ROOT'] . DS . 'image' . DS . 'poloski.jpg'));
    }
}
