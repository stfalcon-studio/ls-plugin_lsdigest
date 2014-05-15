<?php

class PluginLsdigest_HookLsdigest extends Hook
{

    /**
     * Register Template Menu Hook
     *
     * @return void
     */
    public function RegisterHook()
    {
        $this->AddHook('template_form_settings_tuning_end', 'FormTuning', __CLASS__);
        $this->AddHook('settings_tuning_save_before', 'actionTuningSave', __CLASS__);
    }

    public function FormTuning()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionSettings/form_tuning.tpl');
    }

    public function actionTuningSave($aData)
    {
        $oUser = $aData['oUser'];

        if (getRequest('settings_notice_digest', false)) {
            $oUser->addSubscribe(Config::Get('plugin.lsdigest.DigestSubscribeName'));
        } else {
            $oUser->removeSubscribe(Config::Get('plugin.lsdigest.DigestSubscribeName'));
        }
    }
}