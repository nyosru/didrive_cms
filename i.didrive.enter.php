<?php

// выходим
if (isset($_REQUEST['option']) && $_REQUEST['option'] == 'exit') {

    if (isset($_SESSION['now_user_di']))
        $_SESSION['now_user_di'] = '';

    if (isset($_SESSION['dilogin']))
        $_SESSION['dilogin'] = '';

    f\redirect('/', 'didrive/', array('rand' => rand(0, 100)));
}

if (!class_exists('\\Nyos\\mod\\lk'))
    require_once DR . '/vendor/didrive_mod/lk/class.php';











//echo PHP_EOL;
//echo __FILE__.' ('.__LINE__.')';
//echo PHP_EOL;
//echo 'folder '.$vv['folder'];
//echo PHP_EOL;
// \f\pa( $_SESSION['now_user_di']['id'], 2);
// \f\pa($list_access,'','','$list_access');
// \f\pa(\Nyos\Nyos::$access_mod,'','','$list_access');
//echo '<br/>ee1: ' . \f\timer::stop('str', 99);
//echo '<br/>ee2: ' . \f\CalcMemory::stop(99);
// {*f\pa($modules)*}
//        foreach ($list_access[$_SESSION['now_user_di']['id']]['didrive'] as $k => $v) {
//            if ($v == 'yes')
//                $vv['modules'][$k]['access_moder'] = 'da';
//        }




if (
// если вошедший админ
        ( isset($_SESSION['now_user_di']['id']) && isset($_SESSION['now_user_di']['access']) && ( $_SESSION['now_user_di']['access'] == 'admin' || $_SESSION['now_user_di']['access'] == 'moder' ))
// или я
        || ( isset($_SESSION['now_user_di']['uid']) && ( $_SESSION['now_user_di']['uid'] == 5903492 || $_SESSION['now_user_di']['soc_web_id'] == 5903492 ) )
// или максим
//        || ( isset($_SESSION['now_user_di']['uid']) && ( $_SESSION['now_user_di']['uid'] == 36588477 || $_SESSION['now_user_di']['soc_web_id'] == 36588477 ) )
) {
    
}
// если не админ то ошибку 
else {
    throw new \Exception('Прав доступа недостаточно, обратитесь к администратору');
}






// \f\pa($_SESSION);
// \f\timer::start(99);
// \f\CalcMemory::start(55);
// \Nyos\Nyos::$access_mod = \Nyos\mod\lk::getDidriveUsersAccess($db, $vv['folder'], $_SESSION['now_user_di']['id']);
\Nyos\Nyos::$access_mod = \Nyos\mod\lk::getAccess($db, $_SESSION['now_user_di']['id']);

// \f\pa(\Nyos\Nyos::$access_mod, '', '', '\Nyos\Nyos::$access_mod');



//\f\pa('1');

