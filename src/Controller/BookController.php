<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/book', name: 'book_')]

class BookController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/new', name: 'new')]
    public function add(Request $request): Response
    {
        $newBook = new Book();
        $form = $this->createForm(BookType::class, $newBook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newBook = $form->getData();



            return $this->redirectToRoute('book_index');
        }
        return $this->render('book/new.html.twig', [

            'form' => $form->createView(),
            'book'=>$newBook

        ]);
    }
}
