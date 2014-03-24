<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: LsDigest
 * @Plugin Id: lsdigest
 * @Plugin URI:
 * @Description:
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 1.0.1
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */

$config = array();

// Количество предыдущих дней, за которые произойдет рассылка
$config['MailingPeriod'] = 7;

// Рейтинг топиков
$config['RatingOfTopics'] = 0;

// Количество последних тем
$config['NumberOfMaterials'] = 10;

// Логин пользователя - отправителя
$config['SenderUserLogin'] = 'admin';

// Формат даты для темы письма
$config['DateFormat'] = 'd.m.Y';

return $config;