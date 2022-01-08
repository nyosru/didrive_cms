<?php

date_default_timezone_set("Asia/Yekaterinburg");
define('IN_NYOS_PROJECT', true);

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

require( $_SERVER['DOCUMENT_ROOT'] . '/all/ajax.start.php' );


/*
  require($_SERVER['DOCUMENT_ROOT'].'/0.site/0.start.php');

  //$site_root = "sport";

  //$file_site_root = $_SERVER['DOCUMENT_ROOT']."/".$site_root;
  //$file_site_root = $_SERVER['DOCUMENT_ROOT']."/";
 * 
 */

$dir_for_file = 'uploaded';

//if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site/')) {
//   
//    $server_site_root = '/site/' . $dir_for_file;
//    
//} else {
//    // достаём значение folder
//    
//    require_once $_SERVER['DOCUMENT_ROOT'] . '/include/Nyos/Nyos.php';
//    \Nyos\Nyos::getFolder($db);
//    $server_site_root = '/sites/' . \Nyos\Nyos::$folder_now . $dir_for_file;
//
//}
// $file_site_root = $_SERVER['DOCUMENT_ROOT'] . $server_site_root;

$file_site_root = DR . dir_site_sd . $dir_for_file;

if (!is_dir(DR . dir_site_sd . $dir_for_file))
    mkdir(DR . dir_site_sd . $dir_for_file, 0755);

ini_set("include_dir", ini_get("include_dir") . ":" . $file_site_root);

$version = "0.10";

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/include/f/txt.php');
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/include/f/file.php');

$file = \f\newfile($file_site_root . '/', \f\translit(substr($_FILES['upload']['name'], 0, 50), 'uri2') . '.' . \f\get_file_ext($_FILES['upload']['name']));

if (($_FILES['upload'] == "none") OR ( empty($_FILES['upload']['name']))) {
    // $message = "No file uploaded.";
    $message = 'Случилась неописуемая ситуация #' . __LINE__;
} else if ($_FILES['upload']["size"] == 0) {
    // $message = "The file is of zero length.";
    $message = 'Случилась неописуемая ситуация #' . __LINE__ . ' (загружено всего 0 байт)';
}

/*
  elseif(($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
  {
  $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
  $message = 'Случилась неописуемая ситуация #'.__LINE__;
  }
 */ else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
    // $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
    $message = 'Случилась неописуемая ситуация #' . __LINE__;
} else {
    $message = "";

    $move = @move_uploaded_file($_FILES['upload']['tmp_name'], $file_site_root . '/' . $file);

    if (!$move) {
        // $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
        $message = 'Случилась неописуемая ситуация #' . __LINE__;
    }

    echo '<script> window.parent.CKEDITOR.tools.callFunction( \'' . $_GET['CKEditorFuncNum'] . '\', \'' . dir_site_sd . $dir_for_file . '/' . $file . '\', \'' . $message . '\' ); </script>';
}