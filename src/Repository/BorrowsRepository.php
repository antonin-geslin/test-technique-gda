<?php

namespace App\Repository;

use App\Entity\Borrows;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borrows>
 *
 * @method Borrows|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrows|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrows[]    findAll()
 * @method Borrows[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrows::class);
    }

//    /**
//     * @return Borrows[] Returns an array of Borrows objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Borrows
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
