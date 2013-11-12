<?php

namespace San\EmailBundle;

use Doctrine\Common\Persistence\ObjectManager;
use Exercise\Sendgrid\Common\Sendgrid;
use San\EmailBundle\Model\Email;
use San\EmailBundle\Model\EmailSend;
use San\UserListBundle\Admin\UserListAdmin;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class Sender
{
    /**
     * @var \Exercose\Sendgrid\Marketing\MarketingClient
     */
    protected $marketing;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @var \San\UserListBundle\Admin\UserListAdmin
     */
    protected $userListAdmin;

    /**
     * @param Sendgrid $sendgrid
     */
    public function __construct(Sendgrid $sendgrid, ObjectManager $om, UserListAdmin $userListAdmin)
    {
        $this->marketing = $sendgrid->get('marketing');
        $this->om = $om;
        $this->userListAdmin = $userListAdmin;
    }

    /**
     * @param  PostResponseEvent $event
     * @return boolean
     */
    public function onKernelTerminate(PostResponseEvent $event)
    {
        $emailSend = $this->getEmailSendRepository()->findOldestNonProcessed();
        if (!$emailSend) {
            return;
        }

        $listCreated = $this->createList($emailSend);
        if (!$listCreated->isSuccessful()) {
            return false;
        }

        $emailSend->setIsProcessing(true);
        $this->om->flush($emailSend);

        $receivers = array();
        if ($emailSend->getIsTest()) {
            $receivers = array_combine($emailSend->getTestEmails(), $emailSend->getTestEmails());
        } else {
            foreach ($emailSend->getUserLists() as $userList) {
                $listUsers = $this->userListAdmin->getUsers($userList);
                foreach ($listUsers as $value) {
                    $receivers[$value->getEmail()] = $value->getUsername();
                }
            }
        }

        $batches = (int) (count($receivers) / 1000) + 1;
        for ($i = 0; $i < $batches; $i++) {
            $this->addEmailsToList($emailSend, array_slice($receivers, $i * 1000, 1000));
        }

        $this->createEmail($emailSend);
        $emailSend
            ->setIsProcessing(false)
            ->setHasProcessed(true)
        ;
        $this->om->flush($emailSend);

        return true;
    }

    /**
     * @param  EmailSend  $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function createEmail(EmailSend $emailSend)
    {
        $parameters = array(
            'identity' => $emailSend->getSender()->getDescription(),
            'name'     => $emailSend->getSendgridEmailName(),
            'subject'  => $emailSend->getSubject(),
            'text'     => $emailSend->getText(),
        );

        if ($emailSend->getIsHtmlContent()) {
            $parameters['html'] = $emailSend->getEmail()->getHtml();
        }

        return $this->marketing->addEmail($parameters);
    }

    /**
     * @param  EmailSend $email
     * @return \Guzzle\Http\Message\Response
     */
    protected function createList(EmailSend $emailSend)
    {
        return $this->marketing->addList(array(
            'list' => $emailSend->getSendgridListName()
        ));
    }

    /**
     * @param EmailSend $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function addEmailsToList(EmailSend $emailSend, array $emails)
    {
        $preparedEmails = array();
        foreach ($emails as $email => $name) {
            $preparedEmails[] = json_encode(array('email' => $email, 'name' => $name));
        }

        return $this->marketing->addEmailsToList(array(
            'list' => $emailSend->getSendgridListName(),
            'data' => $preparedEmails,
        ));
    }

    /**
     * @return \San\EmailBundle\Entity\EmailSendRepository|\San\EmailBundle\Document\EmailSendRepository
     */
    protected function getEmailSendRepository()
    {
        return $this->om->getRepository('SanEmailBundle:EmailSend');
    }
}
