<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: LsDigest
 * @Plugin Id: lsdigest
 * @Plugin URI:
 * @Description:
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */

$config = array();

// Количество предыдущих дней, за которые произойдет рассылка
$config['MailingPeriod'] = 7;

// Количество последних тем
$config['NumberOfMaterials'] = 10;

// Логин пользователя - отправителя
$config['SenderUserLogin'] = 'admin';

// Формат даты для темы письма
$config['DateFormat'] = 'd.m.Y';

return $config;