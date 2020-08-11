<?php

ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки

date_default_timezone_set("Asia/Yekaterinburg");
define('IN_NYOS_PROJECT', true);

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

//\f\timer::start();
require( $_SERVER['DOCUMENT_ROOT'] . '/all/ajax.start.php' );


if (!is_dir(DR . DS . '0.temp')) {
    mkdir(DR . DS . '0.temp', 0755);
    echo DR . DS . '0.temp';
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_items' && isset($_REQUEST['module'])) {
    
    
    
}










die('exit');

//require_once( DR.'/vendor/didrive/base/class/Nyos.php' );
//require_once( dirname(__FILE__).'/../class.php' );
//if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'scan_new_datafile') {
//    scanNewData($db);
//    //cron_scan_new_datafile();
//}
// проверяем секрет
if (
        (
        isset($_REQUEST['id']{0}) && isset($_REQUEST['s']{5}) &&
        \Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['id']) === true
        ) || (
        isset($_REQUEST['id2']{0}) && isset($_REQUEST['s2']{5}) &&
        \Nyos\nyos::checkSecret($_REQUEST['s2'], $_REQUEST['id2']) === true
        )
) {
    
}
//
else {

    $e = '';

    foreach ($_REQUEST as $k => $v) {
        $e .= '<Br/>' . $k . ' - ' . $v;
    }

    f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору ' . $e // . $_REQUEST['id'] . ' && ' . $_REQUEST['secret']
            , 'error');
}


