<?php

namespace App\Repository;

use App\Entity\Decisions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Decisions>
 *
 * @method Decisions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decisions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decisions[]    findAll()
 * @method Decisions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecisionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decisions::class);
    }

//    /**
//     * @return Decisions[] Returns an array of Decisions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Decisions
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
