<?php
namespace App\Service\Reserver;

use App\Entity\Reserver;
use App\Entity\Emprunter;
use App\Entity\Exemplaire;
use App\Repository\ReserverRepository;
use App\Repository\ExemplaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ReserverService
{
    private $reserverRepository;

    private $exemplaireRepository;

    private $user;

    private $em;


    public function __construct(EntityManagerInterface $em, ReserverRepository $reserverRepository, ExemplaireRepository $exemplaireRepository, TokenStorageInterface $tokenStorage)
    {
        $this->reserverRepository = $reserverRepository;
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
        $exemplairesDispo = $this->exemplaireRepository->findExemplaireDispo($id);

        return $exemplairesDispo;
    }

    /**
     * Reserve un exemplaire du livre sélectionné par son id
     *
     * @param integer $id
     * @return void
     */
    public function reserve(int $id)
    {
        $exemplairesDispo = $this->available($id);

        $date = (new \DateTime('now'))->format('Y-m-d'); //date au format string
        $adherent = $this->user; //recupère l'adherent courant
        foreach($exemplairesDispo as $exemplaire)
        {
            $reservation = new Reserver();
            $reservation
                ->setAdherent($adherent)
                ->setExemplaire($exemplaire)
                ->setDatePret($date)
            ;
            //$em = $this->getDoctrine()->getManager();
            $this->em->persist($reservation);
            break;
        }
        $this->em->flush();
    }
}