<?php

namespace App\Form;

use App\Entity\Decisions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecisionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroDecision')
            ->add('dateSignature')
            ->add('signataire')
            ->add('ministere')
            ->add('nbrePages')
            ->add('nbreAgentsInvalidesDecision')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decisions::class,
        ]);
    }
}
