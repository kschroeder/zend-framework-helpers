<?php

namespace Magium\Zend\Helper\Tests;

use Magium\Configuration\Config\Repository\ConfigurationRepository;
use Magium\Zend\Helper\View\Configuration;
use PHPUnit\Framework\TestCase;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplatePathStack;

class ViewTest extends TestCase
{

    public function testValueHelper()
    {
        $renderer = $this->configureRenderer();

        $helper = new Configuration($this->getConfigurationRepository());
        $helper->setView($renderer);
        $renderer->getHelperPluginManager()->setService('configuration', $helper);

        $content = $renderer->render('view.helper.phtml');
        $simpleXml = new \SimpleXMLElement($content);
        self::assertEquals('Title', (string)$simpleXml->head->title);
    }

    public function testFlagHelper()
    {
        $renderer = $this->configureRenderer();

        $helper = new Configuration($this->getConfigurationRepository());
        $helper->setView($renderer);
        $renderer->getHelperPluginManager()->setService('configuration', $helper);

        $content = $renderer->render('view.flag.phtml');
        $simpleXml = new \SimpleXMLElement($content);
        self::assertCount(1, $simpleXml->xpath('//header'));
        self::assertCount(0, $simpleXml->xpath('//footer'));
    }

    protected function configureRenderer()
    {
        $renderer = new PhpRenderer();
        $renderer->setResolver(new TemplatePathStack(['script_paths' => [__DIR__ . '/scripts/']]));
        return $renderer;
    }

    protected function getConfigurationRepository()
    {
        return new ConfigurationRepository(
            <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<config>
    <general>
        <website>
            <title>Title</title>
            <showHeader>1</showHeader>
            <showFooter>0</showFooter>
        </website>
    </general>
</config>
XML

        );
    }

}
