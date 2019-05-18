<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByDate($from, $to, $price, $limit, $offset): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
        FROM App\Entity\Event p
        WHERE p.date > :from
        AND p.date < :to
        AND p.price < :price
        ORDER BY p.date ASC
        OFFSET :offset ROWS
        FETCH NEXT :limit ROWS ONLY'
        )->setParameter('from', $from)
            ->setParameter('to', $to)
            ->setParameter('price', $price)
            ->setParameter('limit', $limit)
            ->setParameter('offset', $offset);

        // returns an array of Product objects
        return $query->execute();
    }
    public function findFilter($from, $to, $price, $category, $limit, $offset): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
        FROM App\Entity\Event p
        WHERE p.date > :from
        AND p.date < :to
        AND p.price < :price
        AND :category MEMBER OF p.category
        ORDER BY p.date ASC
        OFFSET :offset ROWS
        FETCH NEXT :limit ROWS ONLY'
        )->setParameter('from', $from)
            ->setParameter('to', $to)
            ->setParameter('category', $category)
            ->setParameter('price', $price)
            ->setParameter('limit', $limit)
            ->setParameter('offset', $offset);

        // returns an array of Product objects
        return $query->execute();
    }
}
