<?php

namespace San\EmailBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmailSendRepository extends EntityRepository
{
    /**
     * @return null|\San\EmailBundle\Entity\EmailSend
     */
    public function findByEmailTitle($title)
    {
        return $this
            ->createQueryBuilder('ess')
            ->innerJoin('ess.emailSend', 'es')
            ->innerJoin('es.email', 'e')
            ->where('e.title = :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }
}
