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
class PluginLsdigest_ModuleUser extends PluginLsdigest_Inherit_ModuleUser
{
    /**
     * Mapper for PluginLsdigest_ModuleUsers
     * @var ModuleUser_MapperUser
     */

    public function UpdateSubscriptionDigest($oUser)
    {
        return $this->oMapper->UpdateSubscriptionDigest($oUser);
    }

}
