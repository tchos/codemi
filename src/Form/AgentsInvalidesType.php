<?php

namespace App\Form;

use App\Entity\AgentsInvalides;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentsInvalidesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('matriculeArmee')
            ->add('matriculeSolde')
            ->add('grade')
            ->add('tauxInvalidite')
            ->add('dateInvalidite')
            ->add('rangInstance')
            ->add('revalorisation_y_n')
            ->add('typeAgent')
            ->add('auteurInvalide')
            ->add('dateDecesAuteur')
            ->add('typeInvalidite')
            ->add('rangDecision')
            ->add('rangPage')
            ->add('page')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AgentsInvalides::class,
        ]);
    }
}
