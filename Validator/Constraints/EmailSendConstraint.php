<?php

namespace San\EmailBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class EmailSendConstraint extends Constraint
{
    public $invalidTestSend = 'To be able to send a test email, please enter valid email addresses';

    public $invalidTestEmails = '%email% is not a valid email';

    public $invalidUserLists = 'Please pick up at least one user list';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