//require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/sql.start.php');
//require( $_SERVER['DOCUMENT_ROOT'] . '/0.site/0.cfg.start.php');
//require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'class' . DS . 'mysql.php' );
//require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'db.connector.php' );
//
// сохраняем измененеия и распространяем если нужно на другие дни недели
//
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_norms') {

    ob_start('ob_gzhandler');

    echo '<br/>для показа обновлённых значений <a href="" >обновите страницу</a><br/>';

    $now_month = ceil(date('m', strtotime($_REQUEST['date'])));

    // \f\pa($_REQUEST);

    $new_data = array(
        'vuruchka' => $_REQUEST['vuruchka'],
        'time_wait_norm_cold' => $_REQUEST['time_wait_norm_cold'],
        'time_wait_norm_hot' => $_REQUEST['time_wait_norm_hot'],
        'time_wait_norm_delivery' => $_REQUEST['time_wait_norm_delivery'],
        'procent_oplata_truda_on_oborota' => $_REQUEST['procent_oplata_truda_on_oborota'],
        'kolvo_hour_in1smena' => $_REQUEST['kolvo_hour_in1smena']
    );

    $last_day = date('t', strtotime($_REQUEST['date']));
    $year_month = substr($_REQUEST['date'], 0, 8);
    $save_day = [];

    for ($i = 1; $i <= $last_day; $i++) {

        $time = strtotime($year_month . $i);
        $dn = date('w', $time);

        if (isset($_REQUEST['copyto'][$dn])) {

            // день подходящий по дню недели если их выбирали
            // echo ' '.$dn.' ';
            $save_day[date('Y-m-d', $time)] = 1;
        }
    }

    // текущий день
    $save_day[$_REQUEST['date']] = 1;

    $for_sql = '';

    $norms = \Nyos\mod\items::getItemsSimple($db, 'sale_point_parametr');

    foreach ($norms['data'] as $k1 => $v1) {

        if (isset($v1['dop']['sale_point']) && $v1['dop']['sale_point'] == $_REQUEST['sp'] && isset($save_day[$v1['dop']['date']])) {

            $for_sql .= (!empty($for_sql) ? ' OR ' : '' ) . ' `id` = \'' . $v1['id'] . '\' ';
            // \Nyos\mod\items::deleteItems($db, $e, $module_name, $data_dops);
        }
    }

    $ocenki = \Nyos\mod\items::getItemsSimple($db, 'sp_ocenki_job_day');

    foreach ($ocenki['data'] as $k1 => $v1) {

        if (isset($v1['dop']['sale_point']) && $v1['dop']['sale_point'] == $_REQUEST['sp'] && isset($save_day[$v1['dop']['date']])) {

            $for_sql .= (!empty($for_sql) ? ' OR ' : '' ) . ' `id` = \'' . $v1['id'] . '\' ';
            // \Nyos\mod\items::deleteItems($db, $e, $module_name, $data_dops);
        }
    }

    if (!empty($for_sql)) {
        $sql = 'UPDATE `mitems` SET `status` = \'delete\' WHERE ( `module` = \'sale_point_parametr\' OR `module` = \'sp_ocenki_job_day\' ) AND ( ' . $for_sql . ' ) ';
        //\f\pa($sql);
        $ff = $db->prepare($sql);
        $ff->execute();
    }






    $indbs = [];

    echo 'Записали нормы по датам:';

    foreach ($save_day as $k => $v) {

        $in = $new_data;
        $in['date'] = $k;

        echo ' ' . $k;

        $in['sale_point'] = $_REQUEST['sp'];

        //$indbs[] = $in;
        // \f\pa($in);
        $e = \Nyos\mod\items::addNewSimple($db, 'sale_point_parametr', $in);
        // \f\pa($e);
    }

    //\f\pa($indbs);

    $r = ob_get_contents();
    ob_end_clean();

    \f\end2($r, true);
} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'calc_full_ocenka_day') {

    //echo '<br/>'. __FILE__.' '.__LINE__;

    try {

        $return = array(
            'txt' => '',
            // текст о времени исполнения
            'time' => '',
            // смен в дне
            'smen_in_day' => 0,
            // часов за день отработано
            'hours' => 0,
            // больше или меньше нормы сделано сегодня ( 1 - больше или равно // 0 - меньше // 2 не получилось достать )
            'oborot_bolee_norm' => 2,
            // сумма денег на руки от количества смен и процента на ФОТ
            'summa_na_ruki' => 0,
            // рекомендуемая оценка управляющего
            'ocenka' => 5
        );

        $return['date'] = date('Y-m-d', strtotime($_REQUEST['date']));
        $return['sp'] = $return['sale_point'] = $_REQUEST['sp'];

        // id items для записи авто оценки
        $id_items_for_new_ocenka = [];

        // require_once DR . '/all/ajax.start.php';
        // $ff = $db->prepare('UPDATE `mitems` SET `status` = \'hide\' WHERE `id` = :id ');
        // $ff->execute(array(':id' => (int) $_POST['id2']));


        /**
         * достаём чеки за день
         */
        if (1 == 1) {

            \f\timer::start();

            // $return['hours'] = \Nyos\mod\JobDesc::getTimesChecksDay($db, $sp, $e) getOborotSp($db, $return['sp'], $return['date']);
            $times_day = \Nyos\mod\JobDesc::getTimesChecksDay($db, $return['sp'], $return['date']);
            //\f\pa($times_day,2,'','$times_day');
            $return['hours'] = $times_day['hours'];
            $id_items_for_new_ocenka = $times_day['id_check_for_new_ocenka'];
            // die($return['hours']);

            $return['time'] .= PHP_EOL . ' достали время работы по чекам за день : ' . \f\timer::stop()
                    . PHP_EOL . $return['hours'];
        }

        //echo '<br/>'.__FILE__.' '.__LINE__;
//    $checki = \Nyos\mod\items::getItemsSimple($db, '050.chekin_checkout', 'show');
//    \f\pa($checki,2,'','$checki');

        if (!class_exists('Nyos\mod\JobDesc'))
            require_once DR . DS . 'vendor/didrive_mod/jobdesc/class.php';

        //echo '<br/>'.__FILE__.' '.__LINE__;

        /**
         * достаём нормы на день
         */
        if (1 == 1) {
            \f\timer::start();

            $now_norm = \Nyos\mod\JobDesc::whatNormToDay($db, $return['sp'], $return['date']);
            //\f\pa($now_norm,2,'','$now_norm '.$return['sp'].' / '.$return['date'] );

            if ($now_norm === false)
                throw new \Exception('Нет плановых данных (дата)', 12);

            foreach ($now_norm as $k => $v) {
                //$return['txt'] .= '<br/><nobr>[norm_' . $k . '] - ' . $v . '</nobr>';
                $return['norm_' . $k] = $v;
                //echo '<br>'.PHP_EOL.'$return[\'norm_' . $k.'] = '. $v;
            }

            $return['time'] .= PHP_EOL . ' нормы за день время: ' . \f\timer::stop();
            //\f\pa($return); die();

            if (empty($return['norm_date'])) {
                // $error .= PHP_EOL . 'Нет плановых данных (дата)';
                throw new \Exception('Нет плановых данных (дата)', 12);
            } elseif (empty($return['norm_vuruchka']) || empty($return['norm_time_wait_norm_cold']) || empty($return['norm_procent_oplata_truda_on_oborota']) || empty($return['norm_kolvo_hour_in1smena'])) {
                throw new \Exception('Не все плановые данные по ТП указаны', 13);
                //$error .= PHP_EOL . 'Не все плановые данные по ТП указаны';
            }
        }


        //echo '<br/>'.__FILE__.' '.__LINE__;
//    $salary = \Nyos\mod\JobDesc::configGetJobmansSmenas($db);
//    \f\pa($salary,2,'','$salary');
//    $return['txt'] .= '<br/>salary';
//    foreach ($salary as $k => $v) {
//        $return['txt'] .= '<br/><nobr>[' . $k . '] - ' . $v . '</nobr>';
//        $return['salary_' . $k] = $v;
//    }
//echo '<br/>'.__FILE__.' '.__LINE__;

        /**
         * достаём оборот за сегодня
         */
        if (1 == 1) {
            \f\timer::start();
            // $return['oborot'] = \Nyos\mod\JobDesc::getOborotSp($db, $_REQUEST['sp'], $_REQUEST['date']);
            $return['oborot'] = \Nyos\mod\IikoOborot::getDayOborot($db, $_REQUEST['sp'], $_REQUEST['date']);
            // \f\pa($return);

            $return['time'] .= PHP_EOL . ' достали обороты за день: ' . \f\timer::stop()
                    . PHP_EOL . $return['oborot'];
        }
//echo '<br/>'.__FILE__.' '.__LINE__;
        /**
         * достаём время ожидания за сегодня
         */
        if (1 == 1) {
            \f\timer::start();
            $timeo = \Nyos\mod\JobDesc::getTimeOgidanie($db, $_REQUEST['sp'], $_REQUEST['date']);
            //\f\pa($timeo);
            $return['time'] .= PHP_EOL . ' достали время ожидания за день: ' . \f\timer::stop();
            foreach ($timeo as $k => $v) {
                $return['time'] .= PHP_EOL . $k . ' > ' . $v;
                $return[$k] = $v;
            }
        }


//echo '<br/>'.__FILE__.' '.__LINE__;
        // \f\pa($return);
        // exit;
//\f\pa($return);
        // если есть ошибки
        if (!empty($error)) {

            require_once DR . dir_site . 'config.php';

            $sp = \Nyos\mod\items::getItemsSimple($db, 'sale_point', 'show');
            // \f\pa($sp);

            if (!isset($_REQUEST['no_send_msg'])) {
                $txt_to_tele = 'Обнаружены ошибки при расчёте оценки точки продаж (' . $sp['data'][$_REQUEST['sp']]['head'] . ') за день работы (' . $_REQUEST['date'] . ')' . PHP_EOL . PHP_EOL . $error;

                if (class_exists('\nyos\Msg'))
                    \nyos\Msg::sendTelegramm($txt_to_tele, null, 1);

                if (isset($vv['admin_ajax_job'])) {
                    foreach ($vv['admin_ajax_job'] as $k => $v) {
                        \nyos\Msg::sendTelegramm($txt_to_tele, $v);
                        //\Nyos\NyosMsg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, $k );
                    }
                }
            }
//echo '<br/>'.__FILE__.' '.__LINE__;

            return \f\end2('Обнаружены ошибки при расчёте оценки точки продаж (' . $_REQUEST['sp'] . ') за день работы (' . $_REQUEST['date'] . ')' . $error, false);
        }
        // если нет ошибок считаем
        else {

            \f\timer::start();

            /**
             * сравниваем время ожидания холодный цех
             */
            if (isset($return['timeo_cold']) && isset($return['norm_time_wait_norm_cold'])) {

                $return['txt'] .= '<br/><br/>-------------------';
                $return['txt'] .= '<br/>время ожидания (хол.цех)';
                $return['txt'] .= '<br/>по плану: ' . $return['norm_time_wait_norm_cold'] . ' и значение в ТП ' . $return['timeo_cold'];

                if (isset($return['timeo_cold']) && isset($return['norm_time_wait_norm_cold']) &&
                        $return['timeo_cold'] > $return['norm_time_wait_norm_cold']) {

                    $return['txt'] .= '<br/>не норм, оценка 3';
                    $return['ocenka_time'] = 3;
                    $return['ocenka'] = 3;
                } else {
                    $return['txt'] .= '<br/>норм, оценка 5';
                    $return['ocenka_time'] = 5;
                }
            } else {
                throw new \Exception('Вычисляем оценку дня, прервано, не хватает данных по времени ожидания', 14);
            }

            /**
             * сравниваем объём выручки
             */
            if (!empty($return['norm_vuruchka']) && !empty($return['oborot'])) {

                $return['txt'] .= '<br/><br/>-------------------';
                $return['txt'] .= '<br/>норма выручки';
                $return['txt'] .= '<br/>по плану: ' . $return['norm_vuruchka'] . ' и значение в ТП ' . $return['oborot'];

                if ($return['oborot'] >= $return['norm_vuruchka']) {
                    $return['oborot_bolee_norm'] = 1;
                    $return['ocenka_oborot'] = 5;
                    $return['txt'] .= '<br/>норм, оценка 5';
                } else {
                    $return['oborot_bolee_norm'] = 0;
                    $return['ocenka_oborot'] = 3;
                    $return['ocenka'] = 3;
                    $return['txt'] .= '<br/>не норм, оценка 3';
                }
            } else {
                throw new \Exception('Вычисляем оценку дня, прервано, не хватает данных по обороту за сутки', 18);
            }

            /**
             * считаем норму выручки на руки
             */
            if (!empty($return['norm_kolvo_hour_in1smena'])) {

                $return['txt'] .= '<br/><br/>-------------------';
                $return['txt'] .= '<br/>норма выручки (на руки)';

                $return['smen_in_day'] = round($return['hours'] / $return['norm_kolvo_hour_in1smena'], 1);
                $return['txt'] .= '<br/>Кол-во поваров: ' . $return['smen_in_day'];

                $return['on_hand_fakt'] = ceil($return['oborot'] / $return['smen_in_day']);
                $return['summa_na_ruki_norm'] = ceil($return['oborot'] / 100 * $return['norm_procent_oplata_truda_on_oborota']);

                $return['txt'] .= '<br/>по плану: ' . $return['summa_na_ruki_norm'] . ' и значение в ТП ' . $return['on_hand_fakt'];

                if ($return['on_hand_fakt'] < $return['summa_na_ruki_norm']) {
                    $return['ocenka'] = 3;
                    $return['ocenka_naruki'] = 3;
                    $return['ocenka'] = 3;
                    $return['txt'] .= '<br/>не норм, оценка 3';
                } else {
                    $return['ocenka_naruki'] = 5;
                    $return['txt'] .= '<br/>норм, оценка 5';
                }
            } else {
                throw new \Exception('Вычисляем оценку дня, прервано, не хватает значения по плану (норма на руки)', 19);
            }


            $return['txt'] .= '<br/>';
            $return['txt'] .= '<br/>';
            $return['txt'] .= '-----------';
            $return['txt'] .= '<br/>';
            $return['txt'] .= 'оценка дня : ' . $return['ocenka'];
            $return['txt'] .= '<br/>';
            $return['txt'] .= '<br/>';
            $return['txt'] .= '<br/>';

            // $return['ocenka_upr'] = $return['ocenka'];
//            $return['time'] .= PHP_EOL . ' считаем ходится не сходится : ' . \f\timer::stop();
//            $return['txt'] .= '<br/><nobr>рекомендуемая оценка упр: ' . $return['ocenka_upr'] . '</nobr>';


            /**
             * запись результатов в бд
             */
            if (1 == 1) {
                $sql_del = '';
                $sql_ar_new = [];

                foreach ($id_items_for_new_ocenka as $id_item => $v) {

                    $sql_del .= (!empty($sql_del) ? ' OR ' : '' ) . ' id_item = \'' . (int) $id_item . '\' ';
                    $sql_ar_new[] = array(
                        'id_item' => $id_item,
                        'name' => 'ocenka_auto',
                        'value' => $return['ocenka']
                    );
                }

                if (!empty($sql_del)) {
                    $ff = $db->prepare('DELETE FROM `mitems-dops` WHERE name = \'ocenka_auto\' AND ( ' . $sql_del . ' ) ');
                    $ff->execute();
                }

                \f\db\sql_insert_mnogo($db, 'mitems-dops', $sql_ar_new);
                $return['txt'] .= '<br/>записали автоценки сотрудникам';
            }

            require_once DR . dir_site . 'config.php';

            $sp = \Nyos\mod\items::getItemsSimple($db, 'sale_point', 'show');
            // \f\pa($sp);

            \Nyos\mod\items::addNewSimple($db, 'sp_ocenki_job_day', $return);

            if (!isset($_REQUEST['no_send_msg']) && !isset($_REQUEST['telega_no_send'])) {

                $txt_to_tele = 'Расчитали автооценку ( ' . $sp['data'][$_REQUEST['sp']]['head'] . ' ) за день работы (' . $_REQUEST['date'] . ')'
                        . PHP_EOL
                        . PHP_EOL
                        . str_replace('<br/>', PHP_EOL, $return['txt'])
//                        . PHP_EOL
//                        . '-----------------'
//                        . PHP_EOL
//                        . 'время выполнения вычислений'
//                        . PHP_EOL
//                        . $return['time']
                ;

                if (class_exists('\nyos\Msg'))
                    \nyos\Msg::sendTelegramm($txt_to_tele, null, 1);

                if (isset($vv['admin_ajax_job'])) {
                    foreach ($vv['admin_ajax_job'] as $k => $v) {
                        \nyos\Msg::sendTelegramm($txt_to_tele, $v);
                        //\Nyos\NyosMsg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, $k );
                    }
                }
            }

            \f\end2(
                    $return['txt']
                    . '<br/>часов: ' . $return['hours']
                    . '<br/>смен в дне: ' . $return['smen_in_day']
                    , true, $return);
        }

        //return \f\end2('Обнаружены ошибки: ' . $ex->getMessage() . ' <Br/>' . $text, false, array( 'error' => $ex->getMessage() ) );        
    }
    //
    catch (\Exception $ex) {

        if (!isset($_REQUEST['no_send_msg'])) {

            $text = $ex->getMessage()
                    . PHP_EOL
                    . PHP_EOL
                    . '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                    . PHP_EOL
                    . $ex->getMessage() . ' #' . $ex->getCode()
                    . PHP_EOL
                    . $ex->getFile() . ' #' . $ex->getLine()
                    . PHP_EOL
                    . $ex->getTraceAsString()
                    . '</pre>';

            if (class_exists('\nyos\Msg'))
                \nyos\Msg::sendTelegramm($text, null);
        }
        /*

          require_once DR . dir_site . 'config.php';

          $sp = \Nyos\mod\items::getItemsSimple($db, 'sale_point', 'show');
          // \f\pa($sp);

          $txt_to_tele = 'Обнаружены ошибки при расчёте оценки точки продаж (' . $sp['data'][$_REQUEST['sp']]['head'] . ') за день работы (' . $_REQUEST['date'] . ')' . PHP_EOL . PHP_EOL . $error;

          if (class_exists('\nyos\Msg'))
          \nyos\Msg::sendTelegramm($txt_to_tele, null, 1);

          if (isset($vv['admin_ajax_job'])) {
          foreach ($vv['admin_ajax_job'] as $k => $v) {
          \nyos\Msg::sendTelegramm($txt_to_tele, $v);
          //\Nyos\NyosMsg::sendTelegramm('Вход в управление ' . PHP_EOL . PHP_EOL . $e, $k );
          }
          }
         */
        return \f\end2('Обнаружены ошибки: ' . $ex->getMessage() . ' <Br/>' . $text, false, array('error' => $ex->getMessage(), 'code' => $ex->getCode()));
    }
}

