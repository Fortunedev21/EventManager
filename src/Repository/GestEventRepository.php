<?php

namespace App\Repository;

use App\Entity\GestEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GestEvent>
 *
 * @method GestEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GestEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GestEvent[]    findAll()
 * @method GestEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GestEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GestEvent::class);
    }

//    /**
//     * @return GestEvent[] Returns an array of GestEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GestEvent
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
