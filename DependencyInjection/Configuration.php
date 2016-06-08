<?php

namespace Simpleweb\SaaSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('simpleweb_saas');

        $this->addSubscriptionSection($rootNode);
        $this->addPlanSection($rootNode);

        $rootNode
            ->children()
                ->arrayNode('user')->isRequired()
                    ->children()
                        ->scalarNode('class')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addPlanSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('subscription')->isRequired()
                    ->children()
                        ->scalarNode('class')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
            ;
    }

    private function addSubscriptionSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('plan')->isRequired()
                    ->children()
                        ->scalarNode('class')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
