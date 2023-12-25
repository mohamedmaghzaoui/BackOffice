<?php

namespace App\Controller\Base;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //read projet
        $projects = $doctrine->getRepository(Project::class)->findAll();
        return $this->render('project/project.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projects,
        ]);
    }
}