<?php

namespace App\Controller\admin;

use App\Form\ScientistStudyType;
use App\Entity\ScientistStudy;
use App\Repository\ScientistStudyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/scientistsStudies')]

class ScientistsStudiesController extends AbstractController
{
    #[Route('/', name: 'app_scientists_studies_index')]
    public function index( ScientistStudyRepository $SSRepository ): Response
    {
        return $this->render('admin/scientists_studies/index.html.twig', [
            'studies' => $SSRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_scientists_studies_new', methods: ['GET', 'POST'])]
    public function newStudy( ScientistStudyRepository $SSRepository, Request $request ): Response
    {
        $study = new ScientistStudy();
        $form = $this->createForm(ScientistStudyType::class, $study);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $SSRepository->add($study);
            return $this->redirectToRoute('app_scientists_studies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/scientists_studies/new.html.twig', [
            'study' => $study,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_scientists_studies_show', methods: ['GET'])]
    public function show( ScientistStudy $study ): Response
    {
        return $this->render('admin/scientists_studies/show.html.twig', [
            'study' => $study,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scientists_studies_edit', methods: ['GET', 'POST'])]
    public function edit( ScientistStudyRepository $SSRepository, ScientistStudy $study, Request $request ): Response
    {
        $form = $this->createForm(ScientistStudyType::class, $study);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $SSRepository->add($study);
            return $this->redirectToRoute('app_scientists_studies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/scientists_studies/edit.html.twig', [
            'study' => $study,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scientists_studies_delete', methods: ['POST'])]
    public function delete(Request $request, ScientistStudy $study, ScientistStudyRepository $SSRepository ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$study->getId(), $request->request->get('_token'))) {
            $SSRepository->remove($study);
        }

        return $this->redirectToRoute('app_scientists_studies_index', [], Response::HTTP_SEE_OTHER);
    }
}
