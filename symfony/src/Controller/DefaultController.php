<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class DefaultController extends AbstractController
{
    #[Route('/', name: 'react_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('react/index.html.twig', [ 'test' => 3]);
    }
}
