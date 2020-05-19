<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="admin_genre_index", methods={"GET"})
     */
    public function index(GenreRepository $genreRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $genres = $paginator->paginate(
            $genreRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('admin/genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }

    /**
     * @Route("/new", name="admin_genre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();
            $this->addFlash('success', 'Genre enregistré avec succès');

            return $this->redirectToRoute('admin_genre_index');
        }

        return $this->render('admin/genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_genre_show", methods={"GET"})
     */
    public function show(Genre $genre): Response
    {
        return $this->render('admin/genre/show.html.twig', [
            'genre' => $genre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_genre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Genre $genre): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Genre modifié avec succès');
            return $this->redirectToRoute('admin_genre_index');
        }

        return $this->render('admin/genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_genre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Genre $genre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($genre);
            $entityManager->flush();
            $this->addFlash('success', 'Genre supprimé avec succès');
        }

        return $this->redirectToRoute('admin_genre_index');
    }
}
