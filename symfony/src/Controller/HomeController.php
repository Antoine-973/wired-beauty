<?php

namespace App\Controller;

use App\Repository\ScientistStudyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/{_locale<%app.supported_locales%>}/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('story', name: 'about_story_index', methods: ['GET'])]
    public function story(): Response
    {
        return $this->render('about/story.html.twig');
    }

    #[Route('beliefs', name: 'about_beliefs_index', methods: ['GET'])]
    public function beliefs(): Response
    {
        return $this->render('about/beliefs.html.twig');
    }

    #[Route('team', name: 'about_team_index', methods: ['GET'])]
    public function team(): Response
    {
        return $this->render('about/team.html.twig');
    }

    #[Route('technologies', name: 'factory_technologies_index', methods: ['GET'])]
    public function technologies(): Response
    {
        return $this->render('factory/technologies.html.twig');
    }

    #[Route('services', name: 'factory_services_index', methods: ['GET'])]
    public function services(): Response
    {
        return $this->render('factory/services.html.twig');
    }

    #[Route('validation', name: 'factory_validation_index', methods: ['GET'])]
    public function validation(ScientistStudyRepository $scientistStudyRepository): Response
    {
        $imgs = [
            'https://images.pexels.com/photos/46168/space-telescope-mirror-segments-james-webb-cosmos-46168.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260',
            'https://images.pexels.com/photos/4299431/pexels-photo-4299431.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260',
            'https://images.pexels.com/photos/132477/pexels-photo-132477.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260',
            'https://images.pexels.com/photos/60582/newton-s-cradle-balls-sphere-action-60582.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260',
            'https://images.pexels.com/photos/2506594/pexels-photo-2506594.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500'
        ];

        return $this->render('factory/validation.html.twig', [
            'studies' => $scientistStudyRepository->findAll(),
            'imgs' => $imgs
        ]);
    }

    #[Route('excel', name: 'excel_parser', methods: ['GET'])]
    public function excelParser(): Response
    {
        return $this->render('react/index.html.twig');
    }

}
