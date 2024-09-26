<?php

namespace App\Controller; // Corrected 'contoller' to 'controller'

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; // Import Response
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET'])] // Corrected the route name syntax
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }
}
