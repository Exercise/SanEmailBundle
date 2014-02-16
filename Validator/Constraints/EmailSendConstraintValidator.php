<?php

namespace San\EmailBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailSendConstraintValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        if ($object->getIsTest()) {
            if (!$object->getTestEmails()) {
                return $this->context->addViolationAt('testEmails', $constraint->invalidTestSend);
            }

            $filteredEmails = filter_var_array($object->getTestEmails(), FILTER_VALIDATE_EMAIL);
            foreach ($filteredEmails as $key => $value) {
                if (!$value) {
                    $this->context->addViolationAt('testEmails', $constraint->invalidTestEmails, array(
                        '%email%' => $object->getTestEmails()[$key]
                    ));
                }
            }

            return;
        }
        if (!$object->getIsTest()) {
            if ($object->getSendDate() == null) {
                return;
            }
            if ($object->getSendDate() < new \DateTime()) {
                return $this->context->addViolationAt('emailSend', $constraint->invalidSendDate);
            } else {
             return;
            }
        }

        if ($object->getUserLists()->count() == 0) {
            return $this->context->addViolationAt('userLists', $constraint->invalidUserLists);
        }
    }
}
