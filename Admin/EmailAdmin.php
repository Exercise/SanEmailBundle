<?php

namespace San\EmailBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EmailAdmin extends Admin
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

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('subject')
            ->add('text', 'textarea', array(
                'attr' => array(
                    'class' => 'preview span5',
                    'rows'  => '8'
                )
            ))
            ->add('html', 'textarea', array(
                'attr' => array(
                    'class' => 'preview span5',
                    'rows'  => '8'
                )
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('subject')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate($name)
    {
        if ($name == 'edit') {
            return 'SanEmailBundle:Admin/CRUD:email_edit.html.twig';
        }

        return parent::getTemplate($name);
    }

    /**
     * {@inheritDoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('send', 'send/{id}', array(
                '_controller' => 'SanEmailBundle:Admin/EmailCRUD:send'
            ), array(
                'id' => '\w+'
            ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('subject')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit'   => array(),
                    'delete' => array(),
                    'send'   => array('template' => 'SanEmailBundle:Admin/CRUD:list__action_send.html.twig'),
                )
            ))
        ;
    }
}
