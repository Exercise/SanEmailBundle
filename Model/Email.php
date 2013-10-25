<?php

namespace San\EmailBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use San\UserListBundle\Entity\UserList;

class Email
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
    protected $sender;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $userLists;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->userLists = new ArrayCollection();
    }

    /**
     * Get id
     *
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
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
