<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\HairdresserRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(BookRepository $bookRepository,
                          SpecialityRepository $specialityRepository,
                          HairdresserRepository $hairdresserRepository
    ):Response
    {
        $books = $bookRepository->findBy([],['id'=>'DESC'],6);
        $speciality = $specialityRepository->findBy([],['id'=>'DESC'],4);
        $hairdresser = $hairdresserRepository->findBy([],['id'=>'DESC'],3);
        return $this->render('home/index.html.twig', [
            'books' => $books,
            'speciality' => $speciality,
            'hairdressers' => $hairdresser,
        ]);
    }
}
