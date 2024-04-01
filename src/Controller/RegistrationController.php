<?php

namespace App\Controller;

use App\Entity\Historiques;
use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateursRepository;
use App\Security\UserAuthenticator;
use App\Services\Statistiques;
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
    #[IsGranted('ROLE_ADMIN')]
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

    /**
     * Liste des utilisateurs
     * @param Statistiques $statistiques
     * @param UtilisateursRepository $repository
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/user/list', name: 'app_user_list')]
    public function show(UtilisateursRepository $repository, Statistiques $statistiques): Response
    {
        return $this->render('registration/user_list.html.twig', [
            'utilisateurs' => $repository->findBy(['enable_y_n' => true]),
            'stats' => $statistiques->getStats(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(EntityManagerInterface $manager, Request $request, Utilisateurs $user): Response
    {
        // pour l'historique de l'action
        $history = new Historiques();
        $user->setEnableYN(false);

        $history->setTypeAction("DELETE")
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
        $this->addFlash("danger", "Utilisateur supprimé avec succès !");

        return $this->redirectToRoute('user_list');
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

    // Réinitialisation du mot de passe utilisteur
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/user/{id}/resetpassword', name: 'user_resetpassword')]
    public function resetPassword(EntityManagerInterface $entityManager, Request $request, Utilisateurs $utilisateur,
                                  UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // On capte le user connecté
        $user = $this->getUser();
        // pour l'historisation de l'action
        $history = new Historiques();

        $plainPassword = 'aaaaabbbbb';
        $hashedPassword = $userPasswordHasher->hashPassword($utilisateur, $plainPassword);
        $utilisateur->setPassword($hashedPassword);

        $history->setTypeAction("RESET")
            ->setAuteur($user->getUsername())
            ->setNature("PASSWORD")
            ->setClef($utilisateur->getUsername())
            ->setDateAction(new \DateTimeImmutable())
        ;

        $entityManager->persist($utilisateur);
        $entityManager->persist($history);
        $entityManager->flush();

        // Alerte succès de la mise à jour des informations sur un organisme
        $this->addFlash("warning", "Le mot de passe a été réinitialisé avec succès !");

        return $this->redirectToRoute('app_user_list');

    }
}
