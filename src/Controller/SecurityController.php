<?php

namespace App\Controller;

use App\Entity\Historiques;
use App\Form\UpdatePasswordType;
use App\Services\Statistiques;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/connexion.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Déconnexion
    #[Route('/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[IsGranted('ROLE_USER')]
    //Mise à jour du mot de passe
    #[Route('/changepassword', name: 'password_edit')]
    public function changePassword(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager,
                                   Request $request, Statistiques $statistiques): Response
    {
        $user = $this->getUser();
        $history = new Historiques();

        $form = $this->createForm(UpdatePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();

            // Si l'ancien mot de passe est le bon
            if($userPasswordHasher->isPasswordValid($user, $old_password)){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                // On enregistre en BD l'action et celui qui l'a exécuté.
                $history->setTypeAction("UPDATE")
                    ->setAuteur($this->getUser()->getUsername())
                    ->setNature("PASSWORD")
                    ->setClef($form->get('username')->getData())
                    ->setDateAction(new \DateTimeImmutable())
                ;

                $manager->persist($user);
                $manager->persist($history);
                $manager->flush();

                // Notification du mot de passe modifié
                $this->addFlash("success", "Mot de passe modifié avec succès !!!");

                // Redirection vers la page de connexion
                return $this->redirectToRoute('app_logout');
            }else{
                // Notification du mot de passe modifié
                $this->addFlash("danger", "Votre ancien mot de passe n'est pas valide !!!");
            }
        }

        return $this->render('security/change_pwd.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'stats' => $statistiques->getStats(),
        ]);
    }
}
