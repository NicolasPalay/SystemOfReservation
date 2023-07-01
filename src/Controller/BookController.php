<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Pictures;
use App\Form\BookType;
use App\Repository\BookRepository;
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
    #[Route('/new', name: 'new')]
    public function add(Request $request, PictureService $pictureService, EntityManagerInterface $entityManager): Response
    {
        $newBook = new Book();
        $form = $this->createForm(BookType::class, $newBook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $picture) {
                $folder = 'pictures';
                $pictureName = $pictureService->add($picture, $folder, 300,300);
                $newPicture = new Pictures();
                $newPicture->setName($pictureName);
                $newBook->addPicture($newPicture);

            }
            $newBook = $form->getData();
            $entityManager->persist($newBook);
            $entityManager->flush();


            return $this->redirectToRoute('book_index');
        }
        return $this->render('book/new.html.twig', [

            'form' => $form->createView(),
            'book'=>$newBook

        ]);
    }
}
