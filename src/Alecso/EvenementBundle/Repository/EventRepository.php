<?php
/**
 * Created by PhpStorm.
 * User: Mars
 * Date: 09/04/2019
 * Time: 16:07
 */

namespace Alecso\EvenementBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{

    public function findByEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM AlecsoEvenementBundle:Evenement e
                WHERE e.title LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
}