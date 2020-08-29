<?php

if (!extension_loaded('PDO')) {
    throw new \Exception(' pdo bd не доступен ');
}

if (file_exists(DR . dir_site . 'config.db.php'))
    require_once DR . dir_site . 'config.db.php';

try {

// postgresql
    if (isset($db_cfg['type']) && $db_cfg['type'] == 'pg') {

        $port = 5432;
        // $db = new \PDO('pgsql:host=' . $db_cfg['host'] . ';port=' . $port . ';dbname=' . $db_cfg['db'], $db_cfg['login'], $db_cfg['pass'], array(
        $db = new \PDO('pgsql:host=' . $db_cfg['host'] . ';port=' . $port . ';dbname=' . $db_cfg['db'], $db_cfg['login'], $db_cfg['pass'], array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
//        \PDO::ATTR_TIMEOUT => 2,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                // \PDO::ATTR_PERSISTENT=>true // постоянное соединение без отключений при перезагрузке
        ));
    }
// mysql
    elseif (isset($db_cfg['type']) && $db_cfg['type'] == 'mysql') {

        $db = new \PDO('mysql:host=' . $db_cfg['host'] . ';charset=UTF8;dbname=' . $db_cfg['db'], $db_cfg['login'], $db_cfg['pass'], array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
//        \PDO::ATTR_TIMEOUT => 2,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                // \PDO::ATTR_PERSISTENT=>true // постоянное соединение без отключений при перезагрузке
        ));
    }
// sqlite
    else {

        $db = new \PDO('sqlite:' . DR . dir_site . 'db.sqllite.sl3', null, null, array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));
        $db->exec('PRAGMA journal_mode = WAL;');
    }
} catch (\Exception $exc) {
    // echo $exc->getTraceAsString();
    // \f\pa($exc->getTraceAsString();
    \nyos\Msg::sendTelegramm('ошибка при подключении к бд: ' . $exc->getMessage(), null, 2);
}