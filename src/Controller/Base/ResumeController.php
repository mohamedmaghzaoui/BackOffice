<?php

namespace App\Controller\Base;

use App\Entity\Skill;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResumeController extends AbstractController
{
    #[Route('/resume', name: 'app_resume')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //ReadALL skills
        $repository = $doctrine->getRepository(Skill::class);
        $skills = $repository->findAll();
        return $this->render('resume/resume.html.twig', [
            'controller_name' => 'ResumeController',
            'skills' => $skills
        ]);
    }
}
