<?php

/**
 * @property DbSimple_Generic_Database $oDb
 */
class PluginLsdigest_ModuleTopic_MapperTopic extends PluginLsdigest_Inherit_ModuleTopic_MapperTopic
{
    /**
     * Получает топики по рейтингу и дате
     *
     * @param string $sDate	Дата
     * @param int $iLimit	Количество
     * @param int $iRating	Рейтинг топиков
     * @param array $aExcludeBlog	Список ID блогов для исключения
     * @return array
     */
    public function GetTopicsByRatingAndDate($sDate,$iLimit,$iRating=0,$aExcludeBlog=array()) {
        $sql = "SELECT
						t.topic_id
					FROM
						".Config::Get('db.table.topic')." as t
					WHERE
						t.topic_publish = 1
						AND
						t.topic_date_add >= ?
						AND
						t.topic_rating >= ?d
						{ AND t.blog_id NOT IN(?a) }
					ORDER by t.topic_rating desc, t.topic_id desc
					LIMIT 0, ?d ";
        $aTopics=array();
        if ($aRows=$this->oDb->select(
            $sql,$sDate,$iRating,
            (is_array($aExcludeBlog)&&count($aExcludeBlog)) ? $aExcludeBlog : DBSIMPLE_SKIP,
            $iLimit
        )
        ) {
            foreach ($aRows as $aTopic) {
                $aTopics[]=$aTopic['topic_id'];
            }
        }
        return $aTopics;
    }
}
