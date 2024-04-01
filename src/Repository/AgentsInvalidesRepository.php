<?php

namespace App\Repository;

use App\Entity\AgentsInvalides;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgentsInvalides>
 *
 * @method AgentsInvalides|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentsInvalides|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentsInvalides[]    findAll()
 * @method AgentsInvalides[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentsInvalidesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgentsInvalides::class);
    }

//    /**
//     * @return AgentsInvalides[] Returns an array of AgentsInvalides objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AgentsInvalides
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
