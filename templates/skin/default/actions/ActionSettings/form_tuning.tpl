<label for="settings_notice_digest">
    <input {if $oUserCurrent->isSubscribe('digest')}checked{/if} type="checkbox" id="settings_notice_digest" name="settings_notice_digest" value="1" class="input-checkbox" />
    {$aLang.plugin.lsdigest.settings_tuning_notice_digest}
</label>