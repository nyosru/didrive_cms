<?php

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

if ( 1 == 1 || $_SERVER['HTTP_HOST'] == 'adomik.dev.uralweb.info' || $_SERVER['HTTP_HOST'] == 'a2.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
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


//die('123');

ob_start('ob_gzhandler');

try {


    if (!isset($_GET['level']))
        $_GET['level'] = '000.index';

    if (!defined('IN_NYOS_PROJECT'))
        define('IN_NYOS_PROJECT', TRUE);

    if (!defined('DS'))
        define('DS', DIRECTORY_SEPARATOR);

// если нет базовой папки для сайтов то создаём её
    if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/site') && !is_dir($_SERVER['DOCUMENT_ROOT'] . '/sites')) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . '/sites', 0755);
    }

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
        require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/all/exception.nyosex.php'))
        require $_SERVER['DOCUMENT_ROOT'] . '/all/exception.nyosex.php';

    /**
     * корень сервера /all/
     */
    define('DirAll', $_SERVER['DOCUMENT_ROOT'] . DS . 'all' . DS);
    $status = '';

//if( $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' ){
//    die('<br/>'.__FILE__.' '.__LINE__);
//}
//    if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info') {
//        die('<br/>' . __FILE__ . ' ' . __LINE__);
//    }

    try {

        if (1 == 1) {

// массив с переменными
            $vv = array(
                'folder' => '',
                'dihead' => '',
//            'get' => $_GET,
//            'post' => $_POST,
//            'server' => $_SERVER,
                'warn' => ''
            );

            // \f\pa($_SESSION);
            // if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/all/0.start.php'))
            require_once($_SERVER['DOCUMENT_ROOT'] . '/all/0.start.php');

            //echo '<Br/>'.$vv['folder'];
            //\Nyos\Nyos::getFolder();
//if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info') {
//        die('<br/>' . __FILE__ . ' ' . __LINE__);
//    }

            $vv['session'] = $_SESSION;
            $vv['db'] = $db;

            // \f\pa($_SESSION);
// require_once $_SERVER['DOCUMENT_ROOT'] . '/all/sql.start.php';
//\f\pa($vv['folder']);

            if (empty($vv['folder'])) {

                require DR . '/index.site_no_folder.php';
                die('#' . __LINE__);
            }

//if( $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info' ){
//    die('<br/>'.__FILE__.' '.__LINE__);
//}
            // \Nyos\Nyos::defineVars();
// если есть папка с сайтом
            // echo DR ;
            $loader = new Twig_Loader_Filesystem(DR);

// инициализируем Twig
            $twig = new Twig_Environment($loader, array(
                'cache' => $_SERVER['DOCUMENT_ROOT'] . '/templates_c',
                'auto_reload' => true
                    //'cache' => false,
                    // 'debug' => true
            ));

            $vv['dir_site_tpl'] = dir_site_tpl;

            if (file_exists(DR . dir_site . 'index.php'))
                require_once( DR . dir_site . 'index.php');

            if (file_exists(DR . dir_site . 'twig.function.php'))
                require_once( DR . dir_site . 'twig.function.php');

//        $smarty->template_dir = dir_serv_site_tpl;

            if (file_exists(DR . $vv['sd'] . 'css.css'))
                $vv['dihead'] .= '<link href="' . $vv['sd'] . 'css.css?' . filemtime(DR . $vv['sd'] . 'css.css') . '" rel="stylesheet" />';

            if (file_exists(DR . $vv['sd'] . 'js.js')) {
                //$vv['in_body_end'][] = '<script type="text/javascript" src="' . $vv['sd'] . 'js.js"></script>';
                $vv['in_body_end_js'][$vv['sd'] . 'js.js'] = 1;
            }

//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }


            /*
             * пробуем мем кеш, нет разницы читать 1 файл и мемкеш
             */
            if (1 == 2) {
//    if (isset($_GET['stap']{0})) {
//        echo \Nyos\timer2::start();
//
//        if (function_exists(memcache_get)) {
//
//            if (!isset($mc)) {
//                $mc = \memcache_connect('localhost', 11211);
//            }
//
//            echo '<br/>2 ' . __LINE__;
//            $var = \memcache_get($mc, 'menu_' . folder);
//            // $var = '';
//            echo '<pre>';
//            print_r($var);
//            echo '</pre>';
//
//            if (!isset($var['menu_' . folder])) {
//
//                echo '<br/>1 - ' . __LINE__.' ';
//                $amnu = Nyos\nyos::get_menu(folder);
//                //$var = \memcache_get($mc, 'some_key');
//                \memcache_set($mc, 'menu_' . folder, $amnu, false, 20);
//            }
//        }
//
//        echo \Nyos\timer2::showTime() . ' сек<br/>';
//    } else {
//
//    }
//    if (isset($_GET['stap']{0})) {
//        \Nyos\timer2::start();
//    }
//        $vv['mnu'] = Nyos\nyos::creat_menu($now['folder']);
//    if (isset($_GET['stap']{0})) {
//        echo \Nyos\timer2::showTime() . ' сек<br/>';
//        die();
// }
            }

            for ($m = 1; $m <= 10; $m++) {

                if (file_exists(DR . dir_site_tpl . 'nyos.dop.menu' . $m . '.htm')) {

                    $vv['t_menu' . $m] = dir_site_tpl . 'nyos.dop.menu' . $m . '.htm';
                    $vv['menu'][$m] = [];

                    foreach (\Nyos\Nyos::$menu as $item => $w) {
                        if (isset($w['in-menu-' . $m]))
                            $vv['menu'][$m][$item] = 1;
                    }
                }
            }

            $vv['all_menu'] = \Nyos\Nyos::$menu;


//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }



            if (file_exists(DR . dir_site . 'config.php'))
                require( DR . dir_site . 'config.php');

//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }


            if (file_exists(DR . dir_site . 'config..' . $vv['level'] . '.php'))
                require( DR . dir_site . 'config..' . $vv['level'] . '.php');

            if (file_exists(DR . dir_site . '00start.php'))
                require DR . dir_site . '00start.php';



//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }


            /**
             * 0.site/exe/site_vars
             */
//    require_once './0.site/exe/site_vars/class.php';
//    \Nyos\Vars::$folder = $vv['folder'];
//    $vv['site_vars'] = \Nyos\Vars::get($db,'array_show');
//\f\pa(\Nyos\nyos::$menu);
//\f\pa(\Nyos\nyos::$menu,2);
//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }

            /**
             * загрузка информеров
             */
            foreach (\Nyos\nyos::$menu as $item => $w) {

                if ($item == 'di')
                    continue;

                if (!isset($w['type']) || !isset($w['version']))
                    continue;
//\f\pa($item);
// \f\pa($w);

                $dir_inf_type = DR . dir_mods . $w['type'] . DS;
                $dir_inf_type_ver = DR . dir_mods . $w['type'] . DS . $w['version'] . DS;

                //echo '<br/>';
                $dir_inf_type_ver2 = dir_mods . $w['type'] . DS . $w['version'] . DS;

                $u = 'glob.css.css';
                if (file_exists($dir_inf_type_ver . $u))
                    $vv['in_body_end_css'][$dir_inf_type_ver2 . $u] = 1;
                //$vv['dihead'] .= '<link href="' . $dir_inf_type_ver2 . $u . '" rel="stylesheet" />';

                $u = 'glob.js.js';
                if (file_exists($dir_inf_type_ver . $u))
                    $vv['in_body_end_js'][$dir_inf_type_ver2 . $u] = 1;
                //$vv['in_body_end'][] = '<script type="text/javascript" src="' . $dir_inf_type_ver2 . $u . '"></script>';

                if (isset($w['no_inf']))
                    continue;

                try {

// инфа модуля по текущему информеру
                    $vv['now_inf_cfg'] = $w;

                    if (file_exists($dir_inf_type . 'class.php'))
                        require_once( $dir_inf_type . 'class.php' );

                    // echo '<br/>'.$dir_inf_type ;

                    if (file_exists($dir_inf_type_ver . 'twig.function.php'))
                        require_once( $dir_inf_type_ver . 'twig.function.php' );

// для информеров данные сейчас
//f\pa($w);
// $dir_tpl_site = $_SERVER['DOCUMENT_ROOT'] . DS . 'sites' . DS . $now['folder'] . DS . 'module' . DS . $w['cfg.level'] . DS . 'tpl.inf' . DS;

                    $dir_tpl_site = DR . dir_site_module . $w['cfg.level'] . DS . 'tpl.inf' . DS;

                    $vv['_for_inf_now'] = $w;

                    if (file_exists($dir_inf_type_ver . '00var.php'))
                        require( $dir_inf_type_ver . '00var.php' );

                    for ($r = 1; $r <= 10; $r++) {

                        if (!file_exists($dir_inf_type_ver . 'informer.' . $r . '.php'))
                            continue;

                        try {

                            //echo '<br/>'.$dir_inf_type_ver . 'informer.' . $r . '.php';
                            //echo '<Br/>'.__FILE__.' '.__LINE__.' 22 ';

                            $_inf_[$dir_inf_type_ver . 'informer.' . $r . '.php'] = true;
                            require( $dir_inf_type_ver . DS . 'informer.' . $r . '.php' );
                        } catch (\Error $e) {

                            throw new \NyosEx('Какаято проблема с загрузкой информера / ' . $e->getMessage() . ' #' . $e->getCode() . ' ' . $e->getFile() . ' [' . $e->getLine() . ']');
//echo '<br/>Error ' . __FILE__ . ' #' . __LINE__;
// \f\pa($e);
                        } catch (\Exception $e) {

                            throw new \NyosEx('Какаято проблема с загрузкой информера / ' . $e->getMessage() . ' #' . $e->getCode() . ' ' . $e->getFile() . ' [' . $e->getLine() . ']');
//echo '<br/>Error ' . __FILE__ . ' #' . __LINE__;
// \f\pa($e);
                        }
                    }
                } catch (\NyosEx $ex) {
                    if (strpos($_SERVER['DOCUMENT_ROOT'], ':') !== false) {
                        echo '<br/><br/>NyosEx<div style="background-color:#efefef;padding:10px;">--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                        . '<pre>'
                        . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                        . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                        . PHP_EOL . $ex->getTraceAsString()
                        . '</pre></div>';
                    }
                } catch (\Exception $ex) {
                    if (strpos($_SERVER['DOCUMENT_ROOT'], ':') !== false) {
                        echo '<br/><br/>Ex<div style="background-color:#efefef;padding:10px;">--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                        . '<pre>'
                        . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                        . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                        . PHP_EOL . $ex->getTraceAsString()
                        . '</pre></div>';
                    }
                } finally {
                    $vv['now_inf_cfg'] = null;
                }
            }


//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }

            /**
             * загрузка информеров didrive
             */
            foreach (\Nyos\nyos::$menu['di'] as $item => $w) {

//\f\pa($item);
//\f\pa($w);

                if (isset($w['no_inf']))
                    continue;

                try {

// инфа модуля по текущему информеру
                    $vv['now_inf_cfg'] = $w;

                    $dir_inf_type = DR . dir_mods . $w['type'] . DS;
                    $dir_inf_type_ver = DR . dir_mods . $w['type'] . DS . $w['version'] . DS;

                    if (file_exists($dir_inf_type . 'class.php'))
                        require_once( $dir_inf_type . 'class.php' );

                    if (file_exists($dir_inf_type . 'twig.function.php'))
                        require_once( $dir_inf_type . 'twig.function.php' );

// для информеров данные сейчас
//f\pa($w);
// $dir_tpl_site = $_SERVER['DOCUMENT_ROOT'] . DS . 'sites' . DS . $now['folder'] . DS . 'module' . DS . $w['cfg.level'] . DS . 'tpl.inf' . DS;

                    $dir_tpl_site = DR . dir_site_module . $w['cfg.level'] . DS . 'tpl.inf' . DS;

                    $vv['_for_inf_now'] = $w;

                    if (file_exists($dir_inf_type_ver . '00var.php'))
                        require( $dir_inf_type_ver . '00var.php' );

                    for ($r = 1; $r <= 10; $r++) {

                        if (!file_exists($dir_inf_type_ver . 'informer.' . $r . '.php'))
                            continue;

                        try {

                            $_inf_[$dir_inf_type_ver . 'informer.' . $r . '.php'] = true;
                            require( $dir_inf_type_ver . DS . 'informer.' . $r . '.php' );
                        } catch (\Error $e) {

                            throw new \NyosEx('Какаято проблема с загрузкой информера / ' . $e->getMessage() . ' #' . $e->getCode() . ' ' . $e->getFile() . ' [' . $e->getLine() . ']');
//echo '<br/>Error ' . __FILE__ . ' #' . __LINE__;
// \f\pa($e);
                        } catch (\Exception $e) {

                            throw new \NyosEx('Какаято проблема с загрузкой информера / ' . $e->getMessage() . ' #' . $e->getCode() . ' ' . $e->getFile() . ' [' . $e->getLine() . ']');
//echo '<br/>Error ' . __FILE__ . ' #' . __LINE__;
// \f\pa($e);
                        }
                    }
                } catch (\NyosEx $ex) {
                    if (strpos($_SERVER['DOCUMENT_ROOT'], ':') !== false) {
                        echo '<br/><br/>NyosEx<div style="background-color:#efefef;padding:10px;">--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                        . '<pre>'
                        . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                        . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                        . PHP_EOL . $ex->getTraceAsString()
                        . '</pre></div>';
                    }
                } catch (\Exception $ex) {
                    if (strpos($_SERVER['DOCUMENT_ROOT'], ':') !== false) {
                        echo '<br/><br/>Ex<div style="background-color:#efefef;padding:10px;">--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                        . '<pre>'
                        . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                        . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                        . PHP_EOL . $ex->getTraceAsString()
                        . '</pre></div>';
                    }
                } finally {
                    $vv['now_inf_cfg'] = null;
                }
            }

            if (file_exists(DR . dir_site . 'config.site.php'))
                require( DR . dir_site . 'config.site.php');

//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }


            /**
             * загрузка модуля и файлов 
             */
            if (1 == 1 && isset(\Nyos\nyos::$menu[$vv['level']])) {

                if (defined('dir_mods_mod_vers')) {
                    if (file_exists(DR . dir_mods_mod_vers . 'css.css')) {
                        //$vv['in_body_end'][] = '<link href="' . dir_mods_mod_vers . 'css.css" rel="stylesheet" />';
                        $vv['in_body_end_css'][dir_mods_mod_vers . 'css.css'] = 1;
                    }

                    if (file_exists(DR . dir_mods_mod_vers . 'js.js')) {
                        //$vv['in_body_end'][] = '<script src="' . dir_mods_mod_vers . 'js.js"></script>';
                        $vv['in_body_end_js'][dir_mods_mod_vers . 'js.js'] = 1;
                    }
                }

                if (file_exists(DR . dir_site_module_nowlev . 'js.js')) {
                    //$vv['in_body_end'][] = '<script src="' . dir_site_module_nowlev . 'js.js"></script>';
                    $vv['in_body_end_js'][dir_site_module_nowlev . 'js.js'] = 1;
                }

                /**
                 * вставляем файлы модуля
                 */
                try {

                    // echo dir_mods_mod_vers;

                    if (defined('dir_mods_mod_vers')) {

                        // $vv['dir_site_module_nowlev_tpl'] = dir_site_module_nowlev_tpl;

                        if (file_exists(DR . dir_mods_mod_vers . 'a.php'))
                            require( DR . dir_mods_mod_vers . 'a.php' );

                        if (file_exists(DR . dir_mods_mod_vers . 'twig.function.php'))
                            require_once( DR . dir_mods_mod_vers . 'twig.function.php' );
                    }

//                echo '<br/>' . __LINE__;
//                echo '<Br/>' . DR . dir_mods_mod_vers . 'index.php';

                    if (defined('dir_mods_mod_vers') && file_exists(DR . dir_mods_mod_vers . 'index.php')) {

//                    echo '<br/>' . __LINE__;
//                    echo '<br/>require(' . DR . dir_mods_mod_vers . 'index.php';

                        require( DR . dir_mods_mod_vers . 'index.php' );
                    }
                    //
                    elseif (defined('dir_mods_mod') && file_exists(DR . dir_mods_mod . 'v.' . Nyos\nyos::$menu[$vv['level']]['version'] . '.php')) {
//                    echo '<br/>' . __LINE__;
                        require( DR . dir_mods_mod . 'v.' . Nyos\nyos::$menu[$vv['level']]['version'] . '.php' );
                    }

//                echo '<br/>' . __LINE__;

                    if (defined('dir_mods_mod') && file_exists(DR . dir_mods_mod . 'x.php'))
                        require( DR . dir_mods_mod . 'x.php' );
                }
//
                catch (\NyosEx $ex) {

                    echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString()
                    . '</pre>';
                }
//
                catch (\PDOException $ex) {

                    echo '<pre>PDO --- ' . __FILE__ . ' ' . __LINE__ . '-------'
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString()
                    . '</pre>';
                }
//
                catch (\Exception $ex) {

                    echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL . $ex->getTraceAsString()
                    . '</pre>';
                }
            }

            if (file_exists(DR . dir_site . 'end.php'))
                require_once( DR . dir_site . 'end.php');

//\f\pa($vv);
//        foreach ($vv as $k => $v) {
//            $smarty->assign($k, $v);
//        }
//
//        $smarty->display(dir_serv_site . 'template' . DS . 'body.htm');
//    echo $ttwig->render($vv);        
        }


//    $r = ob_get_contents();
//    ob_end_clean();
//        if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//            die('<br/>' . __FILE__ . ' ' . __LINE__);
//        }




        if (1 == 1) {

//    echo '<Br>' . __FILE__ . ' #' . __LINE__;
//    die($r);
//    require( $_SERVER['DOCUMENT_ROOT'] . '/0.all/inf.post.php' );
// проверка и вставка переменных в html
            if (1 == 1) {

// echo $status;
// ckeditor
                if (1 == 1 && isset($ckeditor_in) && sizeof($ckeditor_in) > 0) {

// f\pa($ckeditor_in);
                    $body_end_str .= '<script type="text/javascript" charset="utf-8" src="/js/ckeditor.4.5.11/ckeditor.js"></script>';

                    foreach ($ckeditor_in as $k => $v) {
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
                        } elseif (isset($v['type']) && $v['type'] == 'full') {
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

// добавляем css в $body_start_str
// добавляем блок ссылок в $body_end_str
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/index.sale_link.php')) {

                    if (isset($_GET['nyos_timer']{0})) {
                        echo '<br/>require_once(' . $_SERVER['DOCUMENT_ROOT'] . '/index.sale_link.php';
                    }

                    require_once($_SERVER['DOCUMENT_ROOT'] . '/index.sale_link.php');
                }

//    if (isset($_GET['nyos_timer']{0})) {
//        echo '<br/>line:' . __LINE__ . ' ' . \Nyos\timer2::showTime() . ' сек';
//    }


                $r22 = $r23 = array();

                $body_end_str = $body_start_str = '';

                if (isset($vv['dihead']{3})) {
                    $body_start_str .= $vv['dihead'];
                }

                if (isset($body_start_str{1})) {
                    $r22[] = '</head>';
                    $r23[] = $body_start_str . '</head>';
                }

// если показываем статус записи то и стили их подтягиваем
                if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                    if ($_SERVER['HTPP_HOST'] == 'ya-time.uralweb.info') {
                        $body_end_str .= ' ' . __LINE__ . '<link href="/css/for_status.css" rel="stylesheet" />';
                    } else {
                        $body_end_str .= '<link href="/css/for_status.css" rel="stylesheet" />';
                    }
                }

                if (isset($vv['in_body_end_css']) && sizeof($vv['in_body_end_css']) > 0) {

                    // \f\pa($vv['in_body_end_css']);

                    foreach ($vv['in_body_end_css'] as $k => $v) {

                        // echo '<Br/>'.$v;
//                        if ($_SERVER['HTTP_HOST'] == 'ya-time.uralweb.info') {
//                            $body_end_str .= ' ' . __LINE__ . '<link rel="stylesheet" type="text/css" media="all" href="' . $k . '" />';
//                        } else {

                        $body_end_str .= '<link rel="stylesheet" type="text/css" media="all" href="' . $k . ( file_exists(DR . $k) ? '?' . filemtime(DR . $k) : '' ) . '" />';
//                        }
                    }
                }

                if (isset($vv['in_body_end']) && sizeof($vv['in_body_end']) > 0) {
                    foreach ($vv['in_body_end'] as $k => $v) {
//                        if ($_SERVER['HTTP_HOST'] == 'ya-time.uralweb.info') {
//                            $body_end_str .= '222' . $v;
//                        } else {
                        $body_end_str .= $v;
//                        }
                    }
                }

                if (isset($vv['in_body_end_js']) && sizeof($vv['in_body_end_js']) > 0) {

                    // \f\pa($vv['in_body_end_js'],'','','in_body_end_js');

                    foreach ($vv['in_body_end_js'] as $js => $v) {
//                        if ($_SERVER['HTTP_HOST'] == 'ya-time.uralweb.info') {
//                            $body_end_str .= '11<script src="' . $js . '" ></script>';
//                        } else {

                        if (strpos($js, 'base') !== false) {
                            $body_end_str .= '<script src="' . $js . ( file_exists(DR . $js) ? '?' . filemtime(DR . $js) : '' ) . '" ></script>';
                        }
//                        }
                    }

                    foreach ($vv['in_body_end_js'] as $js => $v) {
//                        if ($_SERVER['HTTP_HOST'] == 'ya-time.uralweb.info') {
//                            $body_end_str .= '11<script src="' . $js . '" ></script>';
//                        } else {
                        if (strpos($js, 'base') === false) {
                            $body_end_str .= '<script src="' . $js . ( file_exists(DR . $js) ? '?' . filemtime(DR . $js) : '' ) . '" ></script>';
                        }
//                        }
                    }
                }

                if (isset($body_end_str{0})) {
                    $r22[] = '</body>';
                    $r23[] = $body_end_str . '</body>';
                }

//    if (isset($_GET['nyos_timer']{0})) {
//        echo '<br/>line:' . __LINE__ . ' ' . \Nyos\timer2::showTime() . ' сек';
//    }

                if (1 == 2) {

                    /**
                     * хостинг папки сайта .. если не оплачен то блок
                     */
                    if (isset($vv['folder'])) {

                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/sites/' . $vv['folder'] . '/hosting_ok') && ( filemtime($_SERVER['DOCUMENT_ROOT'] . '/sites/' . $vv['folder'] . '/hosting_ok') + 3600 * 23 ) < $_SERVER['REQUEST_TIME'])
                            unlink($_SERVER['DOCUMENT_ROOT'] . '/sites/' . $vv['folder'] . '/hosting_ok');

                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/sites/' . $vv['folder'] . '/hosting_ok')) {

// если хостинг НЕ оплачен, вернёт сумму оплаты
                            $hosting = Nyos\nyos::hosting_pay($db, $vv['folder']);

                            if (isset($hosting{0}) && is_numeric($hosting)) {
// echo '<br/>'.__FILE__.' '.__LINE__;

                                $r22 = $r23 = array();
                                $r22[] = '</body>';
                                $r23[] = '
            <style>
            #parent_popup {
                background: #000;
                height: 100%;
                opacity: 0.4;
                position: fixed;
                width: 100%;
                z-index: 100;
                top: 0;
                left: 0;
                z-index: 50001;
                }
            #popup {
                left: calc(50% - 250px);  top: calc(50% - 200px);
                z-index: 50002;
                opacity: 1;
                background-color: rgba(255,255,255,0.85);
                border-radius: 5px;
                box-shadow: 0 2px 14px rgba(0, 0, 0, .9);
                position: fixed;
                color: blue;
                width: 700px;
                padding: 10px;
                text-align: center;
                }
            #popup p{
            color: blue;
            }
            #popup input[type=text],
            #popup textarea{
                width: 100%;
                margin-bottom:10px;
                }

            h3{ background-color: rgba(0,0,255,0.2); padding: 10px; }

            </style>

                <div id="parent_popup">&nbsp;</div>
                <div id="popup">

                <h3>Оплаченный хостинг сайта окончен</h3>
                <table class=table ><tr><td valign=top >
                <center>
                <p>Для продления, переведите ' . number_format($hosting, 0, '', '`') . ' руб.
                <br/>на карту сбербанка<br/>№ 4276&nbsp;6700&nbsp;1717&nbsp;3849<br/>Получатель: Сергей</p>
                <p>После оплаты позвоните и сообщите о ней по тел 8-922-262-22-89</p>
                </td>' .
//                <!-- td valign=top >
//                <div style="padding-right:40px;padding-left:40px" >
//
//                    <b>Отправить сообщение</b>
//                    <br/>
//                    <br/>
//                    <input type=text name=fio placeholder=ФИО /><br/>
//                    <input type=text name=tel placeholder=телефон /><br/>
//                    <textarea name=msg placeholder="Ваше сообщение" ></textarea>
//                    <input type=submit name=send value="Отправить" /><br/>
//                </div>
//                </td -->
                                        '</tr></table>
                </div>
            </body>';
                            }
                        }
                    }
                }

                if (sizeof($r22) > 0) {

                    $r = str_replace($r22, $r23, $r);
                    unset($r22, $r23);
                }

                /**
                 * если есть файл сайта 1 страницы .. то делаем кеш ... если бы он был то до сюда мы не дошли
                 */
//    if( \Nyos\nyos::checkOnOffCashSiteOnePage($vv['folder']) === true ){
//    \Nyos\nyos::creatCashSiteIsOnePage($r);
//    }
            }

//if (isset($_GET['nyos_timer']{0})) {
//    echo '<br/>line:' . __LINE__ . ' ' . \Nyos\timer2::showTime() . ' сек';
//    echo '<br/>' . __FILE__ . ' [' . __LINE__ . ']'
//    . '<hr><hr>end php<hr><hr>';
//}
//\f\pa($vv['inf']);
        }


        /**
         * шаблонизатор
         */
        if (isset($_GET['no_shablons'])) {
            
        } else {

// echo $vv['folder'];
// \f\pa($vv['now_level']);
// \f\pa($vv['level']);


            $twig->addGlobal('session', $_SESSION);
//$vv['session'] = $_SESSION;
            $twig->addGlobal('server', $_SERVER);
            $twig->addGlobal('post', $_POST);
            $twig->addGlobal('get', $_GET);

            require DR . '/all/twig.function.php';

            if (file_exists(DR . '/vendor/didrive/f/twig.function.php')) {
                require_once DR . '/vendor/didrive/f/twig.function.php';
                //echo '<br/>'.__FILE__.' #'.__LINE__;
            }

            // echo DR.dir_site_tpl . 'body.htm';
            // exit;
            // $ttwig = $twig->loadTemplate(DR.dir_site_tpl . 'body.htm');

            $ttwig = $twig->loadTemplate(dir_site_tpl . 'body.htm');

            if (empty($vv['vars_site']) && file_exists(DR . '/vendor/didrive_mod/vars_on_site/class.php')) {
                $vv['vars_site'] = \Nyos\mod\VarsOnSite::getVars($db);
                // \f\pa($vv['vars_site']);
            }

        //if( 1 == 1 || ( isset($timer1) && $timer1 === true ) )
        //    \f\timer_start (221);

            echo $ttwig->render($vv);

        //if( 1 == 1 || ( isset($timer1) && $timer1 === true ) )
        //    echo '<br/>#'.__LINE__.' render '.\f\timer_stop(221);
        }

        $r = ob_get_contents();
        ob_end_clean();

        /**
         * пост обработка (после формирования всего html
         */
        $body_end_str = '';

        if (!empty($vv['in_body_end_css'])) {
            foreach ($vv['in_body_end_css'] as $k => $v) {
                $body_end_str .= '<link rel="stylesheet" type="text/css" media="all" href="' . $k . '" />';
            }
        }

        if (!empty($vv['in_body_end_js'])) {
            foreach ($vv['in_body_end_js'] as $js => $v) {
                $body_end_str .= '<script src="' . $js . '" ></script>';
            }
        }

        if (!empty($vv['in_body_end_keys'])) {
            foreach ($vv['in_body_end_keys'] as $k => $v) {
                $body_end_str .= $v;
            }
        }

        if (!empty($vv['in_body_end'])) {
            foreach ($vv['in_body_end'] as $k => $v) {
                $body_end_str .= $v;
            }
        }

        if (isset($body_end_str{0})) {
            $r22[] = '</body>';
            $r33[] = $body_end_str . '</body>';
        }

        if (!empty($r22))
            $r = str_replace($r22, $r33, $r);

//    if ($_SERVER['HTTP_HOST'] == 'ya-time.uralweb.info') {
//        \f\pa($vv['in_body_end'], 2, '', 'in_body_end', true, 'html-special');
//        \f\pa($vv['in_body_end_js'], 2, '', 'in_body_end_js', true, 'html-special');
//        \f\pa($r22, 2, '', 'r22', true, 'html-special');
//        \f\pa($r33, 2, '', 'r33', true, 'html-special');
//    }
//        if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//            die('<br/>' . __FILE__ . ' ' . __LINE__);
//        }



        die($r);
    } catch (\PDOException $ex) {

        $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
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
                . PHP_EOL . $_SERVER['REQUEST_URI']
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        if (class_exists('\nyos\Msg'))
            \nyos\Msg::sendTelegramm($text, null, 1);

        die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
    } catch (\Throwable $ex) {

        $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $_SERVER['REQUEST_URI']
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        if (class_exists('\nyos\Msg'))
            \nyos\Msg::sendTelegramm($text, null, 1);

        die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
    }
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
