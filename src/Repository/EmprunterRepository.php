<?php

namespace App\Repository;

use App\Entity\Emprunter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Emprunter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunter[]    findAll()
 * @method Emprunter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunter::class);
    }

    public function findAllEmprunt()
    {
        return $this->createQueryBuilder('e')
            ->select('e, a, ex')
            ->join('e.adherent','a')
            ->join('e.exemplaire','ex')
            ->andWhere('e.dateRetourReelle IS NULL')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAllId(int $idExemplaire, int $idAdherent, string $date)
    {
        return $this->createQueryBuilder('e')
            ->select('e, a, ex')
            ->join('e.adherent','a')
            ->join('e.exemplaire','ex')
            ->andWhere('ex.id = :idex')
            ->setParameter('idex', $idExemplaire)
            ->andWhere('a.id = :idAd')
            ->setParameter('idAd', $idAdherent)
            ->andWhere('e.datePret = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Emprunter[] Returns an array of Emprunter objects
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
    */

    /*
    public function findOneBySomeField($value): ?Emprunter
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
