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


            return $this->render('crud/Skill/addSkill.html.twig', [

                "form" => $form->createView(),
                'skills' => $skills,


            ]);
        }
    }
    //delte a skill

    #[Route("/delete/skill/{id}", name: "delete_skill")]

    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");

        if (!$isAuthenticated) {

            // Redirect to home page
            return $this->redirectToRoute('home');
        } else {
            $entityManager = $doctrine->getManager();
            $skill = $entityManager->getRepository(Skill::class)->find($id);


            //check if skill exist
            if (!$skill) {
                return $this->redirectToRoute('addskill');
            } else {

                $entityManager->remove($skill);


                $entityManager->flush();

                return $this->redirectToRoute('addskill'); // Redirect to the homepage or any other route   
            }
        }
    }




    //edit skill
    #[Route("/edit/skill/{id}", name: "edit_skill")]
    public function edit(Request $request, ManagerRegistry $doctrine, Skill $skill): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");
        if (!$isAuthenticated) {
            //redirect to home page
            return $this->redirectToRoute("home");
            # code...
        } else {
            //create edit form

            $form = $this->createForm(SkillType::class, $skill);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                return $this->redirectToRoute('addskill');


                # code...
            }
            //return edit template
            return $this->render('Crud/Skill/editSkill.html.twig', [
                "form" => $form->createView()
            ]);
        }
    }
}
