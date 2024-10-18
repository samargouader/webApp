<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route("crud/author")]

class CrudAuthorController extends AbstractController
{
    #[Route('/list', name: 'app_crud_author')]
    public function listAuthor(AuthorRepository $repository): Response
    {
        //$repository= new AuthorRepository(;
        $authors=$repository->findAll();
        return $this->render('crud_author/listAuthor.html.twig', ['authors' => $authors]);
    }

    #[Route('/search', name: 'app_search_author')]
    public function searchByName(Request $request, AuthorRepository $repository): Response
    {
        $name = $request->query->get('name');

        //test du code
        //var_dump($name);
        //die();

        //fetch the author
        $authors =$repository->findByName($name);

        return $this->render('crud_author/listAuthor.html.twig', ['authors' => $authors]);
    }

    //methode d'insertion d'auteur dans la base de données
    #[Route('/insert', name: 'app_insert_author')]
    public function insertAuthor(ManagerRegistry $doctrine):Response
    {
        //1. créer une instance statique
        $author = new Author();
        $author->setName('Ahmed');
        $author->setEmail('ahmed@gmail.com');
        $author->setNbrBooks(10);

        //2. créer une copie du doctrine avec entityManager: $em
        // use Doctrine\Persistence\ManagerRegistry;
        $em=$doctrine->getManager();

        //3. persister l'objet dans la couche doctrine
        $em->persist($author);

        //4. sauvegarder les données
        $em->flush();
        return $this->redirectToRoute("app_crud_author");
    }


    //supprimer un objet de la base de données en utilisant la clé primaire ID
    #[Route('/delete/{id}', name: 'app_delete_author')]
    public function deleteAuthor($id, AuthorRepository $repository, ManagerRegistry $doctrine):Response
    {
        //get the object from the database
        $author=$repository->find($id);

        //2. créer une copie du doctrine avec entityManager: $em
        // use Doctrine\Persistence\ManagerRegistry;
        $em=$doctrine->getManager();
        //3. supprimer l'objet de la couche doctrine'
        $em->remove($author);
        //4. sauvegarder les données
        $em->flush();
        return $this->redirectToRoute("app_crud_author");

    }

    //modifier un objet de la base de données en utilisant la clé primaire ID
    #[Route('/update/{id}', name: 'app_update_author')]
    public function updateAuthor(Author $author, ManagerRegistry $doctrine): Response
    {
        // get the object from the database
        //$author=$repository->find($id);
        //var_dump($author);
        //die();

        $em=$doctrine->getManager();
        $author->setEmail('Email Updated');

        //sauvegarder les données
        $em->flush();

        return $this->redirectToRoute("app_crud_author");
    }

    //une methode pour ajouter un nouveau auteur avec une forme
    #[Route("/insertForm", name: "app_insert_form_author")]
    public function insertFormAuthor(Request $request, ManagerRegistry $doctrine): Response
    {
        $author= new Author();
        $form=$this->createForm(AuthorType::class, $author);
        $form=$form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute("app_crud_author");

        }
        return $this->render('crud_author/formAuthor.html.twig',
        ['form' => $form->createView()]);
    }

}
