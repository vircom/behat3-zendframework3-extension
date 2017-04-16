<?php
declare(strict_types=1);
namespace VirCom\Behat3ZendFramework3Extension\ServiceContainer;

use VirCom\Behat3ZendFramework3Extension\Services\ZendFramework3Initializer;
use VirCom\Behat3ZendFramework3Extension\Context\Initializer\KernelAwareInitializer;
use VirCom\Behat3ZendFramework3Extension\Context\Argument\ArgumentResolver;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

use Zend\Mvc\ApplicationInterface;

class Behat3ZendFramework3Extension implements
    Extension
{
    const SERVICE_CONTAINER_NAME = "behat3_zendframework3_extension";
    const APPLICATION_CONTAINER_NAME = "zendframework3.application";
    const ARGUMENT_RESOLVER_CONTAINER_NAME = "zendframework3.argument_resolver";

    const BASE_PATH_PARAMETER_NAME = "paths.base";

    const CONFIGURATION_PATH_ARGUMENT_NAME = "configuration_path";
    const CONFIGURATION_PATH_DEFAULT_ARGUMENT_VALUE = "/config/application.config.php";

    /**
     * {@inheritdoc}
     */
    public function configure(
        ArrayNodeDefinition $builder
    ) {
        $builder
            ->children()
                ->scalarNode(self::CONFIGURATION_PATH_ARGUMENT_NAME)
                    ->info("Zend Framework 3 configuration file path")
                    ->defaultValue(self::CONFIGURATION_PATH_DEFAULT_ARGUMENT_VALUE)
                    ->end()
                ->end()
            ->end()
        ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey(): string
    {
        return self::SERVICE_CONTAINER_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(
        ExtensionManager $extensionManager
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function load(
        ContainerBuilder $container,
        array $config
    ) {
        $this->loadInitializer($container, $config);
        $this->loadArgumentResolver($container);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     * @return void
     */
    protected function loadInitializer(
        ContainerBuilder $container,
        array $config
    ) {
        $configurationFilePath = $this->mergeConfigurationFilePath(
            $container->getParameter(self::BASE_PATH_PARAMETER_NAME),
            $config[self::CONFIGURATION_PATH_ARGUMENT_NAME]
        );

        $application = (new ZendFramework3Initializer($configurationFilePath))->boot();
        $container->set(self::APPLICATION_CONTAINER_NAME, $application);
    }

    /**
     * @param string $basePath
     * @param string $configurationFilePath
     * @return string
     */
    protected function mergeConfigurationFilePath(
        string $basePath,
        string $configurationFilePath
    ): string {
        return $basePath . $configurationFilePath;
    }

    /**
     * @param ContainerBuilder $container
     * @return void
     */
    protected function loadArgumentResolver(
        ContainerBuilder $container
    ) {
        $definition = new Definition(
            ArgumentResolver::class,
            [
                $container->get(self::APPLICATION_CONTAINER_NAME),
            ]
        );

        $definition->addTag(ContextExtension::ARGUMENT_RESOLVER_TAG, ['priority' => 0]);
        $container->setDefinition(self::ARGUMENT_RESOLVER_CONTAINER_NAME, $definition);
    }

    /**
     * {@inheritdoc}
     */
    public function process(
        ContainerBuilder $container
    ) {
    }
}
