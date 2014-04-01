<label for="user_settings_notice_digest_best_topics">
    <input {if $oUserCurrent->getUserSettingsNoticeDigestBestTopics()}checked{/if} type="checkbox" id="user_settings_notice_digest_best_topics" name="user_settings_notice_digest_best_topics" value="1" class="input-checkbox" />
    {$aLang.plugin.lsdigest.lsdigest_receive_digest_best_topic}
</label>
