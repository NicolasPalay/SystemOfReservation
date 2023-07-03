<?php

namespace App\Controller;

use App\Entity\Pictures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/pictures', name: 'pictures_')]
class PicturesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('pictures/index.html.twig', [

        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager, Pictures $picture): Response
    {
        $entityManager->remove($picture);
        $entityManager->flush();

        $imagePath = 'assets/uploads/pictures/' . $picture->getName();
        $imagePathMini = 'assets/uploads/pictures/mini/300x300-' . $picture->getName();
        if (file_exists($imagePath)) {
            unlink($imagePath);
            unlink($imagePathMini);
        }

        return $this->redirectToRoute('book_edit', ['id' => $picture->getBook()->getId()

        ]);
    }
}
