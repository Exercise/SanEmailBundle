<?php

namespace San\EmailBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class EmailSendRepository extends DocumentRepository
{
    /**
     * @return null|\San\EmailBundle\Document\EmailSend
     */
    public function findOldestNonProcessed()
    {
        return $this
            ->createQueryBuilder()
            ->field('hasProcessed')->equals(false)
            ->field('isProcessing')->equals(false)
            ->sort('created', 'ASC')
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @return \Doctrine\MongoDB\LoggableCursor
     */
    public function findWithoutList()
    {
        return $this
            ->createQueryBuilder()
            ->field('hasList')->equals(false)
            ->field('isProcessing')->equals(false)
            ->field('hasProcessed')->equals(true)
            ->getQuery()
            ->execute()
        ;
    }
}
