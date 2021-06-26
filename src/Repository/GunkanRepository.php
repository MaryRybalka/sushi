<?php

namespace App\Repository;

use App\Entity\Gunkan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gunkan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gunkan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gunkan[]    findAll()
 * @method Gunkan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GunkanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gunkan::class);
    }

    // /**
    //  * @return Gunkan[] Returns an array of Gunkan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gunkan
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
