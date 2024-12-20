<?php

namespace App\Controller\Crud;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Form\SearchProjectType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;

class ProjectController extends AbstractController
{
    #[Route("/addproject", name: "addproject")]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");

        if (!$isAuthenticated) {
            return $this->redirectToRoute('home');
        } else {
            //project form
            $project = new Project();
            $projectForm = $this->createForm(ProjectType::class, $project);
            $projectForm->handleRequest($request);
            if ($projectForm->isSubmitted() && $projectForm->isValid()) {

                //upload image
                $image = $projectForm->get('image')->getData();

                if ($image) {
                    $imageName = md5(uniqid()) . '.' . $image->guessExtension();
                    $image->move(
                        $this->getParameter('upload_directory'),
                        $imageName
                    );
                    $project->setImage($imageName);
                }

                $entityManager = $doctrine->getManager();
                $entityManager->persist($project);
                $entityManager->flush();

                # code...
            }

            //read projects 
            $repository = $doctrine->getRepository(Project::class);
            $projects = $repository->findAll();
            //search project form
            $searchForm = $this->createForm(SearchProjectType::class);
            $searchForm->handleRequest($request);
            if ($searchForm->isSubmitted() && $searchForm->isValid()) {
                $searchTerm = $searchForm->get('searchTerm')->getData();
                $filterTerm = $searchForm->get('filterTerm')->getData();
                if (empty($searchTerm)) {
                    $projects = $repository->findAll();
                } else {
                    //get searched projects
                    $projects = $repository->findBySearchTerm($searchTerm);
                }
                if (!empty($filterTerm)) {
                    $projects = $this->filterProjects($projects, $filterTerm);
                }

                # code...
            }
            //return template
            return $this->render('crud/Project/addproject.html.twig', [

                "projectForm" => $projectForm->createView(),
                'projects' => $projects,
                'searchForm' => $searchForm->createView()

            ]);
        }
    }

    //delte a project
    #[Route("/delete/project/{id}", name: "delete_project")]

    public function delete(ManagerRegistry $doctrine, $id, Filesystem $filesystem): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");

        if (!$isAuthenticated) {

            // Redirect to home page
            return $this->redirectToRoute('home');
        } else {

            $entityManager = $doctrine->getManager();
            $project = $entityManager->getRepository(project::class)->find($id);
            //check if project exist
            if (!$project) {
                return $this->redirectToRoute('addproject');
            } else {
                // delete image file
                $imagePath = $this->getParameter('upload_directory') . '/' . $project->getImage();
                if ($filesystem->exists($imagePath)) {
                    $filesystem->remove($imagePath);
                }

                $entityManager->remove($project);


                $entityManager->flush();

                return $this->redirectToRoute('addproject'); // Redirect to the homepage or any other route   
            }
        }
    }

    //edit project
    #[Route("/edit/project/{id}", name: "edit_project")]
    public function edit(Filesystem $filesystem, Request $request, ManagerRegistry $doctrine, project $project): Response
    {
        //check if user is authenticated
        $isAuthenticated = $this->isGranted("IS_AUTHENTICATED_FULLY");
        if (!$isAuthenticated) {
            //redirect to home page
            return $this->redirectToRoute("home");
            # code...
        } else {
            //create edit form

            $form = $this->createForm(projectType::class, $project);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //get submitted image
                $newImage = $form->get('image')->getData();
                if ($newImage) {
                    // Remove the old image file
                    $imagePath = $this->getParameter('upload_directory') . '/' . $project->getImage();
                    if ($filesystem->exists($imagePath)) {
                        $filesystem->remove($imagePath);
                    }

                    // Upload the new image
                    $imageName = md5(uniqid()) . '.' . $newImage->guessExtension();
                    $newImage->move(
                        $this->getParameter('upload_directory'),
                        $imageName
                    );
                    $project->setImage($imageName);
                }
                //update database with edited data
                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                return $this->redirectToRoute('addproject');
            }
            //return edit template
            return $this->render('Crud/project/editproject.html.twig', [
                "form" => $form->createView()
            ]);
        }
    }
    public function filterProjects(array $projects, array $filterTerm): array
    {
        $newProjects = [];

        foreach ($projects as $key => $project) {
            foreach ($filterTerm as $filter) {
                if ($project->getPurpose() == $filter) {
                    array_push($newProjects, $project);
                }
            }
        }
        return $newProjects;
    }
}