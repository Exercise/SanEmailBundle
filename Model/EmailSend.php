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
     * @var \San\EmailBundle\Model\EmailSendStats
     */
    protected $stats;

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
     * Set stats
     *
     * @param \San\EmailBundle\Entity\EmailSendStats $stats
     * @return EmailSend
     */
    public function setStats(\San\EmailBundle\Model\EmailSendStats $stats = null)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Get stats
     *
     * @return \San\EmailBundle\Entity\EmailSendStats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @return string
     */
    public function getSendgridEmailName()
    {
        return sprintf("[%s] %s", $this->getCreated()->format('d/m/Y h:i'), $this->getSubject());
    }

    /**
     * @return string
     */
    public function getSendgridListName()
    {
        return sprintf("[%s] %s", $this->getCreated()->format('d/m/Y h:i'), $this->getTitle());
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
     * @return string
     */
    public function __toString()
    {
        return sprintf("[%s] %s", $this->created->format('d/m/Y'), $this->getSubject());
    }
}
