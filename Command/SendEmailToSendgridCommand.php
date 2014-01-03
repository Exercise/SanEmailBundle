<?php

namespace San\EmailBundle\Command;

use Guzzle\Common\Event;
use Guzzle\Http\Exception\ClientErrorResponseException;
use San\EmailBundle\Model\EmailSend;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendEmailToSendgridCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('san:email_send_to_sendgrid')
             ->setDescription('Adds lists to marketing emails and schedules emails');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailsSend = $this->getEmailSendRepository()->findWithoutList()->snapshot();
        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, $emailsSend->count());
        $this->getMarketing()->getEventDispatcher()->addListener('request.error', function(Event $event) {
            if ($event['response']->getStatusCode() != 200) {
                $event->stopPropagation();
            }
        });

        foreach ($emailsSend as $emailSend) {
            $response = $this->addListToEmail($emailSend)->json();
            if (array_key_exists('error', $response)) {
                continue;
            }

            $this->scheduleEmail($emailSend);
            $emailSend->setHasList(true);
            $this->getOm()->flush();
            $progress->advance();
        }

        $progress->finish();
    }

    /**
     * @return \San\EmailBundle\Repository\EmailSendRepository
     */
    protected function getEmailSendRepository()
    {
        return $this->getOm()->getRepository("SanEmailBundle:EmailSend");
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getOm()
    {
        if ($this->getContainer()->get('san.admin.email')->getManager() == 'orm') {
            return $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        return $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * @param EmailSend $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function addListToEmail(EmailSend $emailSend)
    {
        return $this->getMarketing()->addRecipientsToEmail(array(
            'list' => $emailSend->getSendgridListName(),
            'name' => $emailSend->getSendgridEmailName(),
        ));
    }

    /**
     * @param  EmailSend $emailSend
     * @return \Guzzle\Http\Message\Response
     */
    protected function scheduleEmail(EmailSend $emailSend)
    {
        $parameters = array(
            'name' => $emailSend->getSendgridEmailName()
        );

        if ($emailSend->getSendDate()) {
            $parameters['at'] = $emailSend->getSendDate()->format('Y-m-d h:i:s');
        }

        return $this->getMarketing()->scheduleEmail($parameters);
    }

    /**
     * @return \Exercise\Marketing\MarketingClient
     */
    protected function getMarketing()
    {
        return $this->getContainer()->get('exercise.sendgrid')->get('marketing');
    }
}
