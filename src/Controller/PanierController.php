<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use App\Service\Panier\PanierService;
use App\Repository\EmprunterRepository;
use App\Repository\ExemplaireRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * Récupère le panier des livres
     * Envoie les données à la vue
     * @Route("/panier", name="panier_index")
     */
    public function index(PanierService $panierService)
    {
        return $this->render('panier/index.html.twig', [
            'livres' => $panierService->show(),
        ]);
    }

    /**
     * Ajoute un livre au panier
     * Redirige vers le panier
     * 
     * @Route("/panier/add/{id}", name="panier_add")
     * 
     */
    public function add($id, PanierService $panierService)
    {
        $panierService->add($id);
        $this->addFlash('addPanier', 'Livre ajouté au panier !'); 
        return $this->redirectToRoute('catalog_index');
    }

    /**
     * Supprime un livre du panier
     * Redirige vers le panier
     * 
     * @Route("/panier/remove/{id}", name="panier_remove")
     * @return void
     */
    public function remove($id, PanierService $panierService)
    {
        $panierService->remove($id);
        return $this->redirectToRoute('panier_index');
    }

}
