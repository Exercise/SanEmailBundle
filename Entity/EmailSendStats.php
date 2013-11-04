<?php

namespace San\EmailBundle\Entity;

use San\EmailBundle\Entity\EmailSend;
use San\EmailBundle\Model\EmailSendStats as BaseEmailSendStats;

class EmailSendStats extends BaseEmailSendStats
{
    /**
     * Set emailSend
     *
     * @param \San\EmailBundle\Entity\EmailSend $emailSend
     * @return EmailSendStats
     */
    public function setEmailSend(EmailSend $emailSend = null)
    {
        $this->emailSend = $emailSend;

        return $this;
    }
}
