#!/usr/bin/env php
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
define('SYS_HACKER_CONSOLE', false);

$sDirRoot = dirname(realpath((dirname(__FILE__)) . "/../../../"));
set_include_path(get_include_path() . PATH_SEPARATOR . $sDirRoot);
chdir($sDirRoot);
require_once($sDirRoot . "/config/loader.php");
require_once($sDirRoot . "/engine/classes/Cron.class.php");

class CreateMailingDigest extends Cron
{

    public function Client() {

        $bReadyStatus = true;

        // Get active plugins
        $aActivePlugins = $this->oEngine->Plugin_GetActivePlugins();

        //  Checking plugin self status
        if (!in_array('lsdigest', $aActivePlugins)) {
            echo "LsDigest plugin doesn't enabled! Please enable its before running." . PHP_EOL;
            $bReadyStatus = false;
        }

        //  Checking Mailing plugin status
        if (!in_array('mailing', $aActivePlugins)) {
            echo "Mailing plugin doesn't enabled! Please enable its before running." . PHP_EOL;
            $bReadyStatus = false;
        }

        if ($bReadyStatus === false) {
            // The script isn't ready for launch
            return;
        }

        // Set current date and time
        $oCurrentTime = new DateTime();

        $sCurrentTime = $oCurrentTime->format('Y-m-d H:i:s');

        $sCurrentDate = $oCurrentTime->format(Config::Get('plugin.lsdigest.DateFormat'));

        $iPeriodInDays = (int) Config::Get('plugin.lsdigest.MailingPeriod');

        $oInterval = $oCurrentTime->sub(new DateInterval("P{$iPeriodInDays}D"));

        // Set start of  period date and time
        $sStartTime = $oInterval->format('Y-m-d 00:00:00');

        $sStartDate = $oInterval->format(Config::Get('plugin.lsdigest.DateFormat'));

        // Get current user (sender)
        $oUserSender = $this->oEngine->User_GetUserByLogin(Config::Get('plugin.lsdigest.SenderUserLogin'));

        if (!$oUserSender) {
            echo "Sender account doesn't exist. Check login name!" . PHP_EOL;
            return;
        }

        $this->oEngine->Viewer_VarAssign();

        //  Checking required plugin status
        $bL10nActive = in_array('l10n', $aActivePlugins);

        if ($bL10nActive) {
            // Get allowed languages
            $aLangs = array_keys($this->oEngine->PluginL10n_L10n_GetAllowedLangsAliases());

            // Disable getting lang from url
            Config::Set('plugin.l10n.lang_in_url', 1);
        } else {
            $aLangs = array(Config::Get('lang.default'));
        }

        foreach ($aLangs as $sLang) {

            // Set current lang
            if ($bL10nActive) {
                Config::Set('lang.current', $sLang);

                $this->oEngine->Lang_SetLang($sLang);
            }

            // Get all top topics for period
            $aTopics = $this->oEngine->Topic_GetTopicsRatingByDate($sStartTime, (int) Config::Get('plugin.lsdigest.NumberOfMaterials'));
            
            if (!count($aTopics)) {

                $sMessage = "No data for mailing";

                if ($bL10nActive) {
                    $sMessage .= " on {$sLang} language.";
                }

                echo $sMessage . PHP_EOL;

                continue;
            }

            $this->oEngine->Viewer_Assign('aTopics', $aTopics);

            // Create Mailing task
            $oMailing = new PluginMailing_ModuleMailing_EntityMailing();

            $oMailing->setMailingLang($bL10nActive ? array($sLang) : array());

            $oMailing->setSendByUserId($oUserSender->GetId());

            // Mail title
            $aValuesMap = array(
                /**
                 * Variables for custom subject
                 *
                 * - Лучшие топики с %%startDate по %%endDate%% -> Лучшие топики с 01.01.2011 по 07.01.2011
                 * - Дайджест материалов на %%endDate%% -> Дайджест материалов на 07.01.2011
                 */
                'startDate' => $sStartDate, //Start date
                'endDate' => $sCurrentDate, // Current date
            );

            $oMailing->setMailingTitle($this->oEngine->Lang_Get('plugin.lsdigest.plugin_lsdigest_mail_title', $aValuesMap));

            $sText = trim($this->oEngine->Viewer_Fetch(Plugin::GetTemplatePath('lsdigest') . 'topic_list.tpl'));

            $oMailing->setMailingText($sText);

            $oMailing->setMailingDate($sCurrentTime);

            $oMailing->setFilter(array());

            $oMailing->setMailingActive(true);
            
            $oMailing->setMailingTalk(false);

            if ($this->oEngine->PluginMailing_ModuleMailing_AddMailing($oMailing)) {

                $sMessage = "Mailing task ";
                if ($bL10nActive) {
                    $sMessage .= "for {$sLang} language ";
                }

                $sMessage .= "#{$oMailing->getMailingId()} created successfully at {$sCurrentTime}";

                echo $sMessage . PHP_EOL;
            } else {

                $sMessage = "No data available for a new mailing task";

                if ($bL10nActive) {
                    $sMessage .= " on {$sLang} language!";
                }

                echo $sMessage . PHP_EOL;
            }
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