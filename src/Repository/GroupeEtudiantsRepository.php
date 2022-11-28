<?php

namespace App\Repository;

use App\Entity\GroupeEtudiants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupeEtudiants>
 *
 * @method GroupeEtudiants|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeEtudiants|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeEtudiants[]    findAll()
 * @method GroupeEtudiants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeEtudiantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeEtudiants::class);
    }

    public function save(GroupeEtudiants $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GroupeEtudiants $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GroupeEtudiants[] Returns an array of GroupeEtudiants objects
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

//    public function findOneBySomeField($value): ?GroupeEtudiants
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
