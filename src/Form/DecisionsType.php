<?php

namespace App\Form;

use App\Entity\Decisions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class DecisionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroDecision', TextType::class, [
                'label' => 'Numéro de la décision',
                'attr' => [
                    'placeholder' => 'EX: 1234/MINDEF/SG/12'
                ]
            ])
            ->add('dateSignature', DateType::class, [
                'label' => 'Date de signature',
                'widget' => 'single_text',
            ])
            ->add('signataire', TextType::class, [
                'label' => 'Nom du signataire',
                'attr' => [
                    'placeholder' => 'EX: KWETTE TCHOUMTCHOUA'
                ]
            ])
            ->add('ministere', ChoiceType::class, [
                'label' => 'Ministère ayant pris la décision',
                'choices' => [
                    'MINDEF' => 'MINDEF',
                    'DGSN' => 'DGSN',
                    'PRC' => 'PRC',
                    'MINRA' => 'MINRA',
                    'SPM' => 'SPM',
                    'MINREX' => 'MINREX',
                    'MINREST' => 'MINREST',
                    'MINAT' => 'MINAT',
                    'MINJUSTICE' => 'MINJUSTICE',
                    'MINDDEVEL' => 'MINDDEVEL',
                    'MINMAP' => 'MINMAP',
                    'MINAC' => 'MINAC',
                    'MINEDUB' => 'MINEDUB',
                    'MINSEP' => 'MINSEP',
                    'MINCOM' => 'MINCOM',
                    'MINESUP' => 'MINESUP',
                    'MINRESI' => 'MINRESI',
                    'MINFI' => 'MINFI',
                    'MINCOMMERCE' => 'MINCOMMERCE',
                    'MINEPAT' => 'MINEPAT',
                    'MINTOUL' => 'MINTOUL',
                    'MINESEC' => 'MINESEC',
                    'MINJEC' => 'MINJEC',
                    'MINEPDED' => 'MINEPDED',
                    'MINEE' => 'MINEE',
                    'MINFOF' => 'MINFOF',
                    'MINEFOP' => 'MINEFOP',
                    'MINTP' => 'MINTP',
                    'MINDCAF' => 'MINDCAF',
                    'MINHDU' => 'MINHDU',
                    'MINPMEESA' => 'MINPMEESA',
                    'MINSANTE' => 'MINSANTE',
                    'MINTSS' => 'MINTSS',
                    'MINAS' => 'MINAS',
                    'MINPROFF' => 'MINPROFF',
                    'MINPOSTEL' => 'MINPOSTEL',
                    'MINT' => 'MINT',
                    'MINFOPRA' => 'MINFOPRA',
                    'PENSIONNES' => 'PENSIONNES',
                    'CONSUPE' => 'CONSUPE',
                    'COURSUP' => 'COURSUP',
                    'TAMPON' => 'TAMPON',
                ],
            ])
            ->add('nbrePages', NumberType::class, [
                'label' => 'Nombre de pages que contient la décision',
                'attr' => [
                    'placeholder' => 'EX: 27'
                ]
            ])
            ->add('nbreAgentsInvalidesDecision', NumberType::class, [
                'label' => "Effectif des agents concernés par la décision",
                'attr' => [
                    'placeholder' => 'EX: 300'
                ]
            ])
            ->add('copie', FileType::class, [
                'label' => 'Téléverser une copie numérique de la décision',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '128m',
                        'maxSizeMessage' => 'La taille maximale dépasse 128 Mo',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Merci de téléverser le fichier au format pdf',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Vous devez impérativement insérer une copie numérique de la décision'
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decisions::class,
        ]);
    }
}
