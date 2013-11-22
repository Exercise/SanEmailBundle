<?php

namespace San\EmailBundle\Admin;

use Exercise\Sendgrid\Common\Sendgrid;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EmailIdentityAdmin extends Admin
{
    /**
     * @var \Exercise\Sendgrid\Marketing\MarketingClient
     */
    protected $marketing;

    /**
     * @var string
     */
    protected $manager;

    /**
     * @param Sendgrid $sendgrid
     */
    public function setSendgrid(Sendgrid $sendgrid)
    {
        $this->marketing = $sendgrid->get('marketing');
    }

    /**
     * @param string $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        if (!is_object($object)) {
            return '';
        }

        if (method_exists($object, '__toString') && null !== $object->__toString()) {
            return (string) $object;
        }

        return 'Add email identity';
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($object)
    {
        $this->marketing->addIdentity(array(
            'identity' => $object->getDescription(),
            'name'     => $object->getFromName(),
            'email'    => $object->getFromEmail(),
            'replyto'  => $object->getReplyToEmail(),
            'address'  => $object->getAddress(),
            'city'     => $object->getCity(),
            'state'    => $object->getState(),
            'zip'      => $object->getZip(),
            'country'  => $object->getCountry(),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($object)
    {
        $this->marketing->editIdentity(array(
            'identity' => $object->getDescription(),
            'name'     => $object->getFromName(),
            'email'    => $object->getFromEmail(),
            'replyto'  => $object->getReplyToEmail(),
            'address'  => $object->getAddress(),
            'city'     => $object->getCity(),
            'state'    => $object->getState(),
            'zip'      => $object->getZip(),
            'country'  => $object->getCountry(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('delete')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('description')
            ->add('fromName')
            ->add('fromEmail', 'email')
            ->add('replyToEmail', 'email')
            ->add('address')
            ->add('city')
            ->add('state', 'text', array(
                'required' => false
            ))
            ->add('zip', 'text', array(
                'required' => false
            ))
            ->add('country', 'country')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('description')
            ->add('fromName')
            ->add('fromEmail')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('description')
            ->add('fromName')
            ->add('fromEmail')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit'   => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}
