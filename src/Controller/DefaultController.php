<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController{
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    public function logIn(): Response
    {
        return $this->render('logIn.html.twig');
    }
}