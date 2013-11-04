<?php

namespace San\EmailBundle\Document;

use San\EmailBundle\Document\EmailSend;
use San\EmailBundle\Model\EmailSendStats as BaseEmailSendStats;

class EmailSendStats extends BaseEmailSendStats
{
    /**
     * Set emailSend
     *
     * @param \San\EmailBundle\Document\EmailSend $emailSend
     * @return EmailSendStats
     */
    public function setEmailSend(EmailSend $emailSend = null)
    {
        $this->emailSend = $emailSend;

        return $this;
    }
}
