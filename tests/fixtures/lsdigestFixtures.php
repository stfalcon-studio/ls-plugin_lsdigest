<?php

$sDirRoot = dirname(realpath((dirname(__DIR__)) . "/../../"));
set_include_path(get_include_path().PATH_SEPARATOR.$sDirRoot);

require_once($sDirRoot . "/tests/AbstractFixtures.php");


class lsdigestFixtures extends AbstractFixtures
{
    public function load()
    {
        $sDateBefore = date('Y-m-d', time() - 60*60*24);

        $oTopic = $this->getReference('topic-ipad');
        $oTopic->setDateAdd($sDateBefore);
        $this->oEngine->Topic_AddTopic($oTopic);
    }
}

