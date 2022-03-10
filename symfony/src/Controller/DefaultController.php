<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('', name: 'default_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('home_index', ['_locale' => 'en']);
    }

}
