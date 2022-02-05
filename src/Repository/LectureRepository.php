<?php

namespace App\Repository;

use App\Entity\Lecture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lecture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecture[]    findAll()
 * @method Lecture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LectureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lecture::class);
    }

    // /**
    //  * @return Lecture[] Returns an array of Lecture objects
    //  */
    
    public function findByEventId($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.event_id = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findAllWithEventId()
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.event_id is not null')
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findOneByIdJoinedToEvent(int $LectureId): ?Product
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, c
            FROM App\Entity\Lecture p
            INNER JOIN p.event c
            WHERE p.id = :id'
        )->setParameter('id', $LectureId);

        return $query->getOneOrNullResult();
    }
    */
    

    /*
    public function findOneBySomeField($value): ?Lecture
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
