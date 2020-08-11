<?php

if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
    $sm = 0;
}

if ($_SERVER['HTTP_HOST'] == 'photo.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.dev.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'a2.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
) {
    date_default_timezone_set("Asia/Omsk");
} else {
    date_default_timezone_set("Asia/Yekaterinburg");
}

if (
    strpos($_SERVER['HTTP_HOST'], 'dev.') !== false ||
    $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' ||
    $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

ob_start('ob_gzhandler');

try {


    define('IN_NYOS_PROJECT', TRUE);
    define('DS', DIRECTORY_SEPARATOR);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
        require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    /**
     * корень сервера /all/
     */
    define('DirAll', $_SERVER['DOCUMENT_ROOT'] . DS . 'all' . DS);

// массив с переменными
    $vv = array(
        'sdd' => '/didrive/design/',
        'body_end' => '',
        'folder' => '',
        'warn' => '',
        'host' => $_SERVER['HTTP_HOST'],
//        'get' => $_GET,
//        'server' => $_SERVER,
//        'post' => $_POST,
        'rand' => rand(1000, 9999)
    );

    // \f\timer_start(78);
    
    require_once($_SERVER['DOCUMENT_ROOT'] . '/all/0.start.php');
    
    // \f\pa(\f\timer_stop(78));
    

    $vv['db'] = $db;

    if (file_exists(DR . dir_site . 'config.php'))
        require( DR . dir_site . 'config.php');

    if (isset($_SESSION['now_user_di']['soc_web_id']{1}) && !isset($_SESSION['now_user_di']['uid'])) {
        $_SESSION['now_user_di']['uid'] = $_SESSION['now_user_di']['soc_web_id'];
    }

    \Nyos\Nyos::getFolder();

    $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT']);

// инициализируем Twig
    $twig = new Twig_Environment($loader, array(
        'cache' => $_SERVER['DOCUMENT_ROOT'] . '/templates_c',
        //'cache' => false,
        'auto_reload' => true
//        ,
//        'debug' => true
    ));


// только для отладки
//    $twig->addExtension(new \Twig\Extension\DebugExtension());

    /**
     * если ещё не вошли
     */
    if (!isset($_SESSION['now_user_di']['id'])) {

        // если есть картинка для входа ... показываем её
        if( file_exists(DR.dir_site_sd.'didrive_enter_img.jpg') )
        $vv['didrive_enter_img'] = dir_site_sd.'didrive_enter_img.jpg';

        $vv['id_app'] = 7171647; //Айди приложения
        $vv['url_script'] = 'https://' . $_SERVER['HTTP_HOST'] . '/i.didrive.php'; //ссылка на скрипт auth_vk.php
        $vv['vk_api_url'] = '<a href="https://oauth.vk.com/authorize?client_id=' . $vv['id_app'] . '&redirect_uri=' . $vv['url_script'] . '&response_type=code" >Войти через ВК</a></p>';

// после клика по ссылке "войти через вк" отправили запрос и нам пришёл код .. из которого надо достать данные (используем id)

        if (!empty($_GET['code'])) {

            $id_app = $vv['id_app']; //Айди приложения
            $secret_app = 'srJxX0eTaPnGIEnTcCfJ'; // Защищённый ключ. Можно узнать там же где и айди
            $url_script = $vv['url_script']; //ссылка на этот скрипт
            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=' . $id_app . '&client_secret=' . $secret_app . '&code=' . $_GET['code'] . '&redirect_uri=' . $url_script), true);
            $fields = 'first_name,last_name,photo_200_orig';

            // $fields = 'photo_id, verified, sex, bdate, city, country, home_town, has_photo, photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, online, domain, has_mobile, contacts, site, education, universities, schools, status, last_seen, followers_count, common_count, occupation, nickname, relatives, relation, personal, connections, exports, activities, interests, music, movies, tv, books, games, about, quotes, can_post, can_see_all_posts, can_see_audio, can_write_private_message, can_send_friend_request, is_favorite, is_hidden_from_feed, timezone, screen_name, maiden_name, crop_photo, is_friend, friend_status, career, military, blacklisted, blacklisted_by_me, can_be_invited_group';
            // $fields = 'photo_id, sex, bdate, city, country, home_town, has_photo, photo_50, photo_100, photo_200, contacts, status, followers_count, common_count, occupation, nickname, timezone';

            $uinf = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids=' . $token['user_id'] . '&fields=' . $fields . '&access_token=' . $token['access_token'] . '&v=5.80'), true);

            // \f\pa($uinf);
//            $_SESSION['name'] = $uinf['response'][0]['first_name'];
//            $_SESSION['name_family'] = $uinf['response'][0]['last_name'];
//            $_SESSION['uid'] = $token['user_id'];
//            $_SESSION['access_token'] = $token['access_token'];

            \Nyos\mod\Lk::$type = 'now_user_di';

            if (!empty($uinf['response'][0]['id'])) {
                $_SESSION[\Nyos\mod\Lk::$type] = \Nyos\Mod\Lk::enter($db, $uinf['response'][0]['id']);

                \nyos\Msg::sendTelegramm('Вход в управление с ВК' . PHP_EOL
                        . implode('+', $uinf['response'][0])
                        , null, 2);

                // если это я
                if ($uinf['response'][0]['id'] == '5903492')
                    $_SESSION[\Nyos\mod\Lk::$type]['access'] = 'admin';
            }

            // die();
            header("Location: /i.didrive.php");
        }


// авторизация через вк
        if (!empty($_REQUEST['uid']) && !empty($_REQUEST['hash'])) {

            \f\pa($_REQUEST, '', '', 'request');

// проверка хеша при авторизации в вк
            if (1 == 1) {
                $check_hash = false;
                // приложуха adommik
                $ap_id = 7171647;
                $secret_key = 'srJxX0eTaPnGIEnTcCfJ';
                if ($_REQUEST['hash'] == md5(( $ap_id ?? '' ) . $_REQUEST['uid'] . ( $secret_key ?? '' )))
                    $check_hash = true;
            }

            // если хеш норм то проходим авторизацию
            if (isset($check_hash) && $check_hash === true) {

                // \f\pa($_REQUEST);
                // \f\pa($_SESSION);

                if (!class_exists('Nyos\\mod\\Lk')) {
                    //throw new \NyosEx('Не обнаружен класс lk');
                    require_once DR . '/vendor/didrive_mod/lk/class.php';
                }

                \Nyos\mod\Lk::$type = 'now_user_di';
                $_SESSION[\Nyos\mod\Lk::$type] = \Nyos\Mod\Lk::enter($db, $_REQUEST['uid']);

                // если это я
                if (!empty($_REQUEST['uid']) && $_REQUEST['uid'] == '5903492')
                    $_SESSION[\Nyos\mod\Lk::$type]['access'] = 'admin';

//// если это я
//            if (
//// vk
//                    $_SESSION['now_user_di']['soc_web_id'] == '5903492' || $_SESSION['now_user_di']['uid'] == '5903492'
//// facebook
//                    || $_SESSION['now_user_di']['soc_web_id'] == '10208107614107713'
//            )
//                $_SESSION['now_user_di']['access'] = 'admin';

                if (isset($_SESSION[\Nyos\mod\Lk::$type]['new_user_add']) && $_SESSION[\Nyos\mod\Lk::$type]['new_user_add'] === true) {

                    $dd = '';

                    $show_key = ['id', 'avatar'];

                    foreach ($_SESSION[\Nyos\mod\Lk::$type] as $k => $v) {
                        if (in_array($k, $show_key))
                            $dd .= PHP_EOL . $k . ': ' . $v;
                    }

                    \nyos\Msg::sendTelegramm('Вход в управление с ВК (первый вход)' . PHP_EOL
                            . ( $_SESSION['now_user_di']['name'] ?? 'x' ) . ' ' . ( $_SESSION['now_user_di']['family'] ?? 'x' )
                            . ( $dd ?? '' )
                            , null, 2);
                } else {

                    $show_key = ['id', 'access', 'avatar'];

                    foreach ($_SESSION[\Nyos\mod\Lk::$type] as $k => $v) {
                        if (in_array($k, $show_key))
                            $dd .= PHP_EOL . $k . ': ' . $v;
                    }

                    \nyos\Msg::sendTelegramm('Вход в управление с ВК ' . PHP_EOL
                            . $_SESSION['now_user_di']['name'] . ' ' . $_SESSION['now_user_di']['family']
                            . ( $dd ?? '' )
                            , null, 2);
                }

                \f\redirect('/', 'i.didrive.php');
                exit;
            }
        }

// проверка в БД (ввели логин пароль)
        if (isset($_POST['login2']) && isset($_POST['pass2'])) {

            echo '<br/>' . __FILE__ . ' ' . __LINE__;
            \Nyos\mod\Lk::$type = 'now_user_di';

            if (!class_exists('Nyos\mod\Lk'))
                require_once DR . '/vendor/didrive_mod/lk/class.php'; // $_SERVER['DOCUMENT_ROOT'] . DS . 'module' . DS . 'lk' . DS . 'class.php';

            try {

                $_SESSION[\Nyos\mod\Lk::$type] = \Nyos\mod\Lk::getUser($db, null, $_POST['login2'], $_POST['pass2'], ( isset($vv['folder']{3}) ? $vv['folder'] . '_di' : null));

                $e = 'По логину: ' . $_POST['login2'];

                \nyos\Msg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, null, 2);

                if (isset($vv['admin_auerific'])) {
                    foreach ($vv['admin_auerific'] as $k => $v) {
                        \nyos\Msg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, $v);
                    }
                }

                \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => 'Вход произведён'));
            } catch (\Exception $ex) {

                if (strpos($ex->getMessage(), 'no such table: gm_user')) {
// создаём таблицу gm_user
                    \Nyos\mod\Lk::creatTable($db);
                    \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => 'Таблица данных создана, просим войти повторно'));
                }

                \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage()));
            }
        }

