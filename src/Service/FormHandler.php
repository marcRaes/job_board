<?php

namespace App\Service;

use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
    * Gère la soumission et la validation du formulaire.
    * @param Offre $offre
    * @param FormInterface $form
    * @param Request $request
    * @return bool true si tout est ok
    */
    public function handleForm(Offre $offre, FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($offre);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
