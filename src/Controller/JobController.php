<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use App\Service\FormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    #[Route('/', name: 'app_job')]
    public function index(OffreRepository $offreRepository): Response
    {
        return $this->render('job/index.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_job_show', requirements: ['id' => '\d+'])]
    public function show(Offre $offre): Response
    {
        return $this->render('job/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/new', name: 'app_job_new')]
    #[Route('/edit/{id}', name: 'app_job_edit')]
    public function form(Request $request, FormHandler $formHandler, Offre $offre = null): Response
    {
        $isNew = false;
        if (!$offre) {
            $offre = new Offre();
            $isNew = true;
        }

        $form = $this->createForm(OffreType::class, $offre);

        if($formHandler->handleForm($offre, $form, $request)) {
            $this->addFlash('success', $isNew ? 'Offre créée avec succès !': 'Offre modifiée avec succès !');

            return $this->redirectToRoute('app_job_show', [
                'id' => $offre->getId()
            ]);
        }

        return $this->render('job/new.html.twig', [
            'form' => $form,
            'isNew' => $isNew,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_job_delete')]
    public function delete(Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($offre);
        $entityManager->flush();

        $this->addFlash('success', 'Offre supprimée avec succès !');

        return $this->redirectToRoute('app_job');
    }
}
