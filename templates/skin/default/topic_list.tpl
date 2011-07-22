{if count($aTopics)>0}
    {foreach from=$aTopics item=oTopic}
        {assign var="oBlog" value=$oTopic->getBlog()}
        {assign var="oUser" value=$oTopic->getUser()}
        {assign var="oVote" value=$oTopic->getVote()}
        <div class="topic">
            <h1 class="title">
            {if !$bHideBlogName}<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>&rarr;{/if}
            {if $oTopic->getPublish()==0}
                <img src="{cfg name='path.static.skin'}/images/topic_unpublish.gif" border="0" title="{$aLang.topic_unpublish}" width="16" height="16" alt="{$aLang.topic_unpublish}">
            {/if}
            <a href="{if $oTopic->getType()=='link'}{router page='link'}go/{$oTopic->getId()}/{else}{$oTopic->getUrl()}{/if}">{$oTopic->getTitle()|escape:'html'}</a>
            {if $oTopic->getType()=='link'}
                <img src="{cfg name='path.static.skin'}/images/link_url_big.gif" border="0" title="{$aLang.topic_link}" width="16" height="16" alt="{$aLang.topic_link}">
            {/if}
        </h1>
        <div class="content">
            {if $oTopic->getType()=='question'}
                <div id="topic_question_area_{$oTopic->getId()}">
                    {if !$oTopic->getUserQuestionIsVote()}
                        <ul class="poll-new">
                            {foreach from=$oTopic->getQuestionAnswers() key=key item=aAnswer}
                                <li><label for="topic_answer_{$oTopic->getId()}_{$key}"><input type="radio" id="topic_answer_{$oTopic->getId()}_{$key}" name="topic_answer_{$oTopic->getId()}"  value="{$key}" onchange="$('topic_answer_{$oTopic->getId()}_value').setProperty('value',this.value);"/> {$aAnswer.text|escape:'html'}</label></li>
                                    {/foreach}
                            <li>
                                <input type="submit"  value="{$aLang.topic_question_vote}" onclick="ajaxQuestionVote({$oTopic->getId()},$('topic_answer_{$oTopic->getId()}_value').getProperty('value'));"/>
                                <input type="submit"  value="{$aLang.topic_question_abstain}"  onclick="ajaxQuestionVote({$oTopic->getId()},-1);"/>
                            </li>
                            <input type="hidden" id="topic_answer_{$oTopic->getId()}_value" value="-1">
                        </ul>
                        <span>{$aLang.topic_question_vote_result}: {$oTopic->getQuestionCountVote()}. {$aLang.topic_question_abstain_result}: {$oTopic->getQuestionCountVoteAbstain()}</span><br>
                    {else}
                        {include file='topic_question.tpl'}
                    {/if}
                </div>
                <br/>
            {/if}
            {$oTopic->getTextShort()}
            {if $oTopic->getTextShort()!=$oTopic->getText()}
                <br/>
                <br/>
                ( <a href="{$oTopic->getUrl()}" title="{$aLang.topic_read_more}">{if $oTopic->getCutText()}{$oTopic->getCutText()}{else}{$aLang.topic_read_more}{/if}
                </a> )
            {/if}
        </div>	
    </div>
{/foreach}	
{/if}