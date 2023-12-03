<?php

namespace App\Controller;

use App\Entity\Historiques;
use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator,
                             UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // La table qui enregistre toutes les actions des users .
        $history = new Historiques();
        $user = new Utilisateurs();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // Si les données enregistrées à travers le formulaire soumis sont valides, on les save en BD .
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setEnableYN(true)
                ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // On save l'action du user .
            $history->setNature("COMPTE USER")
                    ->setTypeAction("CREATE")
                    ->setClef($form->get("username")->getData())
                    ->setAuteur($this->getUser()->getUsername())
                    ->setDateAction(new \DateTimeImmutable())
            ;

            $entityManager->persist($history);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // Modification du profil
    #[IsGranted('ROLE_USER')]
    #[Route('/user/{id}/edit', name: 'user_edit')]
    public function edit(EntityManagerInterface $manager, Request $request, Utilisateurs $user): Response
    {
        // pour l'historisation de l'action
        $history = new Historiques();

        // constructeur de formulaire de saisie des actes de décès
        $form = $this->createForm(RegistrationFormType::class, $user);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $history->setTypeAction("UPDATE")
                ->setAuteur($this->getUser()->getUsername())
                ->setNature("COMPTE_USER")
                ->setClef($form->get('username')->getData())
                ->setDateAction(new \DateTimeImmutable())
            ;
            // Persistence de l'entité Organismes
            $manager->persist($user);
            $manager->persist($history);
            $manager->flush();

            // Alerte succès de la mise à jour des informations sur un organisme
            $this->addFlash("warning", "Utilisateur modifié avec succès !");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('registration/user_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
