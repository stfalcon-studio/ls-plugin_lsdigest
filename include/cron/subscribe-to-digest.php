#!/usr/bin/env php
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
define('SYS_HACKER_CONSOLE', false);

$sDirRoot = dirname(realpath((dirname(__FILE__)) . "/../../../"));
set_include_path(get_include_path() . PATH_SEPARATOR . $sDirRoot);
chdir($sDirRoot);
require_once($sDirRoot . "/config/loader.php");
require_once($sDirRoot . "/engine/classes/Cron.class.php");

class SubscribeDigest extends Cron
{
    public function Client()
    {
        $aFilter = array();
        //Get count of all users
        $iPage = 1;
        $aResult = $this->oEngine->User_GetUsersByFilter($aFilter, array(), $iPage, 1);
        $iCountAll = $aResult['count'];
        $iPerPage = 100;

        while ((($iPage - 1) * $iPerPage) < $iCountAll) {
            $aResult = $this->oEngine->User_GetUsersByFilter($aFilter, array(), $iPage, $iPerPage);

            foreach ($aResult['collection'] as $oUser) {
                $oUser->addSubscribe(Config::Get('plugin.lsdigest.DigestSubscribeName'));
                $this->oEngine->User_Update($oUser);
            }
            $iPage++;
        }
    }
}

$sLockFilePath = Config::Get('sys.cache.dir') . 'lsdigest.lock';
/**
 * Создаем объект крон-процесса,
 * передавая параметром путь к лок-файлу
 */
$app = new SubscribeDigest($sLockFilePath);
print $app->Exec();