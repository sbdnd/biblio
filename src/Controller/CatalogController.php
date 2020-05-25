<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\SearchType;
use App\Search\SearchData;
use App\Repository\LivreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CatalogController extends AbstractController
{

    private $repo;

    /**
     * On initialise le LivreRepository pour pouvoir l'utiliser dans plusieurs fonctions du controller
     *
     * @param LivreRepository $repo
     */
    public function __construct(LivreRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Récupère tous les livres
     * 
     * @Route("/catalog", name="catalog_index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        //dd($data);
        
            $livres = $paginator->paginate(
                $this->repo->findSearch($data),
                $request->query->getInt('page', 1),
                4
            );
        
        return $this->render('catalog/index.html.twig', [
            'livres' => $livres,
            'form' => $form->createView()
        ]);
    }

    /**
     * Affiche le détail d'un livre
     * utilisation d'un slug pour l'URL
     * 
     * @Route("/livre/{slug}-{id}", name="catalog_show", requirements={"slug": "[a-zA-Z0-9\-]*"})
     * @param $slug
     * @param Livre $livre
     * @return Response
     */
    public function show($slug, Livre $livre): Response
    {
        //Renvoie vers l'URL principale si le slug est modifié dans l'URL
        if($livre->getSlug() !== $slug)
        {
            return $this->redirectToRoute('livre_show', [
                'id' => $livre->getId(),
                'slug' => $livre->getSlug()
            ], 301);
        }
        return $this->render('catalog/show.html.twig', [
            'livre' => $livre
        ]);
    }
}
