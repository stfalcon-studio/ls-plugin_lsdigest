<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\MinkExtension\Context\MinkContext,
    Behat\Mink\Exception\ExpectationException,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

$sDirRoot = dirname(realpath((dirname(__FILE__)) . "/../../../../../"));
set_include_path(get_include_path().PATH_SEPARATOR.$sDirRoot);

require_once("tests/behat/features/bootstrap/BaseFeatureContext.php");

/**
 * LiveStreet custom feature context
 */
class FeatureContext extends MinkContext
{
    protected $sDirRoot;

    public function __construct(array $parameters)
    {
        $this->sDirRoot = dirname(realpath((dirname(__FILE__)) . "/../../../../../"));
        $this->parameters = $parameters;
        $this->useContext('base', new BaseFeatureContext($parameters));
    }

    public function getEngine() {
        return $this->getSubcontext('base')->getEngine();
    }

    /**
     * @Then /^run send message script$/
     */
    public function runSendMessageScript()
    {
        if (!file_exists("{$this->sDirRoot}/plugins/lsdigest/include/cron/create-mailing-digest.php")) {
            throw new ExpectationException('Script file not found', $this->getSession());
        }

        $response = shell_exec("{$this->sDirRoot}/plugins/lsdigest/include/cron/create-mailing-digest.php");

        var_dump($response);

        if (!preg_match('/Mailing task #[0-9]+ created successfully/', $response)) {
            throw new ExpectationException('Messages not send (invalid script response)', $this->getSession());
        }
    }
}





