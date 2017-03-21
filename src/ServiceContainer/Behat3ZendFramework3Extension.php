<?php

namespace VirCom\Behat3ZendFramework3Extension\ServiceContainer;

use VirCom\Behat3ZendFramework3Extension\ServiceContainer\ZendFramework3Booter;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Zend\Mvc\Application;

class Behat3ZendFramework3Extension implements Extension
{
    const SERVICE_CONTAINER_NAME = "behat3_zendframework3_extension";
    
    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder) {
        $builder
            ->children()
                ->scalarNode("configuration_path")
                    ->defaultValue("%paths.base%/config/application.config.php")
                    ->end()
                ->end()
            ->end()
        ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey(): string {
        return self::SERVICE_CONTAINER_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $application = $this->loadZendFramework3(
            $basePath,
            $configurationFilePath
        );
        
        
        /*$config["configuration_path"] = str_replace(
            "%paths.base%",
            getcwd(),
            $config["configuration_path"]
        );
        
        $application = Application::init(require $config["configuration_path"]);
        $container->set("test", $application->getServiceManager());*/
    }

    
    protected function loadZendFramework3(
        string $basePath,
        string $configurationFilePath
    ): Application {
        $application = new ZendFramework3Booter(
            $basePath,
            $configurationFilePath
        );
        
        return $application;
    }
    
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        
    }
}
