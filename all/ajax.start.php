<?php

require_once dirname(__FILE__) . '/session_start.php';

\Nyos\Nyos::getFolder();

if (!empty(\Nyos\Nyos::$folder_now))
    $vv['folder'] = \Nyos\Nyos::$folder_now;

\Nyos\Nyos::defineVars();

require_once $_SERVER['DOCUMENT_ROOT'] . '/all/sql.start.php';
