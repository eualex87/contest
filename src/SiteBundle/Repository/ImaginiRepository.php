<?php

namespace SiteBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use SiteBundle\Entity\Detalii;
use Doctrine\ORM\Query\Expr\Join;
use SiteBundle\Entity\Imagini;

class ImaginiRepository extends EntityRepository
{
    public function getAprovedImages()
    {

        $query = $this->getEntityManager()
            ->createQuery('SELECT i,d FROM SiteBundle:Imagini i JOIN SiteBundle:Detalii d WITH i.id = d.idImg WHERE d.aprobaImagine = :statusAproba')
        ->setParameter('statusAproba', Imagini::STATUS_ACTIVE_IMAGE);
        return $query->getResult();

    }
}