//
elseif (isset($_POST['action']) && ( $_POST['action'] == 'delete_smena' || $_POST['action'] == 'delete_comment')) {

    // require_once DR . '/all/ajax.start.php';

    $ff = $db->prepare('UPDATE `mitems` SET `status` = \'hide\' WHERE `id` = :id ');
    $ff->execute(array(':id' => (int) $_POST['id2']));

    \f\end2('удалено');
}
//
elseif (isset($_POST['action']) && $_POST['action'] == 'recover_smena') {

    require_once DR . '/all/ajax.start.php';

    $ff = $db->prepare('UPDATE `mitems` SET `status` = \'show\' WHERE `id` = :id ');
    $ff->execute(array(':id' => (int) $_POST['id2']));

    \f\end2('смена восстановлена');
}
//
elseif (
        isset($_POST['action']) && (
        $_POST['action'] == 'add_new_smena' ||
        $_POST['action'] == 'add_comment' ||
        $_POST['action'] == 'confirm_smena' ||
        $_POST['action'] == 'goto_other_sp'
        )
) {
    // action=add_new_smena

    try {

        //require_once DR . '/all/ajax.start.php';
        // action=add_new_smena
        // \f\pa($_POST);
        // [date] => 2019-06-27
        // [toform_sp] => 2611
        // [action] => goto_other_sp
        // [id2] => 10    
        // [jobman] => 1886        
        /**
         * отправляем сотрудника на другую точку
         */
        if ($_POST['action'] == 'goto_other_sp') {

//            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//                require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
//
//            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php'))
//                require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php');
            // если старт часов меньше часов сдачи
            if (strtotime($_REQUEST['start_time']) > strtotime($_REQUEST['fin_time'])) {
                //$b .= '<br/>'.__LINE__;
                $start_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['start_time']);
                $fin_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['fin_time']) + 3600 * 24;
            }
            // если старт часов больше часов сдачи
            else {
                //$b .= '<br/>'.__LINE__;
                $start_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['start_time']);
                $fin_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['fin_time']);
            }

            \Nyos\mod\items::addNew($db, $vv['folder'], \Nyos\nyos::$menu['050.chekin_checkout'], array(
                'head' => rand(100, 100000),
                'jobman' => $_REQUEST['jobman'],
                'sale_point' => $_REQUEST['salepoint'],
                'start' => date('Y-m-d H:i', $start_time),
                'fin' => date('Y-m-d H:i', $fin_time)
            ));

            \f\end2('<div>'
                    . '<nobr><b class="warn" >смена добавлена</b>'
                    . '<br/>'
                    . date('d.m.y H:i', $start_time) . ' - ' . date('d.m.y H:i', $fin_time)
                    . '</nobr>'
                    . '</div>', true);
        }
        //
        elseif ($_POST['action'] == 'add_new_smena') {

//            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//                require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
//
//            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php'))
//                require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php');
            // если старт часов меньше часов сдачи
            if (strtotime($_REQUEST['start_time']) > strtotime($_REQUEST['fin_time'])) {
                //$b .= '<br/>'.__LINE__;
                $start_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['start_time']);
                $fin_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['fin_time']) + 3600 * 24;
            }
            // если старт часов больше часов сдачи
            else {
                //$b .= '<br/>'.__LINE__;
                $start_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['start_time']);
                $fin_time = strtotime($_REQUEST['date'] . ' ' . $_REQUEST['fin_time']);
            }

            $indb = array(
                'head' => rand(100, 100000),
                'jobman' => $_REQUEST['jobman'],
                'sale_point' => $_REQUEST['salepoint'],
                'start' => date('Y-m-d H:i', $start_time),
                'fin' => date('Y-m-d H:i', $fin_time),
                'hour_on_job_calc' => \Nyos\mod\IikoChecks::calculateHoursInRange($start_time, $fin_time),
                'who_add_item' => 'admin',
                'who_add_item_id' => $_SESSION['now_user_di']['id'] ?? '',
                'ocenka' => $_REQUEST['ocenka']
            );

            \Nyos\mod\items::addNew($db, $vv['folder'], \Nyos\nyos::$menu['050.chekin_checkout'], $indb);

            \f\end2('<div>'
                    . '<nobr><b class="warn" >смена добавлена</b>'
                    . '<br/>'
                    . date('d.m.y H:i', $start_time) . ' - ' . date('d.m.y H:i', $fin_time)
                    . '</nobr>'
                    . '</div>', true);
        } elseif ($_POST['action'] == 'add_comment') {

            $indb = $_REQUEST;

//array(
//                // 'head' => rand(100, 100000),
//                'jobman' => $_REQUEST['jobman'],
//                'sale_point' => $_REQUEST['salepoint'],
//                'start' => date('Y-m-d H:i', $start_time),
//                'fin' => date('Y-m-d H:i', $fin_time)
//            )
            //\f\pa( $indb );
            \Nyos\mod\items::addNew($db, $vv['folder'], \Nyos\nyos::$menu['073.comments'], $indb);

            \f\end2('<div style="background-color: gray; padding:5px;" >'
                    . '<b class="warn" >добавили комментарий</b>'
                    . '<br/>'
                    . $_REQUEST['comment']
                    . '</div>', true);
        }
        //
        elseif ($_POST['action'] == 'confirm_smena') {

//        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//            require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

            $ff = $db->prepare('DELETE FROM `mitems-dops` WHERE `id_item` = :id AND `name` = \'pay_check\' ;');
            $ff->execute(array(':id' => (int) $_POST['id2']));

            $ff = $db->prepare('INSERT INTO `mitems-dops` ( `id_item`, `name`, `value` ) values ( :id, \'pay_check\', \'yes\' ) ');
            $ff->execute(array(':id' => (int) $_POST['id2']));

            \f\end2('<div>'
                    . '<nobr>'
                    . '<b class="warn" >отправлено на оплату</b>'
                    . '</nobr>'
                    . '</div>', true);
        }
        //
        elseif ($_POST['action'] == 'edit_items_dop') {

//        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//            require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

            $ff = $db->prepare('DELETE FROM `mitems-dops` WHERE `id_item` = :id AND `name` = \'pay_check\' ;');
            $ff->execute(array(':id' => (int) $_POST['id2']));

            $ff = $db->prepare('INSERT INTO `mitems-dops` ( `id_item`, `name`, `value` ) values ( :id, \'pay_check\', \'yes\' ) ');
            $ff->execute(array(':id' => (int) $_POST['id2']));

            \f\end2('<div>'
                    . '<nobr>'
                    . '<b class="warn" >отправлено на оплату</b>'
                    . '</nobr>'
                    . '</div>', true);
        }
    }
    //
    catch (\Exception $ex) {

        $e = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        \f\end2($e, true);
    } catch (\PDOException $ex) {

        $e = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        \f\end2($e, true);
    }
}

