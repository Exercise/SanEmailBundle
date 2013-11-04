<?php

namespace San\EmailBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EmailSendStatsAdmin extends Admin
{
    /**
     * @var string
     */
    protected $manager;

    /**
     * @param string $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    // Fields to be shown on create/edit forms
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('emailSend')
            ->add('attempted')
            ->add('delivered')
            ->add('opens')
            ->add('uniqueOpens')
            ->add('clicks')
            ->add('uniqueClicks')
            ->add('ctr', 'percent')
            ->add('tctr', 'percent')
            ->add('bounces')
            ->add('spamReport')
            ->add('repeatSpamReport')
            ->add('unsubscribes')
            ->add('repeatBounces')
            ->add('invalidEmail')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete')
            ->remove('edit')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('emailSend')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('emailSend')
            ->add('attempted')
            ->add('delivered')
            ->add('opens')
            ->add('uniqueOpens')
            ->add('clicks')
            ->add('uniqueClicks')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                )
            ))
        ;
    }
}

