<?php

namespace App\Repository;

use App\Entity\OrderProduits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderProduits|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduits|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduits[]    findAll()
 * @method OrderProduits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduits::class);
    }

    // /**
    //  * @return OrderProduits[] Returns an array of OrderProduits objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderProduits
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
