<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/authors", name="authors")
     */
    public function index()
    {
        return $this->render('author/index.html.twig', [
            'authors' => $this->authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show-author/{id}", name="author_show")
     */
    public function show(Author $author)
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/create-author", name="author_create")
     */
    public function create()
    {
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(empty($_POST['name'])){
                $error = 'Le champs ne peut pas être vide';
            } else {
                $author = new Author();
                $author->setName($_POST['name']);
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($author);
                $entityManager->flush();

                return $this->redirectToRoute('authors');
            }
        }

        return $this->render('author/create.html.twig', [
            'error' => $error,
        ]);
    }

    /**
     * @Route("/edit-author/{id}", name="author_edit")
     */
    public function edit(Author $author)
    {
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(empty($_POST['name'])){
                $error = 'Le champs ne peut pas être vide';
            } else {
                $author->setName($_POST['name']);
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($author);
                $entityManager->flush();
                return $this->redirectToRoute('authors');
            }
        }

        return $this->render('author/create.html.twig', [
            'author' => $author,
            'error' => $error
        ]);
    }

    /**
     * @Route("/delete-author/{id}", name="author_delete")
     */
    public function delete(Author $author)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($author);
        $entityManager->flush();
        return $this->redirectToRoute('authors'); 
    }
}
