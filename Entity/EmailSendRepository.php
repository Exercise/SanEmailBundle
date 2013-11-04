<?php

namespace San\EmailBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmailSendRepository extends EntityRepository
{
    /**
     * @return null|\San\EmailBundle\Entity\EmailSend
     */
    public function findOldestNonProcessed()
    {
        return $this
            ->createQueryBuilder('es')
            ->where('es.hasProcessed = 0')
            ->andWhere('es.isProcessing = 0')
            ->orderBy('es.created', 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return array
     */
    public function findWithoutList()
    {
        return $this
            ->createQueryBuilder('es')
            ->where('es.hasList = 0')
            ->andWhere('es.isProcessing = 0')
            ->andWhere('es.hasProcessed = 1')
            ->getQuery()
            ->execute()
        ;
    }
}
