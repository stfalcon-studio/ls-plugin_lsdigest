<?php

/**
 * Модуль Topic плагина PluginLsdiges
 */
class PluginLsdigest_ModuleTopic extends PluginLsdiges_Inherit_ModuleTopic {

    /**
     * Получает топики по рейтингу и дате
     *
     * @param string $sDate	Дата
     * @param int $iLimit	Количество
     * @param int $iRating	Рейтинг топиков
     * @return array
     */
    public function GetTopicsByRatingAndDate($sDate,$iLimit=20,$iRating=0) {
        /**
         * Получаем список блогов, топики которых нужно исключить из выдачи
         */
        $aCloseBlogs = ($this->oUserCurrent)
            ? $this->Blog_GetInaccessibleBlogsByUser($this->oUserCurrent)
            : $this->Blog_GetInaccessibleBlogsByUser();

        $s=serialize($aCloseBlogs);

        if (false === ($data = $this->Cache_Get("topic_date_rating_{$sDate}_{$iRating}_{$iLimit}_{$s}"))) {
            $data = $this->oMapperTopic->GetTopicsByRatingAndDate($sDate,$iLimit,$iRating,$aCloseBlogs);
            $this->Cache_Set($data, "topic_date_rating_{$sDate}_{$iRating}_{$iLimit}_{$s}", array('topic_update'), 60*60*24*2);
        }
        $data=$this->GetTopicsAdditionalData($data);
        return $data;
    }
}
