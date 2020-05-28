<?php
namespace App\Service\Reserver;

use App\Entity\Emprunter;
use App\Entity\Exemplaire;
use App\Repository\EmprunterRepository;
use App\Repository\ExemplaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ReserverService
{
    private $emprunterRepository;

    private $exemplaireRepository;

    private $user;

    private $em;


    public function __construct(EntityManagerInterface $em, EmprunterRepository $emprunterRepository, ExemplaireRepository $exemplaireRepository, TokenStorageInterface $tokenStorage)
    {
        $this->emprunterRepository = $emprunterRepository;
        $this->exemplaireRepository = $exemplaireRepository;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->em = $em;
    }

    /**
     * Retourne la liste des exemplaires disponibles
     *
     * @param int $id
     * @return Exemplaire[]
     */
    public function available(int $id): array
    {
        //Tableau d'id des exemplaires du livre sélectionné
        $listExemplaireByLivre = $this->exemplaireRepository->findExemplaireByLivreId($id); //récupère les id des exemplaires d'un livre
        
        $listIdExemplaire = [];
        foreach($listExemplaireByLivre as $exemplaire)
        {
            $listIdExemplaire[] = $exemplaire->getId(); //tableau des exemplaires du livre sélectionné triés par leur ID
        }

        //Tableau d'id des exemplaires en cours de réservation
        $listEmprunts = $this->emprunterRepository->findAllEmprunt();//récupère tous les emprunts en cours
        $listIdExemplaireEmpruntes = [];
        foreach($listEmprunts as $emprunt)
        {
            $listIdExemplaireEmpruntes[] = $emprunt->getExemplaire()->getId(); //tableau des exemplaires empruntés triés par leur ID
        }

        //Liste des exemplaires disponibles 
        $listExemplaireId = array_diff($listIdExemplaire,  $listIdExemplaireEmpruntes);
        $listExemplaire = [];
        foreach($listExemplaireId as $idExemplaire)
        {
            $listExemplaire[] = $this->exemplaireRepository->find($idExemplaire);
        }

        return $listExemplaire;
    }

    /**
     * Reserve un exemplaire du livre sélectionné par son id
     *
     * @param integer $id
     * @return void
     */
    public function reserve(int $id)
    {
        $listExemplaire = $this->available($id);
       
        $datePret = new \DateTime('now');
        $date = (new \DateTime('now'))->format('Y-m-d'); //datePret au format string
        $adherent = $this->user;
        foreach($listExemplaire as $exemplaire)
        {
            $emprunt = new Emprunter();
            $emprunt
                ->setAdherent($adherent)
                ->setExemplaire($exemplaire)
                ->setDatePret($date)
                ->setDateRetourPrevue($datePret->add(new \DateInterval('P15D')))
            ;
            //$em = $this->getDoctrine()->getManager();
            $this->em->persist($emprunt);
            break;
        }
        $this->em->flush();
    }
}