<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserConnexionType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, SessionInterface $session): Response
    {
        if ($session->has("login")) {
            $current_user = true;
        } else {
            $current_user = false;
        }
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', ['current' => $current_user], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user, SessionInterface $session): Response
    {
        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, SessionInterface $session): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', ['current' => $current_user], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'current' => $current_user
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, SessionInterface $session): Response
    {
        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', ['current' => $current_user], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/connexion", name="user_connexion", methods={"GET", "POST"})
     */
    public function connexion(Request $request, SessionInterface $session): Response
    {
        if ($session->has("login")) {
                $current_user = true;
            return $this->redirectToRoute('index', ['current' => $current_user], Response::HTTP_SEE_OTHER);
        }
        else {
            $current_user = false;
        }
        $user = new User();
        $form = $this->createForm(UserConnexionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $find_user = $entityManager->getRepository(User::class)->findOneBy(array('mail' => $user->getMail()));
            if (!isset($find_user)) {
                $error = new FormError("Utilisateur non trouvé.");
                $form->addError($error);
                return $this->renderForm('logIn.html.twig', [
                    'user' => $user,
                    'form' => $form,
                    'current' => $current_user
                ]);
            } elseif ($find_user->getPassword() !== $user->getPassword()) {
                $error = new FormError("Mail ou mot de passe incorrect !");
                $form->addError($error);
                return $this->renderForm('logIn.html.twig', [
                    'user' => $user,
                    'form' => $form,
                    'current' => $current_user
                ]);
            }
            $session->set("login", $find_user->getId());
            return $this->renderForm('base.html.twig', ['current' => $current_user]);
        }

        return $this->renderForm('logIn.html.twig', [
            'user' => $user,
            'form' => $form,
            'current' => $current_user
        ]);
    }


    /**
     * @Route("/deco", name="deco", methods={"GET"})
     */
    public function deco(SessionInterface $session): Response
    {
        $session->remove("login");
        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        return $this->renderForm('base.html.twig', ['current' => $current_user]);
    }
}