if (1 == 1) {

    // $AMCfg['allmod'] = $vv['modules'] = $_m = \Nyos\Nyos::alist($db, 'modules');
    // $AMCfg['allmod'] = $vv['modules'] = $_m = \Nyos\Nyos::alist($db, 'modules');
    // f\pa($vv['modules']);
    // echo $nyos -> folder;
    // \f\pa($_SESSION['now_user_di']);
    // \f\pa($_SESSION,2,'session');
    // \f\pa($_SESSION['now_user_di'],2,'session');
    // $_SESSION['now_user_di']['access'] => moder
//    if (class_exists('\Nyos\mod\AdminAccess') && isset($_SESSION['now_user_di']['access']) && $_SESSION['now_user_di']['access'] == 'moder') {
//
//        $access = \Nyos\mod\AdminAccess::getModerAccess($db, $vv['folder'], $_SESSION['now_user_di']['id']);
//        \Nyos\Nyos::$access_mod = $access;
//        \f\pa(\Nyos\Nyos::$access_mod,2,'$access_mod');
//
//    }
//    else{
//        echo '<br/>'.__FILE__.' '.__LINE__;
//    }
//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//
//
//    \f\pa(\Nyos\Nyos::$access_mod, 2, '', '$access_mod'); // die;
//    \f\pa(\Nyos\Nyos::$a_menu, 2, '', 'a_menu'); // die;

    \Nyos\Nyos::getSiteModule();

    //\f\pa(\Nyos\Nyos::$access_mod, 2, '', '\Nyos\Nyos::$access_mod'); // die;
//    \f\pa(\Nyos\Nyos::$a_menu, 2, '', 'a_menu'); // die;
//    \f\pa(\Nyos\Nyos::$all_menu, 2, '', 'all_menu'); // die;

    $vv['loaded_start'] = [];

    if (!isset($_REQUEST['level']) && !isset($_REQUEST['level_di'])) {
        foreach (\Nyos\Nyos::$a_menu as $k => $w) {
            if (isset($w['module_start']) && $w['module_start'] == 'da') {
                $request['level'] = $k;
                \f\redirect('/', 'i.didrive.php', $request);
            }
        }
    }
    $vv['loaded_start'] = [];

    /**
     * добавляем твиг функции что в дидрайв модулях
     */
    $scan = scandir(DR . DS . 'vendor' . DS . 'didrive');
    foreach ($scan as $k => $v) {
        if ($v !== '.' && $v !== '..') {
            $u = DR . DS . 'vendor' . DS . 'didrive' . DS . $v . DS . 'twig.function.php';
            if (file_exists($u))
                require_once( $u );
        }
    }

    /**
     * проходим по всем модулям сайта и подгружаем классы, функции твиг, glob.js
     */
    foreach (\Nyos\Nyos::$all_menu as $k => $w) {
        if (isset($w['type']) && !isset($vv['loaded_start'][$w['type'] . '_' . $w['version']])) {

            $vv['loaded_start'][$w['type'] . '_' . $w['version']] = 1;

            $u = $_SERVER['DOCUMENT_ROOT'] . DS . 'vendor' . DS . 'didrive_mod' . DS . $w['type'] . DS . 'class.php';
            if (file_exists($u))
                require_once( $u );

            $u = $_SERVER['DOCUMENT_ROOT'] . DS . 'vendor' . DS . 'didrive_api' . DS . $w['type'] . DS . 'twig.function.php';
            //echo '<br/>'.$u;
            if (file_exists($u))
                require_once( $u );

            if (file_exists(DR . DS . 'vendor' . DS . 'didrive_api' . DS . $w['type'] . DS . 'glob.js.js'))
                $vv['in_body_end'][] = '<script defer="defer" type="text/javascript" src="' . DS . 'vendor' . DS . 'didrive_api' . DS . $w['type'] . DS . 'glob.js.js"></script>';

            $u = DR . DS . 'vendor' . DS . 'didrive_mod' . DS . $w['type'] . DS . $w['version'] . DS . 'twig.function.php';
            if (file_exists($u))
                require_once( $u );

            $u = DR . DS . 'vendor' . DS . 'didrive_mod' . DS . $w['type'] . DS . $w['version'] . DS . 'didrive' . DS . 'twig.function.php';
            //echo '<br/>'.$u;
            if (file_exists($u))
                require_once( $u );

            if (file_exists(DR . DS . 'vendor' . DS . 'didrive_mod' . DS . $w['type'] . DS . $w['version'] . DS . 'didrive' . DS . 'glob.js.js'))
                $vv['in_body_end'][] = '<script type="text/javascript" defer="defer" src="' . DS . 'vendor' . DS . 'didrive_mod' . DS . $w['type'] . DS . $w['version'] . DS . 'didrive' . DS . 'glob.js.js"></script>';
        }
    }
//    foreach (\Nyos\Nyos::$a_menu['di'] as $k => $w) {
//        if (isset($w['type'])) {
//            $u = $_SERVER['DOCUMENT_ROOT'] . DS . 'vendor' . DS . 'didrive_mod' . DS . $w['type'] . DS . 'class.php';
//
//            if (file_exists($u))
//                require_once( $u );
//        }
//    }
//    exit;

    if (file_exists(DR . dir_site_sd . 'didrive.css'))
        $vv['body_end'] .= '<link defer="defer" href="' . dir_site_sd . 'didrive.css' . '" rel="stylesheet" />';

    if (file_exists(DR . dir_site . 'twig.function.php'))
        require DR . dir_site . 'twig.function.php';

    if (defined('dir_mods_mod_vers_didrive') && file_exists(DR . dir_mods_mod_vers_didrive . 'index.php')) {

        if (file_exists(DR . dir_site_module_nowlev . 'twig.function.php'))
            require DR . dir_site_module_nowlev . 'twig.function.php';

        $vv['krohi'] = [];
        $vv['krohi'][1] = array(
            'text' => $vv['now_level']['name'],
            'uri' => $vv['now_level']['cfg.level']
        );

        //echo __FILE__.' '.__LINE__;

        $vv['dir_site_now_mod_ditpl'] = dir_site_module_nowlev_tpldidr;
        $vv['dir_mod_now_mod_ditpl'] = dir_mods_mod_vers_didrive_tpl;

        // конфиг сайта
//        if (file_exists(DR . dir_site . 'config.php'))
//            requery_once(file_exists(DR . dir_site . 'config.php'));
        //echo __FILE__.' '.__LINE__;

        if (file_exists(DR . dir_site_module_nowlev . 'config.php'))
            require_once DR . dir_site_module_nowlev . 'config.php';


        // стили внутри папки с дидрайвом
        if (file_exists(DR . dir_mods_mod_vers_didrive . 'css.css'))
            $vv['in_body_end'][] = '<link rel="stylesheet" href="' . dir_mods_mod_vers_didrive . 'css.css" type="text/css" media="all" />';

        // стили внутри папки модуля в папке сайта с 
        if (file_exists(DR . dir_site_module_nowlev . 'didrive.css.css'))
            $vv['in_body_end'][] = '<link rel="stylesheet" href="' . dir_site_module_nowlev . 'didrive.css.css" type="text/css" media="all" />';

//echo '<br/>'.__FILE__.' ('.__LINE__.')';
//echo '<br/>'. DR . dir_mods_mod_vers_didrive . 'js.js';

        if (file_exists(DR . dir_mods_mod_vers_didrive . 'js.js'))
            $vv['in_body_end'][] = '<script defer="defer" type="text/javascript" src="' . dir_mods_mod_vers_didrive . 'js.js"></script>';

        if (file_exists(DR . dir_site_module_nowlev . 'didrive.js.js'))
            $vv['in_body_end'][] = '<script defer="defer" type="text/javascript" src="' . dir_site_module_nowlev . 'didrive.js.js"></script>';

        if (file_exists(DR . dir_site_module_nowlev . 'didrive.twig.function.php'))
            require_once (DR . dir_site_module_nowlev . 'didrive.twig.function.php');

        if (file_exists(DR . dir_mods_mod_vers_didrive . 'twig.function.php'))
            require_once (DR . dir_mods_mod_vers_didrive . 'twig.function.php');

        if (file_exists(DR . dir_mods_mod_vers_didrive . '00start.php'))
            require_once( DR . dir_mods_mod_vers_didrive . '00start.php');

        // echo DR . dir_mods_mod_vers_didrive . 'index.php';
        require_once( DR . dir_mods_mod_vers_didrive . 'index.php');
    }

// список модулей
    else {
        // $vv['warn'] .= '<br/>'.$_GET['level'];
        $vv['tpl_body'] = \f\like_tpl('list_cat', dir_didr_tpl, dir_site_tpldidr, DR);
    }

    if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
        $vv['body_end'] .= '<link href="/css/for_status.css" rel="stylesheet" />';

    if ( !empty($vv['body_end']) ) {

        $r22[] = '</body>';
        $r23[] = $vv['body_end'] . '</body>';
    }
}
// если вошедший не админ
else {
    //f\pa($_SESSION['now_user_di']);
    $vv['warn'] = 'Вход успешно выполнен, обратитесь к администратору сайта.'
            . '<br/>'
            . '<br/>'
            . 'Ваш id ' . ( isset($_SESSION['now_user_di']['soc_web_id']) ? $_SESSION['now_user_di']['soc_web_id'] : 'вход был не по соц. сети' );
}
    
// echo \f\timer::stop(99);
