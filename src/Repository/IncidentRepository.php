<?php

namespace App\Repository;

use App\Entity\Incident;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Incident|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incident|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incident[]    findAll()
 * @method Incident[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incident::class);
    }

    /**
     * @param $beaconId
     * @return Incident[]
     */
    public function findByBeacon($beaconId)
    {
        $startTime = new \DateTime();
        $startTime->modify('-3 hour');

        return $this->createQueryBuilder('i')
            ->andWhere('i.beaconId = :beaconId')
            ->andWhere('i.timestamp > :startTime')
            ->setParameter('beaconId', $beaconId)
            ->setParameter('startTime', $startTime)
            ->orderBy('i.timestamp', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Incident
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
