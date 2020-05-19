<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/auteur")
 */
class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="admin_auteur_index", methods={"GET"})
     */
    public function index(AuteurRepository $auteurRepository): Response
    {
        return $this->render('admin/auteur/index.html.twig', [
            'auteurs' => $auteurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_auteur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auteur);
            $entityManager->flush();
            $this->addFlash('success', 'Auteur ajouté avec succès');

            return $this->redirectToRoute('admin_auteur_index');
        }

        return $this->render('admin/auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_auteur_show", methods={"GET"})
     */
    public function show(Auteur $auteur): Response
    {
        return $this->render('admin/auteur/show.html.twig', [
            'auteur' => $auteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_auteur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Auteur $auteur): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Auteur modifié avec succès');
            return $this->redirectToRoute('admin_auteur_index');
        }

        return $this->render('admin/auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_auteur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Auteur $auteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($auteur);
            $entityManager->flush();
            $this->addFlash('success', 'Auteur supprimé avec succès');
        }

        return $this->redirectToRoute('admin_auteur_index');
    }
}
