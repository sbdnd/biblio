<?php

namespace App\Controller\Admin;

use App\Entity\Exemplaire;
use App\Form\ExemplaireType;
use Doctrine\DBAL\DBALException;
use App\Repository\ExemplaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/exemplaire")
 */
class ExemplaireController extends AbstractController
{
    /**
     * @Route("/", name="admin_exemplaire_index", methods={"GET"})
     */
    public function index(ExemplaireRepository $exemplaireRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $exemplaire = $paginator->paginate(
            $exemplaireRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('admin/exemplaire/index.html.twig', [
            'exemplaires' => $exemplaire,
        ]);
    }

    /**
     * @Route("/new", name="admin_exemplaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exemplaire = new Exemplaire();
        $form = $this->createForm(ExemplaireType::class, $exemplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exemplaire);
            $entityManager->flush();
            $this->addFlash('success', 'Exemplaire ajouté avec succès');
            return $this->redirectToRoute('admin_exemplaire_index');
        }

        return $this->render('admin/exemplaire/new.html.twig', [
            'exemplaire' => $exemplaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_exemplaire_show", methods={"GET"})
     */
    public function show(Exemplaire $exemplaire): Response
    {
        return $this->render('admin/exemplaire/show.html.twig', [
            'exemplaire' => $exemplaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_exemplaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Exemplaire $exemplaire): Response
    {
        $form = $this->createForm(ExemplaireType::class, $exemplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Exemplaire modifié avec succès');
            return $this->redirectToRoute('admin_exemplaire_index');
        }

        return $this->render('admin/exemplaire/edit.html.twig', [
            'exemplaire' => $exemplaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_exemplaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Exemplaire $exemplaire): Response
    {
        try
        {
            if ($this->isCsrfTokenValid('delete'.$exemplaire->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($exemplaire);
                $entityManager->flush();
                $this->addFlash('success', "Exemplaire supprimé avec succès");
            }
        }
        catch(DBALException $e)
        {
            $this->addFlash('danger', "Impossible de supprimer un exemplaire indisponible !");
        }

        return $this->redirectToRoute('admin_exemplaire_index');
    }
}
