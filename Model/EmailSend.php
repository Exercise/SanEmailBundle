<?php

namespace San\EmailBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use San\EmailBundle\Model\Email;
use San\UserListBundle\Model\UserList;

class EmailSend
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $userLists;

    /**
     * @var boolean
     */
    protected $isHtmlContent;

    /**
     * @var \DateTime
     */
    protected $sendDate;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var boolean
     */
    protected $hasProcessed = false;

    /**
     * @var boolean
     */
    protected $isProcessing = false;

    /**
     * @var boolean
     */
    protected $hasList = false;

    /**
     * @var array
     */
    protected $testEmails = array();

    /**
     * @var boolean
     */
    protected $isTest;

    /**
     * Stats property
     * @var integer
     */
    protected $attempted;

    /**
     * Stats property
     * @var integer
     */
    protected $delivered;

    /**
     * Stats property
     * @var integer
     */
    protected $opens;

    /**
     * Stats property
     * @var integer
     */
    protected $uniqueOpens;

    /**
     * Stats property
     * @var integer
     */
    protected $clicks;

    /**
     * Stats property
     * @var integer
     */
    protected $uniqueClicks;

    /**
     * Stats property
     * @var float
     */
    protected $ctr;

    /**
     * Stats property
     * @var float
     */
    protected $tctr;

    /**
     * Stats property
     * @var integer
     */
    protected $bounces;

    /**
     * Stats property
     * @var integer
     */
    protected $spamReport;

    /**
     * Stats property
     * @var integer
     */
    protected $repeatSpamReport;

    /**
     * Stats property
     * @var integer
     */
    protected $unsubscribes;

    /**
     * Stats property
     * @var integer
     */
    protected $repeatBounces;

    /**
     * Stats property
     * @var integer
     */
    protected $invalidEmail;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->userLists = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Email
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Email
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set html
     *
     * @param string $html
     * @return Email
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set sender
     *
     * @param string $sender
     * @return Email
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Add userLists
     *
     * @param \San\UserListBundle\Entity\UserList $userLists
     * @return Email
     */
    public function addUserList(UserList $userLists)
    {
        $this->userLists[] = $userLists;

        return $this;
    }

    /**
     * Remove userLists
     *
     * @param \San\UserListBundle\Entity\UserList $userLists
     */
    public function removeUserList(UserList $userLists)
    {
        $this->userLists->removeElement($userLists);
    }

    /**
     * Get userLists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserLists()
    {
        return $this->userLists;
    }

    /**
     * Set isHtmlContent
     *
     * @param boolean $isHtmlContent
     * @return SendEmail
     */
    public function setIsHtmlContent($isHtmlContent)
    {
        $this->isHtmlContent = $isHtmlContent;

        return $this;
    }

    /**
     * Get isHtmlContent
     *
     * @return boolean
     */
    public function getIsHtmlContent()
    {
        return $this->isHtmlContent;
    }

    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     * @return SendEmail
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * Get sendDate
     *
     * @return \DateTime
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set hasProcessed
     *
     * @param boolean $hasProcessed
     * @return EmailSend
     */
    public function setHasProcessed($hasProcessed)
    {
        $this->hasProcessed = $hasProcessed;

        return $this;
    }

    /**
     * Get hasProcessed
     *
     * @return boolean
     */
    public function getHasProcessed()
    {
        return $this->hasProcessed;
    }

    /**
     * Set isProcessing
     *
     * @param boolean $isProcessing
     * @return EmailSend
     */
    public function setIsProcessing($isProcessing)
    {
        $this->isProcessing = $isProcessing;

        return $this;
    }

    /**
     * Get isProcessing
     *
     * @return boolean
     */
    public function getIsProcessing()
    {
        return $this->isProcessing;
    }

    /**
     * @return string
     */
    public function getSendgridEmailName()
    {
        return sprintf("[%s] %s", $this->getCreated()->format('d/m/Y h:i:s'), $this->getSubject());
    }

    /**
     * @return string
     */
    public function getSendgridListName()
    {
        return sprintf("[%s] %s", $this->getCreated()->format('d/m/Y h:i:s'), $this->getTitle());
    }

    /**
     * Set hasList
     *
     * @param boolean $hasList
     * @return EmailSend
     */
    public function setHasList($hasList)
    {
        $this->hasList = $hasList;

        return $this;
    }

    /**
     * Get hasList
     *
     * @return boolean
     */
    public function getHasList()
    {
        return $this->hasList;
    }

    /**
     * Set testEmails
     *
     * @param array $testEmails
     * @return EmailSend
     */
    public function setTestEmails(array $testEmails)
    {
        $this->testEmails = $testEmails;

        return $this;
    }

    /**
     * Get testEmails
     *
     * @return array
     */
    public function getTestEmails()
    {
        return $this->testEmails;
    }

    /**
     * Set isTest
     *
     * @param boolean $isTest
     * @return EmailSend
     */
    public function setIsTest($isTest)
    {
        $this->isTest = $isTest;

        return $this;
    }

    /**
     * Get isTest
     *
     * @return boolean
     */
    public function getIsTest()
    {
        return $this->isTest;
    }

    /**
     * Set attempted
     *
     * @param integer $attempted
     * @return EmailSendStats
     */
    public function setAttempted($attempted)
    {
        $this->attempted = $attempted;

        return $this;
    }

    /**
     * Get attempted
     *
     * @return integer
     */
    public function getAttempted()
    {
        return $this->attempted;
    }

    /**
     * Set delivered
     *
     * @param integer $delivered
     * @return EmailSendStats
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * Get delivered
     *
     * @return integer
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set opens
     *
     * @param integer $opens
     * @return EmailSendStats
     */
    public function setOpens($opens)
    {
        $this->opens = $opens;

        return $this;
    }

    /**
     * Get opens
     *
     * @return integer
     */
    public function getOpens()
    {
        return $this->opens;
    }

    /**
     * Set uniqueOpens
     *
     * @param integer $uniqueOpens
     * @return EmailSendStats
     */
    public function setUniqueOpens($uniqueOpens)
    {
        $this->uniqueOpens = $uniqueOpens;

        return $this;
    }

    /**
     * Get uniqueOpens
     *
     * @return integer
     */
    public function getUniqueOpens()
    {
        return $this->uniqueOpens;
    }

    /**
     * Set clicks
     *
     * @param integer $clicks
     * @return EmailSendStats
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;

        return $this;
    }

    /**
     * Get clicks
     *
     * @return integer
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Set uniqueClicks
     *
     * @param integer $uniqueClicks
     * @return EmailSendStats
     */
    public function setUniqueClicks($uniqueClicks)
    {
        $this->uniqueClicks = $uniqueClicks;

        return $this;
    }

    /**
     * Get uniqueClicks
     *
     * @return integer
     */
    public function getUniqueClicks()
    {
        return $this->uniqueClicks;
    }

    /**
     * Set ctr
     *
     * @param float $ctr
     * @return EmailSendStats
     */
    public function setCtr($ctr)
    {
        $this->ctr = $ctr;

        return $this;
    }

    /**
     * Get ctr
     *
     * @return float
     */
    public function getCtr()
    {
        return $this->ctr;
    }

    /**
     * Set tctr
     *
     * @param float $tctr
     * @return EmailSendStats
     */
    public function setTctr($tctr)
    {
        $this->tctr = $tctr;

        return $this;
    }

    /**
     * Get tctr
     *
     * @return float
     */
    public function getTctr()
    {
        return $this->tctr;
    }

    /**
     * Set bounces
     *
     * @param integer $bounces
     * @return EmailSendStats
     */
    public function setBounces($bounces)
    {
        $this->bounces = $bounces;

        return $this;
    }

    /**
     * Get bounces
     *
     * @return integer
     */
    public function getBounces()
    {
        return $this->bounces;
    }

    /**
     * Set spamReport
     *
     * @param integer $spamReport
     * @return EmailSendStats
     */
    public function setSpamReport($spamReport)
    {
        $this->spamReport = $spamReport;

        return $this;
    }

    /**
     * Get spamReport
     *
     * @return integer
     */
    public function getSpamReport()
    {
        return $this->spamReport;
    }

    /**
     * Set repeatSpamReport
     *
     * @param integer $repeatSpamReport
     * @return EmailSendStats
     */
    public function setRepeatSpamReport($repeatSpamReport)
    {
        $this->repeatSpamReport = $repeatSpamReport;

        return $this;
    }

    /**
     * Get repeatSpamReport
     *
     * @return integer
     */
    public function getRepeatSpamReport()
    {
        return $this->repeatSpamReport;
    }

    /**
     * Set unsubscribes
     *
     * @param integer $unsubscribes
     * @return EmailSendStats
     */
    public function setUnsubscribes($unsubscribes)
    {
        $this->unsubscribes = $unsubscribes;

        return $this;
    }

    /**
     * Get unsubscribes
     *
     * @return integer
     */
    public function getUnsubscribes()
    {
        return $this->unsubscribes;
    }

    /**
     * Set repeatBounces
     *
     * @param integer $repeatBounces
     * @return EmailSendStats
     */
    public function setRepeatBounces($repeatBounces)
    {
        $this->repeatBounces = $repeatBounces;

        return $this;
    }

    /**
     * Get repeatBounces
     *
     * @return integer
     */
    public function getRepeatBounces()
    {
        return $this->repeatBounces;
    }

    /**
     * Set invalidEmail
     *
     * @param integer $invalidEmail
     * @return EmailSendStats
     */
    public function setInvalidEmail($invalidEmail)
    {
        $this->invalidEmail = $invalidEmail;

        return $this;
    }

    /**
     * Get invalidEmail
     *
     * @return integer
     */
    public function getInvalidEmail()
    {
        return $this->invalidEmail;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("[%s] %s", $this->created->format('d/m/Y'), $this->getSubject());
    }
}