// проверка входа через соц. сервис
        elseif (isset($_POST['token']{1})) {

// \f\pa($_POST);
// require_once $_SERVER['DOCUMENT_ROOT'] . DS . 'module' . DS . 'lk' . DS . 'class.php';


            if (!class_exists('Nyos\\mod\\Lk')) {

                //throw new \NyosEx('Не обнаружен класс lk');
                require_once DR . '/vendor/didrive_mod/lk/class.php';
            }

            \Nyos\mod\Lk::$type = 'now_user_di';

            try {

                $_SESSION[\Nyos\mod\Lk::$type] = \Nyos\Mod\Lk::enterSoc($db, ( isset($vv['folder']{0}) ? $vv['folder'] : null), $_POST['token'], 'didrive');

// если это я
                if (
// vk
                        $_SESSION['now_user_di']['soc_web_id'] == '5903492' || $_SESSION['now_user_di']['uid'] == '5903492'
// facebook
                        || $_SESSION['now_user_di']['soc_web_id'] == '10208107614107713'
                )
                    $_SESSION['now_user_di']['access'] = 'admin';

                if (class_exists('\nyos\Msg')) {
                    $e = '';

                    foreach ($_SESSION[\Nyos\mod\Lk::$type] as $k => $v) {
                        if (isset($v{0}))
                            $e .= $k . ': ' . $v . PHP_EOL;
                    }

                    \nyos\Msg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, null, 1);

// \Nyos\NyosMsg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e,null,1);

                    if (isset($vv['admin_auerific'])) {
                        foreach ($vv['admin_auerific'] as $k => $v) {
                            \nyos\Msg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, $v);
//\Nyos\NyosMsg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, $k );
                        }
                    }
                }

                \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => 'Вход произведён'));
            } catch (\NyosEx $ex) {

//            echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//            . PHP_EOL . $ex->getTraceAsString()
//            ;
//            die(__LINE__);

                \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => 'НЕописуемая ситуация ' . $ex->getMessage()));
            } catch (\Error $ex) {

//            echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//            . PHP_EOL . $ex->getTraceAsString()
//            ;
//            die(__LINE__);

                \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => 'НЕописуемая ситуация ' . $ex->getMessage()));
            } catch (\Exception $ex) {

//            echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//            . PHP_EOL . $ex->getTraceAsString()
//            . '</pre>';

                if (strpos($ex->getMessage(), 'no such table: gm_user')) {
// создаём таблицу gm_user
                    \Nyos\mod\Lk::creatTable($db);
                    \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => 'Таблица данных создана, просим войти повторно'));
                }

                \f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage()));
            }

