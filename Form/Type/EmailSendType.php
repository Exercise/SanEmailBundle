<?php

namespace San\EmailBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailSendType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender')
            ->add('userLists')
            ->add('isHtmlContent', 'checkbox', array(
                'required' => false
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
        return 'emailSend';
    }
}
