<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route("crud/book")]
class CrudBookController extends AbstractController
{
    #[Route('/list', name: 'app_crud_book')]
    public function listBooks(BookRepository $bookRepository): Response
    {
        $book=$bookRepository->findAll();
        return $this->render('crud_book/listBooks.html.twig', ['book' => $book]);
    }

    #[Route('/search', name: 'app_crud_book_search')]
    public function searchBook(Request $request, BookRepository $bookRepository): Response
    {
        $title = $request->query->get('title', '');

        $book = $title ? $bookRepository->findOneBy(['title' => $title]) : null;

        return $this->render('crud_book/searchBook.html.twig', [
            'book' => $book,
            'title' => $title
        ]);
    }


}
