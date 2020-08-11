<?php

date_default_timezone_set("Asia/Yekaterinburg");
header("Cache-control: public");



ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('IN_NYOS_PROJECT', true);

/*
 echo '<pre>'; print_r( $_REQUEST ); echo '</pre>'; 
 //exit;
 echo '<pre>'; print_r( $_GET ); echo '</pre>'; 
 exit;
*/
/*
foreach( $_GET as $k => $v ){
parse_str( urldecode($k), $_REQUEST );
// echo '<pre>'; print_r( $r ); echo '</pre>'; 
break;
}

echo '<pre>'; print_r( $_REQUEST ); echo '</pre>';  
 * 
 */


require_once( $_SERVER['DOCUMENT_ROOT'] . '/include/Nyos/Nyos.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/include/f/file.php' );

if (isset($_REQUEST['show']) && $_REQUEST['show'] == 'file' 
        && isset($_REQUEST['s']) && isset($_REQUEST['file']) 
        && ( 
            Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['file']) 
            || $_REQUEST['s'] == md5($_REQUEST['file']) 
            || $_REQUEST['s'] == md5( 'size'.filesize($_SERVER['DOCUMENT_ROOT'].$_REQUEST['file']) ) 
        )
                
        && file_exists($_SERVER['DOCUMENT_ROOT'] . $_REQUEST['file'])) {

    die(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $_REQUEST['file']));
    
} 
/**
 * качаем файл с другим именем
 */
elseif ( 
        isset($_REQUEST['s']) 
        && isset($_REQUEST['file']) 
        && \Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['file']) 
        && file_exists( $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['file']) 
    ) {

    \f\file_force_download_var1($_REQUEST['file'], ( isset($_REQUEST['name']) ? $_REQUEST['name'] : null));
    exit;
    
}

echo '<pre>'; print_r( $_REQUEST ); echo '</pre>';  

die('Спасибо что воспользовались сервисов, приходите ещё');
