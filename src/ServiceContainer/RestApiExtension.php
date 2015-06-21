<?php
namespace Behat\RestApiExtension\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
/**
 * Web API extension for Behat.
 */
class RestApiExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'rest_api';
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
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('base_url')
                    ->defaultValue('http://localhost')
                    ->end()
                ->end()
            ->end();
    }
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadContextInitializer($container, $config);
    }
    /**
     * @param ContainerBuilder $container
     * @param array $config
     * @return void
     */
    private function loadContextInitializer(ContainerBuilder $container, array $config)
    {
        $definition = new Definition(
            'Behat\RestApiExtension\Context\Initializer\RestApiAwareInitializer',
            array(
                $config,
            )
        );
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
        $container->setDefinition('rest_api.context_initializer', $definition);
    }
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }
}
