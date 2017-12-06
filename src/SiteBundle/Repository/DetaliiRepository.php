<?php

namespace SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;
use SiteBundle\Entity\Detalii;
use SiteBundle\Entity\Imagini;

class DetaliiRepository extends EntityRepository
{
    public function getNewRegisters()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->getEntityManager()
            ->createQuery('SELECT d,i FROM SiteBundle:Detalii d LEFT JOIN SiteBundle:Imagini i WITH d.idImg = i.id WHERE d.aprobaImagine = :statusImg AND d.aprobaMesaj = :statusMsg')
            ->setParameter('statusImg', Imagini::STATUS_NEW_IMAGE)
            ->setParameter('statusMsg', Detalii::STATUS_NEW_MESSAGE);

        return $qb->getResult();
    }

    public function getCastigatori()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->getEntityManager()
            ->createQuery('SELECT d FROM SiteBundle:Detalii d WHERE d.premiu > 0 ORDER BY d.modificat');

        return $qb->getResult();
    }

    function getRegistersByDay()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->getEntityManager()
            ->createQuery('SELECT count(d.adaugat) as nr FROM SiteBundle:Detalii d GROUP BY d.adaugat ORDER BY d.adaugat');

        return $qb->getResult();
    }
}