<?php

namespace San\EmailBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EmailSendAdmin extends Admin
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

    /**
     * {@inheritdoc}
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('sender')
            ->add('userLists')
            ->add('isHtmlContent')
            ->add('sendDate')
            ->add('created')
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

    /**
     * {@inheritdoc}
     */
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
            ->add('title')
            ->add('subject')
            ->add('sender')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('sender')
            ->add('userLists')
            ->add('isHtmlContent')
            ->add('sendDate')
            ->add('created')
            ->add('attempted')
            ->add('delivered')
            ->add('opens')
            ->add('clicks')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array()
                )
            ))
        ;
    }
}