//
elseif (isset($_POST['action']) && $_POST['action'] == 'add_new_minus') {
    // action=add_new_smena

    try {

//        require_once DR . '/all/ajax.start.php';
//
//        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//            require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
//
//        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php'))
//            require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php');

        \Nyos\mod\items::addNew($db, $vv['folder'], \Nyos\nyos::$menu['072.vzuscaniya'], array(
            // 'head' => rand(100, 100000),
            'date_now' => date('Y-m-d', strtotime($_REQUEST['date'])),
            'jobman' => $_REQUEST['jobman'],
            'sale_point' => $_REQUEST['salepoint'],
            'summa' => $_REQUEST['summa'],
            'text' => $_REQUEST['text']
        ));


//        if (date('Y-m-d', $start_time) == date('Y-m-d', $fin_time)) {
//            $dd = true;
//        } else {
//            $dd = false;
//        }
//        $r = ob_get_contents();
//        ob_end_clean();


        \f\end2('<div>'
                . '<nobr><b class="warn" >взыскание добавлено</b>'
                . '<br/>'
                . $_REQUEST['summa']
                . '<br/>'
                . '<small>' . $_REQUEST['text'] . '</small>'
//                . (
//                $dd === true ?
//                        '<br/>с ' . date('H:i', $start_time) . ' - ' . date('H:i', $fin_time) : '<br/>с ' . date('Y-m-d H:i:s', $start_time) . '<br/>по ' . date('Y-m-d H:i:s', $fin_time)
//                )
                // .'окей '.$b
//                . '</br>'
//                . $b
//                . '</br>'
//                . $r
                . '</nobr>'
                . '</div>', true);
    } catch (\Exception $ex) {

        $e = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        \f\end2($e, true);
    } catch (\PDOException $ex) {

        $e = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        \f\end2($e, true);
    }
}
//
elseif (isset($_POST['action']) && $_POST['action'] == 'add_new_plus') {
    // action=add_new_smena

    try {

        //require_once DR . '/all/ajax.start.php';
//        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//            require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
//
//        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php'))
//            require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php');

        \Nyos\mod\items::addNew($db, $vv['folder'], \Nyos\nyos::$menu['072.plus'], array(
            // 'head' => rand(100, 100000),
            'date_now' => date('Y-m-d', strtotime($_REQUEST['date'])),
            'jobman' => $_REQUEST['jobman'],
            'sale_point' => $_REQUEST['salepoint'],
            'summa' => $_REQUEST['summa'],
            'text' => $_REQUEST['text']
        ));


//        if (date('Y-m-d', $start_time) == date('Y-m-d', $fin_time)) {
//            $dd = true;
//        } else {
//            $dd = false;
//        }
//        $r = ob_get_contents();
//        ob_end_clean();


        \f\end2('<div>'
                . '<nobr><b class="warn" >премия добавлена'
                . '<br/>'
                . $_REQUEST['summa']
                . '<br/>'
                . '<small>' . $_REQUEST['text'] . '</small>'
                . '</b>'
//                . (
//                $dd === true ?
//                        '<br/>с ' . date('H:i', $start_time) . ' - ' . date('H:i', $fin_time) : '<br/>с ' . date('Y-m-d H:i:s', $start_time) . '<br/>по ' . date('Y-m-d H:i:s', $fin_time)
//                )
                // .'окей '.$b
//                . '</br>'
//                . $b
//                . '</br>'
//                . $r
                . '</nobr>'
                . '</div>', true);
    } catch (\Exception $ex) {

        $e = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        \f\end2($e, true);
    } catch (\PDOException $ex) {

        $e = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

        \f\end2($e, true);
    }
}
///
elseif (isset($_POST['action']) && $_POST['action'] == 'show_info_strings') {

//    require_once DR . '/all/ajax.start.php';
//
//    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
//        require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
//
//    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/all/exception.nyosex'))
//        require $_SERVER['DOCUMENT_ROOT'] . '/all/exception.nyosex';
    // require_once DR.'/vendor/didrive_mod/items/class.php';
    // \Nyos\mod\items::getItems( $db, $folder )
    // echo DR ;
    $loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/tpl.ajax/');

// инициализируем Twig
    $twig = new Twig_Environment($loader, array(
        'cache' => $_SERVER['DOCUMENT_ROOT'] . '/templates_c',
        'auto_reload' => true
            //'cache' => false,
            // 'debug' => true
    ));

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/all/twig.function.php'))
        require ($_SERVER['DOCUMENT_ROOT'] . '/all/twig.function.php');

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php'))
        require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/class.php');

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/1/twig.function.php'))
        require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive_mod/items/1/twig.function.php');

//    \Nyos\Mod\Items::getItems($db, $folder, $module, $stat, $limit);

    $vv['get'] = $_GET;

    $ttwig = $twig->loadTemplate('show_table.htm');
    echo $ttwig->render($vv);

    $r = ob_get_contents();
    ob_end_clean();

    // die($r);


    \f\end2('окей', true, array('data' => $r));
}

f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору', 'error');

exit;
