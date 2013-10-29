<?php

namespace San\EmailBundle;

use Doctrine\Common\Persistence\ObjectManager;
use Exercise\Sendgrid\Common\Sendgrid;
use San\EmailBundle\Model\Email;
use San\EmailBundle\Model\EmailSend;
use San\UserListBundle\Admin\UserDynamicListAdmin;
use San\UserListBundle\Model\UserStaticListInterface;
use San\UserListBundle\Model\UserDynamicListInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class Sender
{
    /**
     * @var \Exercose\Sendgrid\Marketing\MarketingClient
     */
    protected  $marketing;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @var \San\UserListBundle\Admin\UserDynamicListAdmin
     */
    protected $userDynamicListAdmin;

    /**
     * @param Sendgrid $sendgrid
     */
    public function __construct(Sendgrid $sendgrid, ObjectManager $om, UserDynamicListAdmin $userDynamicListAdmin)
    {
        $this->marketing = $sendgrid->get('marketing');
        $this->om = $om;
        $this->userDynamicListAdmin = $userDynamicListAdmin;
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
        foreach ($emailSend->getUserLists() as $userList) {
            if ($userList instanceof UserStaticListInterface) {
                $staticListUsers = $this->getUserStaticListRepository()->getEmailsByList($userList);
                foreach ($staticListUsers as $value) {
                    $receivers[$value['email']] = $value['username'];
                }
            } elseif ($userList instanceof UserDynamicListInterface) {
                $userDynamicListUsers = $this->userDynamicListAdmin->getUsers($userList);
                foreach ($userDynamicListUsers as $value) {
                    $receivers[$value->getEmail()] = $value->getUsername();
                }
            }
        }

        $batches = (int) (count($receivers) / 1000) + 1;
        for ($i = 0; $i < $batches; $i++) {
            $this->addEmailsToList($emailSend, array_slice($receivers, $i * 1000, 1000));
        }

        $this->createEmail($emailSend);
        $this->addListToEmail($emailSend);
        $this->scheduleEmail($emailSend);
        $emailSend
            ->setIsProcessing(false)
            ->setHasProcessed(true)
        ;
        $this->om->flush($emailSend);

        return true;
    }

    /**
     * @param  EmailSend $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function scheduleEmail(EmailSend $emailSend)
    {
        $parameters = array(
            'name' => $this->getSendgridEmailName($emailSend)
        );

        if ($emailSend->getSendDate()) {
            $parameters['at'] = $emailSend->getSendDate()->format('Y-m-d h:i:s');
        }

        return $this->marketing->scheduleEmail($parameters);
    }

    /**
     * @param EmailSend $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function addListToEmail(EmailSend $emailSend)
    {
        return $this->marketing->addRecipientsToEmail(array(
            'list' => $this->getSendgridListName($emailSend),
            'name' => $this->getSendgridEmailName($emailSend),
        ));
    }

    /**
     * @param  EmailSend  $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function createEmail(EmailSend $emailSend)
    {
        return $this->marketing->addEmail(array(
            'identity' => $emailSend->getEmail()->getSender(),
            'name'     => $this->getSendgridEmailName($emailSend),
            'subject'  => $emailSend->getEmail()->getSubject(),
            'text'     => $emailSend->getEmail()->getText(),
            'html'     => $emailSend->getEmail()->getHtml(),
        ));
    }

    /**
     * @param  EmailSend $email
     * @return \Guzzle\Http\Message\Response
     */
    protected function createList(EmailSend $emailSend)
    {
        return $this->marketing->addList(array(
            'list' => $this->getSendgridListName($emailSend)
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
            'list' => $this->getSendgridListName($emailSend),
            'data' => $preparedEmails,
        ));
    }

    /**
     * @param  EmailSend $emailSend
     * @return string
     */
    protected function getSendgridListName(EmailSend $emailSend)
    {
        return sprintf("[%s] %s", $emailSend->getCreated()->format('d/m/Y h:i'), $emailSend->getEmail()->getTitle());
    }

    /**
     * @param  EmailSend  $emailSend
     * @return string
     */
    protected function getSendgridEmailName(EmailSend $emailSend)
    {
        return sprintf("[%s] %s", $emailSend->getCreated()->format('d/m/Y h:i'), $emailSend->getEmail()->getSubject());
    }

    /**
     * @return \San\EmailBundle\Entity\EmailSendRepository|\San\EmailBundle\Document\EmailSendRepository
     */
    protected function getEmailSendRepository()
    {
        return $this->om->getRepository('SanEmailBundle:EmailSend');
    }

    /**
     * @return \San\UserBundle\Entity\UserStaticListRepository|\San\UserBundle\Document\UserStaticListRepository
     */
    protected function getUserStaticListRepository()
    {
        return $this->om->getRepository('SanUserListBundle:UserStaticList');
    }
}
