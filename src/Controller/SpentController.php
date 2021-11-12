<?php

namespace App\Controller;

use App\Entity\Spent;
use App\Form\SpentType;
use App\Repository\SpentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spent")
 */
class SpentController extends AbstractController
{
    /**
     * @Route("/", name="spent_index", methods={"GET"})
     */
    public function index(SpentRepository $spentRepository, SessionInterface $session): Response
    {
        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        return $this->render('spent/index.html.twig', [
            'spents' => $spentRepository->findAll(),
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/new", name="spent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $spent = new Spent();
        $form = $this->createForm(SpentType::class, $spent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spent);
            $entityManager->flush();

            return $this->redirectToRoute('spent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('spent/new.html.twig', [
            'spent' => $spent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="spent_show", methods={"GET"})
     */
    public function show(Spent $spent): Response
    {
        return $this->render('spent/show.html.twig', [
            'spent' => $spent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Spent $spent): Response
    {
        $form = $this->createForm(SpentType::class, $spent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('spent/edit.html.twig', [
            'spent' => $spent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="spent_delete", methods={"POST"})
     */
    public function delete(Request $request, Spent $spent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($spent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spent_index', [], Response::HTTP_SEE_OTHER);
    }
}
