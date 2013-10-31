<?php

namespace San\EmailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('san_email');
        $rootNode
            ->children()
                ->enumNode('manager')
                    ->values(array('orm', 'doctrine_mongodb'))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
