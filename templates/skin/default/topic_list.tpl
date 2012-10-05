{if count($aTopics)>0}
    {foreach from=$aTopics item=oTopic}
            {assign var="oBlog" value=$oTopic->getBlog()}
            {assign var="oUser" value=$oTopic->getUser()}
            {assign var="oVote" value=$oTopic->getVote()}
            <div class="topic">
                <h1 class="title">
                {if !$bHideBlogName}<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>&rarr;{/if}
                {if $oTopic->getPublish()==0}
                    <img src="{cfg name='path.static.skin'}/images/topic_unpublish.gif" border="0" title="{$aLang.plugin.lsdigest.topic_unpublish}" width="16" height="16" alt="{$aLang.plugin.lsdigest.topic_unpublish}">
                {/if}
                <a href="{if $oTopic->getType()=='link'}{router page='link'}go/{$oTopic->getId()}/{else}{$oTopic->getUrl()}{/if}">{$oTopic->getTitle()|escape:'html'}</a>
                {if $oTopic->getType()=='link'}
                    <img src="{cfg name='path.static.skin'}/images/link_url_big.gif" border="0" title="{$aLang.plugin.lsdigest.topic_link}" width="16" height="16" alt="{$aLang.plugin.lsdigest.topic_link}">
                {/if}
            </h1>
            <div class="content">
                <a href="{$oTopic->getUrl()}" title="{$oTopic->getTitle()|escape:'html'}">
                    <img alt="{$oTopic->getTitle()|escape:'html'}" title="{$oTopic->getTitle()|escape:'html'}" src="{$oTopic->getTopicAvatarMarked()}" alt="">
                </a>
            </div>
    </div>
{/foreach}
{/if}