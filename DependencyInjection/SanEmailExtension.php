<?php

namespace San\EmailBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SanEmailExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // $config = $this->processConfiguration(new Configuration(), $configs);
        // $container->setParameter(sprintf("%s.manager", $this->getAlias()), $config['manager']);
        // $container->setParameter(sprintf("%s.user_class", $this->getAlias()), $config['user_class']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // $loader->load('form.xml');
        $loader->load('admin.xml');
        // $loader->load('services.xml');

        // $manager = $container->getParameter('san_user_list.manager');
        // $taggedServices = $container->findTaggedServiceIds('san.admin');

        // foreach ($taggedServices as $id => $attributes) {
        //     // Set manager
        //     $adminClass = $container->getDefinition($id);
        //     $adminClassTag = $adminClass->getTag('sonata.admin');
        //     $adminClassTag[0]['manager_type'] = $manager;
        //     $adminClass->setTags(array('sonata.admin' => $adminClassTag));

        //     // Set model
        //     if ($manager != 'orm') {
        //         $model = $adminClass->getArgument(1);
        //         $adminClass->replaceArgument(1, str_replace('Entity', 'Document', $model));
        //     }

        //     $adminClass->addMethodCall('setManager', array($manager));
        // }
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'san_email';
    }
}
