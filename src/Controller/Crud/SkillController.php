<?php

namespace App\Controller\Crud;

use App\Entity\Skill;
use App\Form\SkillType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends AbstractController
{
    #[Route("/addskill", name: "addskill")]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");

        if (!$isAuthenticated) {
            // Your form handling logic here...

            // Redirect to another route if needed
            return $this->redirectToRoute('home');
        } else {
            //Create a new skill
            $skill = new Skill();
            $form = $this->createForm(SkillType::class, $skill);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $doctrine->getManager();
                $entityManager->persist($skill);
                $entityManager->flush();


                # code...
            }
            //read skills 
            $repository = $doctrine->getRepository(Skill::class);
            $skills = $repository->findAll();


            return $this->render('crud/addSkill.html.twig', [

                "form" => $form->createView(),
                'skills' => $skills,


            ]);
        }
    }
    //delte a project
    /*
    #[Route("/delete/{id}", name: "delete_project")]

    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {
            return $this->redirectToRoute('homepage');
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('homepage'); // Redirect to the homepage or any other route
    }
    //edit project
    #[Route("/edit/{id}", name: "edit_project")]
    public function edit(Request $request, ManagerRegistry $doctrine, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('homepage');


            # code...
        }
        return $this->render('project/projectEdit.html.twig', [
            "form" => $form->createView()
        ]);
    }
    //read project
    #[Route("/read/{id}", name: "read_project")]
    public function read(ManagerRegistry $doctrine, Project $project): Response
    {
        return $this->render("project/projectRead.html.twig", [
            'project' => $project
        ]);
    }
    */
}