<?php

namespace MYT\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function getUserByUsername($username)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->add('select', 'user')
           ->add('from',  'myt_user u')
           ->add('where', 'u.username = :username')
           ->setParameter('username', $username);

        return $qb->getQuery()->getResult();
    }

}