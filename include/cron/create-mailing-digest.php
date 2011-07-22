#!/usr/bin/env php
<?php
/* ---------------------------------------------------------------------------
 * @Plugin Name: LsDigest
 * @Plugin Id: LsDigest
 * @Plugin URI:
 * @Description:
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */
define('SYS_HACKER_CONSOLE', false);

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$sDirRoot = dirname(realpath((dirname(__FILE__)) . "/../../../"));
set_include_path(get_include_path() . PATH_SEPARATOR . $sDirRoot);
chdir($sDirRoot);
require_once($sDirRoot . "/config/loader.php");
require_once($sDirRoot . "/engine/classes/Cron.class.php");

class CreateMailingDigest extends Cron
{

    public function Client()
    {


        // Set current date and time
        $oCurrentTime = new DateTime();

        $sCurrentTime = $oCurrentTime->format('Y-m-d H:i:s');

        $sCurrentDate = $oCurrentTime->format(Config::Get('plugin.lsdigest.DateFormat'));

        $iPeriodInDays = (int) Config::Get('plugin.lsdigest.MailingPeriod');

        $oInterval = $oCurrentTime->sub(new DateInterval("P{$iPeriodInDays}D"));


        // Set start of  period date and time
        $sStartTime = $oInterval->format('Y-m-d 00:00:00');

        $sStartDate = $oInterval->format(Config::Get('plugin.lsdigest.DateFormat'));

        // Get all top topics for period
        $aTopics = $this->oEngine->Topic_GetTopicsRatingByDate($sStartTime, (int) Config::Get('plugin.lsdigest.NumberOfMaterials'));

        if (!count($aTopics)) {
            echo "No data for mailing." . PHP_EOL;
            return;
        }

        // Get current user (sender)
        $oUserSender = $this->oEngine->User_GetUserByLogin(Config::Get('plugin.lsdigest.SenderUserLogin'));

        if (!$oUserSender) {
            echo "Sender account doesn't exist. Check login name!" . PHP_EOL;
            return;
        }


        $this->oEngine->Viewer_VarAssign();

        $this->oEngine->Viewer_Assign('aTopics', $aTopics);

        // Create Mailing task
        $oMailing = new PluginMailing_ModuleMailing_EntityMailing();

        $oMailing->setSendByUserId($oUserSender->GetId());

        // Mail title
        $sTitle = strtr($this->oEngine->Lang_Get('plugin_lsdigest_mail_title'), array(
		/**
		 * Variables for custom subject
		 *
		 * - Лучшие топики с %%startDate по %%endDate%% -> Лучшие топики с 01.01.2011 по 07.01.2011
		 * - Дайджест материалов на %%endDate%% -> Дайджест материалов на 07.01.2011
		 */
		'%%startDate%%' => $sStartDate, //Start date
		'%%endDate%%' => $sCurrentDate, // Current date
	    )
        );
        $oMailing->setMailingTitle($sTitle);

        $sText = trim($this->oEngine->Viewer_Fetch(Plugin::GetTemplatePath('lsdigest') . 'topic_list.tpl'));
        $oMailing->setMailingText($sText);

        //  $oMailing->setMailingCount($iUsersCount);
        $oMailing->setMailingLang((array) Config::Get('plugin.lsdigest.MailingLanguages'));

        $oMailing->setMailingDate($sCurrentTime);

        if ($this->oEngine->PluginMailing_ModuleMailing_AddMailing($oMailing)) {
            echo "Mailing task #{$oMailing->getMailingId()} created successfully at {$sCurrentTime}" . PHP_EOL;
        } else {
            echo "No data available for a new mailing task!" . PHP_EOL;
        }
    }

}

$sLockFilePath = Config::Get('sys.cache.dir') . 'lsdigest.lock';
/**
 * Создаем объект крон-процесса,
 * передавая параметром путь к лок-файлу
 */
$app = new CreateMailingDigest($sLockFilePath);
print $app->Exec();
?>