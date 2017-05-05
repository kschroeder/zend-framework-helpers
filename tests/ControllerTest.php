<?php

namespace Magium\Zend\Helper\Tests;

use Magium\Configuration\Config\Repository\ConfigurationRepository;
use Magium\Zend\Helper\Controller\Configuration;
use PHPUnit\Framework\TestCase;
use Zend\Mvc\Controller\AbstractActionController;

class ControllerTest extends TestCase
{

    public function testControllerValue()
    {
        $controller = $this->getMockBuilder(AbstractActionController::class)->setMethods(null)->getMock();
        /** @var $controller AbstractActionController */
        $controller->getPluginManager()->configure([
            'aliases'   => [
                'configuration' => Configuration::class
            ],
            'invokables' => [
                Configuration::class,
                ConfigurationRepository::class
            ],
        ]);
        $controller->getPluginManager()->get('configuration')->setConfigurationRepository($this->getConfigurationRepository());
        $title = $controller->configuration()->getValue('general/website/title');
        self::assertEquals('Title', $title);
        self::assertTrue($controller->configuration()->getValueFlag('general/website/showHeader'));
        self::assertFalse($controller->configuration()->getValueFlag('general/website/showFooter'));
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
