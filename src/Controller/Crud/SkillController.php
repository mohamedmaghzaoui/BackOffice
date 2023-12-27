<?php

namespace App\Controller\Crud;

use App\Entity\Skill;
use App\Form\SearchSkillType;
use App\Form\SkillType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends AbstractController
{
    //add a skill
    #[Route("/addskill", name: "addskill")]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");

        if (!$isAuthenticated) {

            return $this->redirectToRoute('home');
        } else {
            //skill form
            $skill = new Skill();
            $skillForm = $this->createForm(SkillType::class, $skill);
            $skillForm->handleRequest($request);


            if ($skillForm->isSubmitted() && $skillForm->isValid()) {
                $entityManager = $doctrine->getManager();
                $entityManager->persist($skill);
                $entityManager->flush();


                # code...
            }
            //read skills 
            $repository = $doctrine->getRepository(Skill::class);
            //declare empty array for skill list
            $skills = [];


            //seachskill form
            $searchForm = $this->createForm(SearchSkillType::class);
            $searchForm->handleRequest($request);
            // ...

            if ($searchForm->isSubmitted() && $searchForm->isValid()) {
                $searchTerm = $searchForm->get('searchTerm')->getData();
                $sortBy = $searchForm->get('sortBy')->getData();
                $sortOrder = $searchForm->get('sortOrder')->getData();



                if (empty($searchTerm)) {
                    $skills = $repository->findAll();
                } else {
                    $skills = $repository->findBySearchTerm($searchTerm);
                }
                if (!empty($sortBy) && !empty($sortOrder)) {
                    $this->sortSkills($skills, $sortBy, $sortOrder);
                }
            }
            return $this->render('crud/Skill/addSkill.html.twig', [

                "skillForm" => $skillForm->createView(),
                'skills' => $skills,
                "searchForm" => $searchForm


            ]);
        }
    }
    //sort


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
            }
            //return edit template
            return $this->render('Crud/Skill/editSkill.html.twig', [
                "form" => $form->createView()
            ]);
        }
    }

    //sorting skills
    public function sortSkills(array &$skills, string $sortBy, string $sortOrder): void
    {
        usort($skills, function ($a, $b) use ($sortBy, $sortOrder) {
            $propertyA = $this->getSortingPropertyValue($a, $sortBy);
            $propertyB = $this->getSortingPropertyValue($b, $sortBy);

            if ($sortOrder === 'asc') {
                return $propertyA <=> $propertyB;
            } else {
                return $propertyB <=> $propertyA;
            }
        });
    }

    // Add a method to get the sorting property value based on the selected criteria
    public function getSortingPropertyValue($skill, string $sortBy)
    {
        switch ($sortBy) {
            case 'Name':
                return $skill->getName(); // Assuming the Skill entity has a 'name' property
            case 'Mastery':
                return $skill->getMastery(); // Assuming the Skill entity has a 'mastery' property
            case 'date':
                return $skill->getId(); // Assuming the Skill entity has a 'createdAt' property
            default:
                throw new \InvalidArgumentException("Invalid sorting criteria: $sortBy");
        }
    }
}
