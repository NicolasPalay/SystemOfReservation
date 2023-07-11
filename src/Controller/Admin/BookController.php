<?php

namespace App\Controller\Admin;

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
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/book', name: 'admin_book_')]
#[IsGranted('ROLE_ADMIN')]
class BookController extends AbstractController
{
     #[Route('/edit/{id}', name: 'edit')]
    public function update(Request $request, PictureService $pictureService, PicturesRepository
    $picturesRepository, EntityManagerInterface $entityManager, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('pictures')) {
                $pictures = $form->get('pictures')->getData();

                foreach ($pictures as $picture) {
                    $folder = 'pictures';
                    $pictureName = $pictureService->add($picture, $folder, 300, 300);
                    $newPicture = new Pictures();
                    $newPicture->setName($pictureName);
                    $book->addPicture($newPicture);
                }
            }

            $newBook = $form->getData();
            $entityManager->persist($newBook);
            $entityManager->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('admin/book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }

    /**
     *
     * @aad Book new()
     * @param Request $request
     * @param PictureService $pictureService
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Exception
     */
    #[Route('/new', name: 'new')]
    public function add(Request $request, PictureService $pictureService, EntityManagerInterface
    $entityManager): Response
    {
        $newBook = new Book();
        $form = $this->createForm(BookType::class, $newBook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();

            $folder = 'pictures';

            $newPictures = array_map(function ($picture) use ($folder, $pictureService, $newBook) {
                $pictureName = $pictureService->add($picture, $folder, 300, 300);

                $newPicture = new Pictures();
                $newPicture->setName($pictureName);
                $newBook->addPicture($newPicture);

                return $newPicture;
            }, $pictures);
            $newBook = $form->getData();
            $entityManager->persist($newBook);
            $entityManager->flush();


            return $this->redirectToRoute('book_index');
        }
        return $this->render('admin/book/new.html.twig', [

            'form' => $form->createView(),
            'book'=>$newBook

        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Book $book, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($book);
        $entityManager->flush();
        return $this->redirectToRoute('book_index');
    }



}
