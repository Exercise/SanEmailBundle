<?php

namespace San\EmailBundle\Form\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailsToStringTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a string of emails.
     *
     * @param  \Doctrine\ORM\PersistentCollection|null $users
     * @return string
     */
    public function transform($emails)
    {
        if (null === $emails) {
            return '';
        }

        return implode(', ', $emails);
    }

    /**
     * Transforms a string to an array of emails.
     *
     * @param  string $emails
     *
     * @return array
     */
    public function reverseTransform($emails)
    {
        if (!$emails) {
            return array();
        }

        return array_map(function($email){
            return trim($email);
        }, explode(',', $emails));
    }
}
