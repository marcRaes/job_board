<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Service;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'offre',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'offre',
            ])
            ->add('salaire', TextType::class, [
                'label' => 'Salaire de l\'offre',
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'nom',
                'label' => 'Le service de l\'offre',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'label' => 'Tags de l\'offre',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer l\'offre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
