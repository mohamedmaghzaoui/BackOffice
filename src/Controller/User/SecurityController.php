<?php
//impport dependacies

namespace App\Controller\User;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//login user
class SecurityController extends AbstractController
{
    #[Route("/login", name: "login")]
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        if ($this->getUser()) {
            // Redirect to the desired route after successful login
            return $this->render(
                'User/login.html.twig',
                [
                    "lastUsername" => $lastUsername,
                    "error" => $error
                ]
            );
        }


        return $this->render(
            'User/login.html.twig',
            [
                "lastUsername" => $lastUsername,
                "error" => $error
            ]
        );
    }
    #[Route("logout", name: "logout")]
    public function logout()
    {
    }
}