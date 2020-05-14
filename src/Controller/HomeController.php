<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(LivreRepository $repo): Response
    {
        $livres = $repo->findLatest();

        return $this->render('home/index.html.twig', [
            'livres' => $livres
        ]);
    }
}
