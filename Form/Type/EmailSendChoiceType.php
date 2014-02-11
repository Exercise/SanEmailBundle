<?php

namespace San\EmailBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EmailSendChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender')
            ->add('userLists')
            ->add('sendImmediately', 'checkbox', array(
                'mapped' => false,
                'label'     => 'Send immediately?',
                'required'  => false,
            ))
            ->add('sendDate', 'datetime', array(
                'required'    => false,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
            ))
            ->add('testEmails', 'san_emails')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'emailSendChoice';
    }
}