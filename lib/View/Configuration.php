<?php

namespace Magium\Zend\Helper\View;

use Magium\Configuration\Config\ConfigurationRepositoryAware;
use Magium\Configuration\Config\Repository\ConfigInterface;
use Zend\View\Helper\AbstractHelper;

class Configuration extends AbstractHelper implements ConfigurationRepositoryAware
{

    private $repository;

    public function __construct(ConfigInterface $config = null)
    {
        $this->repository = $config;
    }

    public function setConfigurationRepository(ConfigInterface $config)
    {
        $this->repository = $config;
    }

    /**
     * @return ConfigInterface
     */

    public function __invoke()
    {
        return $this->repository;
    }

}
