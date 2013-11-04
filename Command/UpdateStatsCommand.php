<?php

namespace San\EmailBundle\Command;

use Goutte\Client;
use San\EmailBundle\Entity\EmailSendStats as EmailSendStatsEntity;
use San\EmailBundle\Document\EmailSendStats as EmailSendStatsDocument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateStatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('san:email_send_stats')
             ->setDescription('Update emails stats');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://sendgrid.com/newsletter');
        $form = $crawler->selectButton('Login')->form();
        $crawler = $client->submit($form, array(
            'login[username]' => $this->getContainer()->getParameter('exercise.sendgrid.api_user'),
            'login[password]' => $this->getContainer()->getParameter('exercise.sendgrid.api_key'),
        ));

        $emails = $this->getEmailSendRepository()->findAll();
        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, count($emails));
        foreach ($emails as $emailSend) {
            $response = $this->getContainer()->get('exercise.sendgrid')->get('marketing')->getEmail(array(
                'name' => $emailSend->getSendgridEmailName()
            ))->json();
            $statsFileLink = sprintf("http://sendgrid.com/newsletter/downloadExcelNewsletterStats/id/%u", $response['newsletter_id']);
            $client->request('GET', $statsFileLink);
            $tempFilePath = sprintf("%s/%s.xls", sys_get_temp_dir(), $response['newsletter_id']);
            $tempFile = fopen($tempFilePath, 'wb');
            fwrite($tempFile, $client->getResponse()->getContent());
            fclose($tempFile);

            $phpExcel = \PHPExcel_IOFactory::load($tempFilePath);
            if (!($emailSendStats = $emailSend->getStats())) {
                $emailSendStats = $this->createEmailSendStats();
                $emailSendStats->setEmailSend($emailSend);
                $this->getOm()->persist($emailSendStats);
            }

            foreach (array(
                "B2" => 'attempted',
                "C2" => 'delivered',
                "D2" => 'opens',
                "E2" => 'uniqueOpens',
                "F2" => 'clicks',
                "G2" => 'uniqueClicks',
                "H2" => 'ctr',
                "I2" => 'tctr',
                "J2" => 'bounces',
                "K2" => 'spamReport',
                "L2" => 'repeatSpamReport',
                "M2" => 'unsubscribes',
                "N2" => 'repeatBounces',
                "O2" => 'invalidEmail',
            ) as $position => $method) {
                $value = str_replace('%', '', $phpExcel->getActiveSheet()->getCell($position)->getValue());
                $emailSendStats->{sprintf("set%s", $method)}($value);
            }
            unlink($tempFilePath);
            $progress->advance();
        }

        $this->getOm()->flush();
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
        if ($this->getContainer()->get('san.admin.email_send_stats')->getManager() == 'orm') {
            return $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        return $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * @return \San\EmailBundle\Model\EmailSendStats
     */
    protected function createEmailSendStats()
    {
        if ($this->getContainer()->get('san.admin.email_send_stats')->getManager() == 'orm') {
            return new EmailSendStatsEntity();
        }

        return new EmailSendStatsDocument();
    }
}
