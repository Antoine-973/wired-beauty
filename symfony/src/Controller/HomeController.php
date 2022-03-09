<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('react/index.html.twig');
    }

    #[Route('/our-story', name: 'our_story_index', methods: ['GET'])]
    public function our_story(): Response
    {
        return $this->render('our_story.html.twig');
    }

    #[Route('/our-beliefs', name: 'our_beliefs_index', methods: ['GET'])]
    public function our_beliefs(): Response
    {
        return $this->render('our_beliefs.html.twig');
    }

    #[Route('/our-team', name: 'our_team_index', methods: ['GET'])]
    public function our_team(): Response
    {
        return $this->render('our_team.html.twig');
    }
}
