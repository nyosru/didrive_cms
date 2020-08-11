<?php

$vv['dibody']['start'] .= '<link href="/template/preloader4/css.min.css" rel="stylesheet" />'
    .file_get_contents($_SERVER['DOCUMENT_ROOT'].'/template/preloader4/up.htm');

$vv['dibody']['end'] .= file_get_contents($_SERVER['DOCUMENT_ROOT'].'/template/preloader4/down.htm');
