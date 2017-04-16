<?php
declare(strict_types=1);
namespace VirCom\Behat3ZendFramework3Extension\Services;

use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class ZendFramework3Initializer
{
    /**
     * @var string
     */
    protected $configurationFilePath;

    /**
     * @param string $configurationFilePath
     */
    public function __construct(
        string $configurationFilePath
    ) {
        $this->configurationFilePath = $configurationFilePath;
    }

    /**
     * @return \Zend\Mvc\ApplicationInterface
     */
    public function boot(): ApplicationInterface
    {
        $configuration = require $this->configurationFilePath;

        $serviceManagerConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : [];
        $serviceManagerConfig = new ServiceManagerConfig($serviceManagerConfig);

        $serviceManager = new ServiceManager();
        $serviceManagerConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $configuration);

        $serviceManager->get('ModuleManager')->loadModules();
        $listenersFromAppConfig     = isset($configuration['listeners']) ? $configuration['listeners'] : [];
        $config                     = $serviceManager->get('config');
        $listenersFromConfigService = isset($config['listeners']) ? $config['listeners'] : [];

        $listeners = array_unique(
            array_merge(
                $listenersFromConfigService,
                $listenersFromAppConfig
            )
        );

        return $serviceManager->get('Application')
            ->bootstrap($listeners);
    }
}
