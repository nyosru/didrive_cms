<?php

$text = '';

if (isset($_POST['go']) && (
        ( isset($_POST['a']) && $_POST['a'] == 123 ) ||
        ( isset($_POST['creat']) && $_POST['creat'] == 123 )
        ) && isset($_POST['folder']{2})) {

    if (!extension_loaded('PDO')) {
        throw new \Exception(' pdo bd не доступен ');
    }

    function copyDirectory($from_path, $to_path) {

        if (!is_dir($from_path))
            return FALSE;

        if (!is_dir($to_path) && is_dir($from_path))
            mkdir($to_path, 0755);

        $open = opendir($from_path);

        while ($file = readdir($open)) {

            if ($file != '.' && $file != '..' && is_dir($from_path . '/' . $file)) {
                if (!is_dir($to_path . '/' . $file))
                    mkdir($to_path . '/' . $file, 0755);

                copyDirectory($from_path . '/' . $file, $to_path . '/' . $file);
            }
            elseif ($file != '.' && $file != '..' && is_file($from_path . '/' . $file)) {
                copy($from_path . '/' . $file, $to_path . '/' . $file);
            }
        }

        closedir($open);

        return true;
    }

    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/sites')) {
        $SqlLiteFile = $_SERVER['DOCUMENT_ROOT'] . '/sites/db.sqllite.sl3';
    } elseif (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site')) {
        $SqlLiteFile = $_SERVER['DOCUMENT_ROOT'] . '/site/db.sqllite.sl3';
    } else {
        throw new \Exception(' не определена папка важная ');
    }

//echo $SqlLiteFile;

    $db = new \PDO('sqlite:' . $SqlLiteFile, null, null, array(
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ));
//$db->exec('PRAGMA journal_mode=WAL;');

    $ff = $db->prepare('SELECT folder FROM `2domain` WHERE domain = :domain LIMIT 1;');
    $ff->execute(array(':domain' => str_replace('www.', '', mb_strtolower($_SERVER['HTTP_HOST']))));

    if ($f = $ff->fetch()) {

        if ($f['folder'] == '') {

            if (isset($_POST['a']) && $_POST['a'] == 123) {


                $ff = $db->prepare('UPDATE `2domain` SET `folder` = :folder WHERE `domain` = :domain ;');
                $ff->execute(array(':folder' => $_POST['folder'], ':domain' => str_replace('www.', '', mb_strtolower($_SERVER['HTTP_HOST']))));
            } elseif (isset($_POST['creat']) && $_POST['creat'] == 123 && isset($_POST['folder']{2}) && isset($_POST['tpl']{2})
            ) {

                $origin = DR . '/vendor/didrive/tpls/tpls/' . $_POST['tpl'] . '/';
                $to_folder = DR . '/sites/' . $_POST['folder'] . '/';

                if (is_dir($origin) && !is_dir($to_folder)) {

                    $r = copyDirectory($origin, $to_folder);

                    $ff = $db->prepare('UPDATE `2domain` SET `folder` = :folder WHERE `domain` = :domain ;');
                    $ff->execute(array(':folder' => $_POST['folder'], ':domain' => str_replace('www.', '', mb_strtolower($_SERVER['HTTP_HOST']))));
                }
            }

            \f\redirect();
        }
    } else {

        $ff = $db->prepare('INSERT INTO  `2domain` (domain) VALUES (?)');
        $ff->execute([$domain]);
    }
    unset($ff);
}







// throw new \Exception('свежий домен без папки', 777);

$text .= '<center>';

$text .= '<form style="padding: 1em 0;" action="" method="POST" >
            <input class="form-control" style="width: 25%; display: inline-block;" type="text" name="a" value="" >
            <select class="form-control" style="width: 25%; display: inline-block;" name="folder" >
                <option> - ? - </option>';

$dirs = scandir($_SERVER['DOCUMENT_ROOT'] . '/sites/');

foreach ($dirs as $k => $v) {

    if (isset($v{2}) && is_dir($_SERVER['DOCUMENT_ROOT'] . '/sites/' . $v))
        $text .= '<option value="' . $v . '" >' . $v . '</option>';
}

$text .= '</select>';

$text .= '<input type="submit" name="go" value="go" class="btn btn-success" />
         </form>';

// throw new \Exception('свежий домен без папки', 777);

$text .= '<form style="padding: 1em 0;" action="" method="POST" >
            <input class="form-control" style="width: 25%; display: inline-block;" type="text" name="creat" value="" >
            <input class="form-control" style="width: 25%; display: inline-block;" type="text" name="folder" value="" >';

if (is_dir(DR . '/vendor/didrive/tpls/')) {

    $text .= '<select class="form-control" style="width: 25%; display: inline-block;" name="tpl" >
                <option> - ? - </option>';

    $dirs = scandir(DR . '/vendor/didrive/tpls/tpls/');

    foreach ($dirs as $k => $v) {

        if (isset($v{2}) && is_dir(DR . '/vendor/didrive/tpls/tpls/' . $v))
            $text .= '<option value="' . $v . '" >' . $v . '</option>';
    }

    $text .= '</select>';
}

$text .= '<input type="submit" name="go" value="go" class="btn btn-success" />'
        . '</form>'
        . '</center>';


/**
 * раз в 24 часа присылаем мсг на теелегу о сайте без папки
 */
$file_cash = $_SERVER['DOCUMENT_ROOT'] . '/sites/site_no_dir.' . \f\translit($_SERVER['HTTP_HOST'], 'uri2') . '.cash24';

if (!file_exists($file_cash) || ( file_exists($file_cash) && filectime($file_cash) < $_SERVER['REQUEST_TIME'] - (3600 * 24) )) {

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm('обращение к домену без сайта', null, 1);

    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/sites/site_no_dir.' . \f\translit($_SERVER['HTTP_HOST'], 'uri2') . '.cash24', '1');
}

die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/body_no_site.htm')));
