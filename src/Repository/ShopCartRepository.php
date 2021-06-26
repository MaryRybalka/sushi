<?php

namespace App\Repository;

use App\Entity\ShopCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShopCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopCart[]    findAll()
 * @method ShopCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopCart::class);
    }

     /**
      * @return ShopCart Returns an ShopCart object
      */
    public function findBySessionID($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.sessionID = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ShopCart
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
