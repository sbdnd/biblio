<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Search\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * Récupère les livres liés à une recherche
     *
     * @return Livre[]
     */
    public function findSearch(SearchData $data) : array
    {
        $query = $this->createQueryBuilder('l')
                    ->select('l', 'a' )
                    ->join('l.auteurs','a')
                    ->join('l.genre','g');

        if(!empty($data->getKeyword()))
        {
            $query = $query
                        ->andWhere('l.titre LIKE :keyword')
                        ->setParameter('keyword', "%{$data->getKeyword()}%");
        }

        if(!empty($data->auteurs))
        {
            $query = $query
                        ->andWhere('a.id IN (:auteurs)')
                        ->setParameter('auteurs', $data->auteurs);
        }

        if(!empty($data->getGenre()))
        {
            $query = $query
                        ->andWhere('g.id IN (:genre)')
                        ->setParameter('genre', $data->getGenre());
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Retourne les 3 derniers livres
     *
     * @return Livre[]
     */
    public function findLatest() : array
    {
        return $this->createQueryBuilder('l')
            ->setMaxResults(3)
            ->orderBy('l.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
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
