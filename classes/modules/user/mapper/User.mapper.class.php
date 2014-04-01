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
class PluginLsdigest_ModuleUser_MapperUser extends PluginLsdigest_Inherit_ModuleUser_MapperUser
{

    public function UpdateSubscriptionDigest($oUser)
    {
        $sql = "UPDATE
                    " . Config::Get('db.table.user') . "
                SET
                    user_settings_notice_digest_best_topics = ?d
                WHERE
                    user_id = ?d
                ";
        return $this->oDb->query($sql, $oUser->getSettingsNoticeDigestBestTopics(), $oUser->getId());
    }
}

