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
     * @var \San\EmailBundle\Entity\Email;
     */
    protected $email;

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
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->userLists = new ArrayCollection();
    }

    /**
     * Set email
     *
     * @param \San\EmailBundle\Entity\Email $email
     * @return EmailSend
     */
    public function setEmail(Email $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \San\EmailBundle\Entity\Email
     */
    public function getEmail()
    {
        return $this->email;
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
}
