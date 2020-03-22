<?php

declare(strict_types=1);

namespace ApplicationTest\Controller;

use Application\Controller\NewsController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class NewsControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp() : void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/news', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(NewsController::class);
        $this->assertControllerClass('NewsController');
        $this->assertMatchedRouteName('news');
    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/news', 'GET');
        $selector = '.jumbotron .zf-green';
        $this->assertQuery($selector);
        $this->assertQueryCount($selector, 1);
        $this->assertQueryContentContains($selector, 'Articles');
        //xpath
        $this->assertXpathQuery("//h1[@class='zf-green']");
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
