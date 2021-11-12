<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController{
    public function index(SessionInterface $session): Response
    {
        if($session->has("login")) {
            $current_user = true;
        }
        else {
            $current_user = false;
        }
        return $this->render('base.html.twig', ['current' => $current_user]);
    }

    public function logIn(): Response
    {
        return $this->render('logIn.html.twig');
    }
}