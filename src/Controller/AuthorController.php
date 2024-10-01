<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    private $authors;
    public function __construct(){
        $this->authors=[
            ['id'=>1, 'authorName'=>'VictorHugo','nbrBooks'=>40,'picture'=>'images/vh.jpeg'],
        ];
    }
    //show the author name
    #[Route('/author/{id}', name: 'app_author')]
    public function showAuthor($id):Response{
        var_dump($id);
        die();
        //$authorName="Victor Hugo";
        //$authorEmail="vh@gmail.com";
        return $this->render('author/showAuthor.html.twig',
            array('authorName'=>$authorName, 'authorEmail'=>$authorEmail)
        );
    }

    //show a list of authors
    #[Route('/authors', name: 'app_show_authors')]
    public function showAuthors(){


        return $this->render('author/showAuthors.html.twig',
            ['authors'=>$authors]);
    }
}
