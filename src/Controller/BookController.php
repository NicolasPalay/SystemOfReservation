<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Pictures;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\PicturesRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/book', name: 'book_')]
class BookController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
 }
