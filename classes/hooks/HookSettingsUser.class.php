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
class PluginLsdigest_HookSettingsUser extends Hook
{

    /**
     * Register Template Menu Hook
     *
     * @return void
     */
    public function RegisterHook()
    {
        $this->AddHook('template_form_settings_tuning_end', 'FormTuning', __CLASS__);
        $this->AddHook('module_user_update_after', 'UpdateTuning', __CLASS__);
    }

    public function FormTuning()
    {
        return $this->Viewer_Fetch(
                        Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionSettings/form_tuning.tpl');
    }

    public function UpdateTuning($aVars)
    {
        $oUser = $aVars['params'][0];
        if (isPost('submit_settings_tuning')) {
            $oUser->setUserSettingsNoticeDigestBestTopics(getRequest('user_settings_notice_digest_best_topics') ? 1 : 0 );
            $this->User_UpdateSubscriptionDigest($oUser);
        }
    }

}
