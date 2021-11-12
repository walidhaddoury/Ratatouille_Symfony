<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity_index", methods={"GET"})
     */
    public function index(ActivityRepository $activityRepository, SessionInterface $session): Response
    {
        if ($session->has("login")) {
            $current_user = true;
        } else {
            $current_user = false;
        }
        return $this->render('activity/index.html.twig', [
            'activities' => $activityRepository->findAll(),
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/new", name="activity_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($session->has("login")) {
            $current_user = true;
        } else {
            $current_user = false;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form,
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/{id}", name="activity_show", methods={"GET"})
     */
    public function show(Activity $activity, SessionInterface $session): Response
    {
        if ($session->has("login")) {
            $current_user = true;
        } else {
            $current_user = false;
        }
        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activity $activity, SessionInterface $session): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($session->has("login")) {
            $current_user = true;
        } else {
            $current_user = false;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form,
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/{id}", name="activity_delete", methods={"POST"})
     */
    public function delete(Request $request, Activity $activity, SessionInterface $session): Response
    {
        if ($session->has("login")) {
            $current_user = true;
        } else {
            $current_user = false;
        }
        if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activity_index', ['current' => $current_user], Response::HTTP_SEE_OTHER);
    }
}
