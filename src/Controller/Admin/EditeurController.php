<?php

namespace App\Controller\Admin;

use App\Entity\Editeur;
use App\Form\EditeurType;
use App\Repository\EditeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/editeur")
 */
class EditeurController extends AbstractController
{
    /**
     * @Route("/", name="admin_editeur_index", methods={"GET"})
     */
    public function index(EditeurRepository $editeurRepository): Response
    {
        return $this->render('admin/editeur/index.html.twig', [
            'editeurs' => $editeurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_editeur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $editeur = new Editeur();
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editeur);
            $entityManager->flush();
            $this->addFlash('success', 'Editeur enregistré avec succès');
            return $this->redirectToRoute('admin_editeur_index');
        }

        return $this->render('admin/editeur/new.html.twig', [
            'editeur' => $editeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_editeur_show", methods={"GET"})
     */
    public function show(Editeur $editeur): Response
    {
        return $this->render('admin/editeur/show.html.twig', [
            'editeur' => $editeur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_editeur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Editeur $editeur): Response
    {
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Editeur modifié avec succès');
            return $this->redirectToRoute('admin_editeur_index');
        }

        return $this->render('admin/editeur/edit.html.twig', [
            'editeur' => $editeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_editeur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Editeur $editeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editeur);
            $entityManager->flush();
            $this->addFlash('success', 'Editeur supprimé avec succès');
        }

        return $this->redirectToRoute('admin_editeur_index');
    }
}
