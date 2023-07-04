<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(BookRepository $bookRepository):Response
    {
        $books = $bookRepository->findBy([],['id'=>'DESC'],6);
        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }
}