//die('11111');
//exit;
        }

        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('server', $_SERVER);
        $twig->addGlobal('post', $_POST);
        $twig->addGlobal('get', $_GET);

// $ttwig = $twig->loadTemplate('didrive/tpl/enter.htm');
        $ttwig = $twig->loadTemplate(\f\like_tpl('enter', '/didrive/tpl/', dir_site_tpldidr, DR));
        echo $ttwig->render($vv);

// echo '<br/>' . __FILE__ . ' [' . __LINE__ . ']';

        $r = ob_get_contents();
        ob_end_clean();


//        if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//            die('<br/>' . __FILE__ . ' ' . __LINE__);
//        }


        die($r);
//die($r);
    }

// если зашли
// elseif (isset($_SESSION['now_user_di']['id']) && $_SESSION['now_user_di']['id'] > 0) {
    else {

        try {

            require_once 'i.didrive.enter.php';


//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                //echo '<br/>timer '.\f\timer::stop('str', 99);
//
//                \f\pa($_SESSION);
//
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }
        } catch (\NyosEx $ex) {
//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
            $vv['warn'] = 'Произошла ошибка <pre> '
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString() . '</pre>';
        } catch (\PDOException $ex) {

//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
            $vv['warn'] = 'Произошла ошибка PDO <pre> '
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString() . '</pre>';

            if (strpos($ex->getMessage(), 'no such table: gm_user_di_mod') !== false) {
                $vv['warn'] .= PHP_EOL . 'создаём таблицу gm_user_di_mod';
                \Nyos\Mod\lk::creatTable($db, 'gm_user_di_mod');
            }
        } catch (\Exception $ex) {
//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
            $vv['warn'] = 'Произошла ошибка <pre> '
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString() . '</pre>';
        } catch (\ErrorException $ex) {
//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
            $vv['warn'] = 'Произошла ошибка <pre> '
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString() . '</pre>';
        } catch (\Error $ex) {
//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
            $vv['warn'] = 'Произошла ошибка <pre> '
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString() . '</pre>';
        }
    }

    
    
    
    if (file_exists(DR . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js')) {
        // $vv['in_body_end'][] = '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>';
        if( empty( $vv['in_body_end'] ) ){
        $vv['in_body_end'][] = '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>';
        }else{
        array_unshift( $vv['in_body_end'], '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>');
        }
    }

    if (file_exists(DR . DS . 'didrive' . DS . 'js.js')) {
        // $vv['in_body_end'][] = '<script src="/didrive/js.js"></script>';
        array_unshift($vv['in_body_end'], '<script src="/didrive/js.js"></script>');
    }

    //$vv['in_body_end'][] = '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>';
    // \f\pa( $vv['in_body_end'] );

    /**
     * обработка шаблона и вывод
     */
//foreach ($vv as $k => $v) {
//    $smarty->assign($k, $v);
//}
// $t = \f\like_tpl('didrive', $_SERVER['DOCUMENT_ROOT'] . '/didrive/tpl/', $_SERVER['DOCUMENT_ROOT'] . $vv['sdd']);
// $smarty->display($t);
//if (strpos($_SERVER['HTTP_HOST'], 'acms') || strpos($_SERVER['HTTP_HOST'], '.a2') || strpos($_SERVER['HTTP_HOST'], '.aa')) {
//    require( $_SERVER['DOCUMENT_ROOT'] . '/0.all/inf.post.php' );
//}

    if (1 == 1 && isset($vv['ckeditor_in']) && sizeof($vv['ckeditor_in']) > 0) {

// \f\pa($vv['ckeditor_in']);
        $vv['in_body_end']['/js/ckeditor.4.5.11/ckeditor.js'] = '<script type="text/javascript" charset="utf-8" src="/js/ckeditor.4.5.11/ckeditor.js"></script>';

        foreach ($vv['ckeditor_in'] as $k => $v) {
            if (isset($v['type']) && $v['type'] == 'mini') {
                $vv['in_body_end'][] = '<script  type="text/javascript" charset="utf-8"  >'
                        . ' CKEDITOR.replace(\'' . addslashes($k) . '\', { toolbar: [ '
                        . ' { name: "clipboard", groups: [ "clipboard", "undo" ], items: [ "Cut", "Copy", "PasteText", "-", "Undo", "Redo" ] }, '
                        . ' { name: "colors", items: [ "TextColor", "BGColor" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "-", "RemoveFormat" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "align" ], items: [ "NumberedList", "BulletedList" ] } '
                        . ' ] } ); </script>';
            } elseif (isset($v['type']) && $v['type'] == 'mini.img') {
                $vv['in_body_end'][] = '<script  type="text/javascript" charset="utf-8"  >'
                        . ' CKEDITOR.replace(\'' . addslashes($k) . '\', { toolbar: [ '
                        . ' { name: "clipboard", groups: [ "clipboard", "undo" ], items: [ "Cut", "Copy", "PasteText", "-", "Undo", "Redo" ] }, '
                        . ' { name: "colors", items: [ "TextColor", "BGColor" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "-", "RemoveFormat" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "align" ], items: [ "NumberedList", "BulletedList" ] }, '
                        . ' { name: "insert", items: [ "Image", "Flash", "Table", "HorizontalRule", "Smiley", "SpecialChar", "PageBreak", "Iframe" ] } '
                        . ' ] } ); </script>';
// } elseif (isset($v['type']) && $v['type'] == 'full') {
            } else {
                $vv['in_body_end'][] = '<script  type="text/javascript" charset="utf-8"  >'
                        . ' CKEDITOR.replace(\'' . addslashes($k) . '\', { toolbar: [ '
                        . ' { name: "document", groups: ["mode", "document", "doctools"], items: [\'Source\', \'Maximize\', \'ShowBlocks\', \'Templates\'] }, '
                        . ' { name: "clipboard", groups: ["clipboard", "undo"], items: [\'Cut\', \'Copy\', \'Paste\', \'PasteText\', \'PasteFromWord\', \'-\', \'Undo\', \'Redo\'] }, '
                        . ' { name: "clipboard", groups: [ "clipboard", "undo" ], items: [ "Cut", "Copy", "PasteText", "-", "Undo", "Redo" ] }, '
                        . ' { name: \'editing\', groups: [\'find\', \'selection\', \'spellchecker\'], items: [\'Find\', \'Replace\', \'-\', \'SelectAll\', \'-\', \'Scayt\'] }, '
                        . ' { name: "colors", items: [ "TextColor", "BGColor" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "-", "RemoveFormat" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "-", "RemoveFormat" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "blocks", "align", "bidi" ], items: [ "NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote", "CreateDiv", "-", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "align" ], items: [ "NumberedList", "BulletedList" ] }, '
                        . ' { name: "links", items: [ "Link", "Unlink" ] }, '
                        . ' { name: "insert", items: [ "Image", "Flash", "Table", "HorizontalRule", "Smiley", "SpecialChar", "PageBreak", "Iframe" ] }, '
                        . ' { name: "styles", items: [ "Styles", "Format", "Font", "FontSize" ] } '
                        . ' ] } ); </script>';
            }
        }
    }

// $ttwig = $twig->loadTemplate( 'module/' . $vv['level'] . '/tpl/page.txt.data.htm');
// $ttwig = $twig->loadTemplate( 'module/' . $vv['level'] . '/tpl/sqlmod.item.htm');
//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }




    require DR . '/all/twig.function.php';

    $vv['a_menu'] = \Nyos\Nyos::$a_menu;
    //\f\pa($vv['a_menu']);


    $twig->addGlobal('session', $_SESSION);
    $twig->addGlobal('server', $_SERVER);
    $twig->addGlobal('post', $_POST);
    $twig->addGlobal('get', $_GET);


//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                // die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }

    $ttwig = $twig->loadTemplate($tpl_print_end ?? 'didrive/tpl/didrive.htm');


    // \f\timer_start(331);
    echo $ttwig->render($vv);
    // \f\pa( 'печать в твиг '.\f\timer_stop(331));
//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }
//echo '<br/>'.__FILE__.' ['.__LINE__.']';

    $r = ob_get_contents();
    ob_end_clean();


    // \f\timer_start(781);



//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }

    $r22 = $r23 = array();

    // \f\pa($vv['in_body_end'],'','','in_body_end');
//                $r22 = $r23 = array();

    $body_end_str = $body_start_str = '';

    if (isset($vv['dihead']{3})) {
        $body_start_str .= $vv['dihead'];
    }

    if (isset($body_start_str{1})) {
        $r22[] = '</head>';
        $r23[] = $body_start_str . '</head>';
    }



    if (isset($vv['in_body_end']) && sizeof($vv['in_body_end']) > 0) {

        $t = '';

        foreach ($vv['in_body_end'] as $k => $v) {
            $t .= $v;
        }

        $r22[] = '</body>';
        $r23[] = $t . '</body>';
    }

    $startMemory = 0;
    $startMemory = memory_get_usage();
    $r22[] = ' =memory_usage= ';
    $r23[] = round($startMemory / 1024 / 1024, 2);
// echo '<br/>xxx'.__LINE__.' - '.round($startMemory/1024/1024,2);
    // \f\timer_start(33);

    if (!empty($r22))
        $r = str_replace($r22, $r23, $r);

    // \f\pa( 'замена в body '.\f\timer_stop(33));

    // \f\pa(\f\timer_stop(781));

    
    die($r);

//    require_once( $_SERVER['DOCUMENT_ROOT'] . '/all/inf.post.php' );
//    die($r);
//    exit;
} catch (\NyosEx $ex) {

    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/body_error.htm')));
} catch (\EngineException $ex) {

    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';
    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';
// echo __FILE__;
    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/body_error.htm')));
} catch (\Exception $ex) {

    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';
    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';
// echo __FILE__;
    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/body_error.htm')));
} catch (\PDOException $ex) {

    
    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';
    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';
// echo __FILE__;
    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/body_error.htm')));
} catch (\Throwable $ex) {

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/template/body_error.htm')));
}