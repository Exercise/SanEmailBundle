<?php

namespace San\EmailBundle\Admin;

use San\EmailBundle\Admin\EmailSendStatsAdmin;
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
     * @var \San\EmailBundle\Admin\EmailSendStatsAdmin
     */
    protected $emailSendStatsAdmin;

    /**
     * @param string $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param EmailStatsAdmin $emailSendStatsAdmin
     */
    public function setEmailStatsAdmin(EmailSendStatsAdmin $emailSendStatsAdmin)
    {
        $this->emailSendStatsAdmin = $emailSendStatsAdmin;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUrl($name, array $parameters = array(), $absolute = false)
    {
        if ($name == 'stats') {
            return $this->emailSendStatsAdmin->generateUrl('show', $parameters);
        }

        return $this->routeGenerator->generateUrl($this, $name, $parameters, $absolute);
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
            ->add('_action', 'actions', array(
                'actions' => array(
                    'stats' => array('template' => 'SanEmailBundle:Admin/CRUD:list__action_stats.html.twig'),
                )
            ))
        ;
    }
}
