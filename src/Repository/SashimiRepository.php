<?php

namespace App\Repository;

use App\Entity\Sashimi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sashimi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sashimi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sashimi[]    findAll()
 * @method Sashimi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SashimiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sashimi::class);
    }

    // /**
    //  * @return Sashimi[] Returns an array of Sashimi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sashimi
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
