{if count($aTopics)>0}
    {foreach from=$aTopics item=oTopic}
        {assign var="oBlog" value=$oTopic->getBlog()}
        {assign var="oUser" value=$oTopic->getUser()}
        {assign var="oVote" value=$oTopic->getVote()}
        <div class="topic">
            <h1 class="title">
                {if !$bHideBlogName}<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>&rarr;{/if}
                {if $oTopic->getType()=='link'}
                    <div class="topic-url">
                        <a href="{router page='link'}go/{$oTopic->getId()}/" title="{$aLang.topic_link_count_jump}: {$oTopic->getLinkCountJump()}">{$oTopic->getLinkUrl()}</a>
                    </div>
                    <img src="{cfg name='path.static.skin'}/images/link_url_big.gif" border="0" title="{$aLang.topic_link}" width="16" height="16" alt="{$aLang.topic_link}">
                {else}
                    <a href="{if $oTopic->getType()=='link'}{router page='link'}go/{$oTopic->getId()}/{else}{$oTopic->getUrl()}{/if}">{$oTopic->getTitle()|escape:'html'}</a>
                {/if}
            </h1>
            <div class="content">
                {if $oTopic->getType()=='question'}
                    <div id="topic_question_area_{$oTopic->getId()}" class="poll">
                        {if !$oTopic->getUserQuestionIsVote()}
                            <ul class="poll-vote">
                                {foreach from=$oTopic->getQuestionAnswers() key=key item=aAnswer}
                                    <li><label><input type="radio" id="topic_answer_{$oTopic->getId()}_{$key}" name="topic_answer_{$oTopic->getId()}" value="{$key}" /> {$aAnswer.text|escape:'html'}</label></li>
                                {/foreach}
                            </ul>
                        {else}
                            {include file='topic_question.tpl'}
                        {/if}
                    </div>
                    <br/>
                {/if}
                <div class="topic-content text">
                {$oTopic->getTextShort()}
                {if $oTopic->getTextShort()!=$oTopic->getText()}
                    <br/>
                    <br/>
                    ( <a href="{$oTopic->getUrl()}" title="{$aLang.topic_read_more}">{if $oTopic->getCutText()}{$oTopic->getCutText()}{else}{$aLang.topic_read_more}{/if}</a> )
                {/if}
                </div>
            </div>
        </div>
    {/foreach}
{/if}