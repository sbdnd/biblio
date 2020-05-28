<?php

namespace App\Controller\Admin;

use App\Entity\Emprunter;
use App\Form\EmprunterType;
use App\Repository\EmprunterRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/emprunter")
 */
class EmprunterController extends AbstractController
{
    /**
     * @Route("/", name="admin_emprunter_index", methods={"GET"})
     */
    public function index(EmprunterRepository $emprunterRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $emprunter = $paginator->paginate(
            $emprunterRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/emprunter/index.html.twig', [
            'emprunters' => $emprunter,
        ]);
    }

    /**
     * @Route("/{exemplaire}/{adherent}/{date}/edit", name="admin_emprunter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $exemplaire, $adherent, string $date, EmprunterRepository $emprunterRepository): Response
    {
        $exemplaire = intval($exemplaire); //Convertir l'id exemplaire sous forme de int
        $adherent = intval($adherent); //Convertir l'adherent exemplaire sous forme de int
        $tabEmprunter = $emprunterRepository->findByAllId($exemplaire, $adherent, $date); //Récupère un tableau contenant l'objet emprunt.
        $emprunter = $tabEmprunter[0]; //Récupérer l'objet exemplaire dans le tableau
        
        $form = $this->createForm(EmprunterType::class, $emprunter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Retour effectué avec succès !');
            return $this->redirectToRoute('admin_emprunter_index');
        }

        return $this->render('admin/emprunter/edit.html.twig', [
            'emprunter' => $emprunter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{exemplaire}", name="admin_emprunter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Emprunter $emprunter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emprunter->getExemplaire(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emprunter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_emprunter_index');
    }
}
