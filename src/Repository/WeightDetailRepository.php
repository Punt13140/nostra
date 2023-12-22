<?php

namespace App\Repository;

use App\Entity\WeightDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WeightDetail>
 *
 * @method WeightDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeightDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeightDetail[]    findAll()
 * @method WeightDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeightDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeightDetail::class);
    }

//    /**
//     * @return WeightDetail[] Returns an array of WeightDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WeightDetail
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
