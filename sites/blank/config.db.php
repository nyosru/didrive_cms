<?php

if (class_exists('\nyos\msg')) {
// акк на буке // мой шлак
//    \nyos\Msg::$admins_id[] = 1368605419;
// максим
//    \nyos\Msg::$admins_id[] = 93066902;
}

\Nyos\Nyos::$db_type = $db_cfg['type'] = 'mysql';

// $db_cfg['host'] = '127.0.0.1';
$db_cfg['host'] = 'localhost';

// разработка
//if ($_SERVER['HTTP_HOST'] == 'adomik.dev.uralweb.info') {
//
//    $db_cfg['db'] = 'di4dev_yap2';
//    $db_cfg['login'] = 'yap2';
//    $db_cfg['pass'] = '123Yap2123';
//
//}
//// тест
//elseif ($_SERVER['HTTP_HOST'] == 'adomik.test.uralweb.info') {
//
//    $db_cfg['db'] = 'yadomik2';
//    $db_cfg['login'] = 'yadomik2';
//    $db_cfg['pass'] = '123Yadomik2123';
//    
//}
// боевой
//else {

//    $db_cfg['db'] = 'sql_yadom_admin';
//    $db_cfg['login'] = 'yadom_admin';
//    $db_cfg['pass'] = '123Yapdom';
    $db_cfg['db'] = 'si11';
    $db_cfg['login'] = 'si11';
    $db_cfg['pass'] = '1212';
    
//}

// \f\pa($db_cfg);
// die(\f\pa($db_cfg));
