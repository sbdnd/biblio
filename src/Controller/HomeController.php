<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use App\Repository\ExemplaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Récupère les 3 derniers livres et envoie à la vue
     * 
     * @Route("/", name="home")
     * @return Response
     */
    public function index(LivreRepository $repo, ExemplaireRepository $er): Response
    {        
        $livres = $repo->findLatest();

        $exemplaireDispo =[];
        foreach($livres as $livre)
        {
            $exemplaireDispo[$livre->getId()] = $er->findTotalExemplaireDispo($livre->getId());
        }

        return $this->render('home/index.html.twig', [
            'livres' => $livres,
            'exemplaireDispo' => $exemplaireDispo
        ]);
    }
}
