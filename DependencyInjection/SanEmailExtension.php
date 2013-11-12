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
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter(sprintf("%s.manager", $this->getAlias()), $config['manager']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin.xml');
        $loader->load('form.xml');
        $loader->load('services.xml');

        $manager = $container->getParameter('san_email.manager');
        $taggedServices = $container->findTaggedServiceIds('san.admin');

        foreach ($taggedServices as $id => $attributes) {
            // Set manager
            $adminClass = $container->getDefinition($id);
            $adminClassTag = $adminClass->getTag('sonata.admin');
            $adminClassTag[0]['manager_type'] = $manager;
            $adminClass->setTags(array('sonata.admin' => $adminClassTag));

            // Set model
            if ($manager != 'orm') {
                $model = $adminClass->getArgument(1);
                $adminClass->replaceArgument(1, str_replace('Entity', 'Document', $model));
            }

            $adminClass->addMethodCall('setManager', array($manager));
        }

        if ($manager == 'orm') {
            $container->removeDefinition('san_email.sender.doctrine_mongodb');
        } else {
            $container->removeDefinition('san_email.sender.orm');
        }

        $senderClass = $container->getDefinition(sprintf('san_email.sender.%s', $manager));
        $senderClass->setTags(array(
            'kernel.event_listener' => array(
                0 => array(
                    'event'  => 'kernel.terminate',
                    'method' => 'onKernelTerminate',
                )
            ))
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'san_email';
    }
}
