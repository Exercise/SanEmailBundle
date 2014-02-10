<?php

namespace San\EmailBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
    public function toString($object)
    {
        if (!is_object($object)) {
            return '';
        }

        if (method_exists($object, '__toString') && null !== $object->__toString()) {
            return (string) $object;
        }

        return 'Add new email send';
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sender')
            ->add('title')
            ->add('subject')
            ->add('userLists', null, array(
                'expanded' => false,
                'required' => false,
            ))
            ->add('isHtmlContent', 'checkbox', array(
                'required' => false
            ))
            ->add('sendDate', 'datetime', array(
                'required'    => false,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'date_format' => \IntlDateFormatter::SHORT,
            ))
            ->add('testEmails', 'san_emails')
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
            ->add('createSend', $this->getRouterIdParameter() . '/createSend')
            ->remove('create')
            ->remove('delete')
            ->remove('edit')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $dateType = 'san_orm_date';
        if ($this->manager != 'orm') {
            $dateType = 'san_mongodb_date';
        }

        $datagridMapper
            ->add('title')
            ->add('isHtmlContent')
            ->add('created', $dateType, array(), null, array(
                'label' => 'Created after'
            ))
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

    /**
     * {@inheritdoc}
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'SanEmailBundle:Admin/CRUD:email_send.html.twig';
            case 'list':
                return 'SanEmailBundle:Admin/CRUD:email_send_list.html.twig';
            default:
                return parent::getTemplate($name);
        }
    }
}
