<?php

namespace App\Controller;

use App\Entity\Emprunter;
use Doctrine\DBAL\DBALException;
use App\Service\Panier\PanierService;
use App\Repository\EmprunterRepository;
use App\Repository\ExemplaireRepository;
use App\Service\Reserver\ReserverService;
use App\Service\Emprunter\EmprunterService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReserverController extends AbstractController
{

    /**
     * Effectue la réservation d'un exemplaire du livre sélectionné
     * après avoir vérifié si cet exemplaire était disponible
     * 
     * @param int $id
     * @param EmprunterService $exemplaires
     * @param PanierService $panier
     * @return void
     * 
     * @Route("/panier/{id}", name="emprunter_reserve")
     */
    public function reserve($id, ReserverService $exemplaires, PanierService $panier)
    {
        $listExemplaires = $exemplaires->available($id);
        try
        {
            if(count($listExemplaires) == 0)
            {
                $this->addFlash('danger', 'Livre indisponible');
            }
            else
            {
                $exemplaires->reserve($id);
                $panier->remove($id);
                $this->addFlash('success', 'Livre réservé avec succès'); 
            }
        
        }
        catch(DBALException $e)
        {
            $this->addFlash('danger', "Vous avez déjà réservé cet exemplaire aujourd'hui !");
        }

        return $this->redirectToRoute('catalog_index');
    }

}
