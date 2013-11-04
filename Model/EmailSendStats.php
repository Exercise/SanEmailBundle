<?php

namespace San\EmailBundle\Model;

class EmailSendStats
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \San\EmailBundle\Model\EmailSend
     */
    protected $emailSend;

    /**
     * @var integer
     */
    protected $attempted;

    /**
     * @var integer
     */
    protected $delivered;

    /**
     * @var integer
     */
    protected $opens;

    /**
     * @var integer
     */
    protected $uniqueOpens;

    /**
     * @var integer
     */
    protected $clicks;

    /**
     * @var integer
     */
    protected $uniqueClicks;

    /**
     * @var float
     */
    protected $ctr;

    /**
     * @var float
     */
    protected $tctr;

    /**
     * @var integer
     */
    protected $bounces;

    /**
     * @var integer
     */
    protected $spamReport;

    /**
     * @var integer
     */
    protected $repeatSpamReport;

    /**
     * @var integer
     */
    protected $unsubscribes;

    /**
     * @var integer
     */
    protected $repeatBounces;

    /**
     * @var integer
     */
    protected $invalidEmail;

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
     * Get emailSend
     *
     * @return \San\EmailBundle\Model\EmailSend
     */
    public function getEmailSend()
    {
        return $this->emailSend;
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
        return $this->getEmailSend()->__toString();
    }
}
