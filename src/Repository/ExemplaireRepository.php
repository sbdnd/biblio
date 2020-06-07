<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Exemplaire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Exemplaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exemplaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exemplaire[]    findAll()
 * @method Exemplaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExemplaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exemplaire::class);
    }

    public function nbExemplaire($id)
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->andWhere('e.livre = :livreId')
            ->setParameter('livreId', $id)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Récupère les exemplaires d'un livre en fonction de l'id de ce livre
     * Retourne les objets exemplaires sous forme d'un tableau
     *
     * @param number $id
     * @return Exemplaire[]
     */
    public function findExemplaireByLivreId($id): array
    {
        return $this->createQueryBuilder('e')
            ->select('e', 'l' )
            ->join('e.livre','l')
            ->andWhere('l.id = :livreId')
            ->setParameter('livreId', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Récupère les exemplaires dispo d'un livre en fonction de l'id de ce livre
     * Retourne un tableau d'objet exemplaire
     *
     * @return Exemplaire[]
     */
    public function findExemplaireDispo($id): array
    {
        return $this->createQueryBuilder('e')
        ->select('e', 'l' )
        ->join('e.livre','l')
        ->andWhere('l.id = :livreId')
        ->setParameter('livreId', $id)
        ->andWhere('e.dispo = true')
        ->getQuery()
        ->getResult()
    ;
    }


    // /**
    //  * @return Exemplaire[] Returns an array of Exemplaire objects
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
    public function findOneBySomeField($value): ?Exemplaire
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
