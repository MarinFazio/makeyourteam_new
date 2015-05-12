<?php

namespace MYT\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

//    public function getUserByUsername($username)
//    {
//        $qb = $this->createQueryBuilder('u');
//        $qb->add('select', 'user')
//           ->add('from',  'user u')
//           ->add('where', 'u.username = :username')
//           ->setParameter('username', $username);
//
//        return $qb->getQuery()->getResult();
//    }

    public function getUserByUsername($username)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM MakeYourTeamBundle:MyUser u WHERE u.username = :username'
            )->setParameter('username', $username);


        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }

    }

}