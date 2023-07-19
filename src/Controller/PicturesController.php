<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Repository\HairdresserRepository;
use App\Repository\SpecialityRepository;
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

        return $this->redirectToRoute('admin_book_new', ['id' => $picture->getBook()->getId()

        ]);
    }
    #[Route('/deleteSpeciality/{id}', name: 'delete_speciality')]
    public function deleteSpeciality(Request $request, SpecialityRepository $specialityRepository, EntityManagerInterface $entityManager, Pictures $picture): Response
    {
        $speciality = $specialityRepository->findOneBy(['picture' => $picture]);
        $speciality->setPicture(null);
        $entityManager->remove($picture);
        $entityManager->flush();

        $imagePath = 'assets/uploads/pictures/' . $picture->getName();
        $imagePathMini = 'assets/uploads/pictures/mini/300x300-' . $picture->getName();
        if (file_exists($imagePath)) {
            unlink($imagePath);
            unlink($imagePathMini);
        }

        return $this->redirectToRoute('admin_speciality_edit',
            ['id' => $speciality->getId()

        ]);
    }
    #[Route('/deleteHairdresser/{id}', name: 'delete_hairdresser')]
    public function deleteHairdresser(Request $request, HairdresserRepository $hairdresserRepository, EntityManagerInterface $entityManager, Pictures $picture): Response
    {
        $hairdresser = $hairdresserRepository->findOneBy(['picture' => $picture]);
        $hairdresser->setPicture(null);
        $entityManager->remove($picture);
        $entityManager->flush();

        $imagePath = 'assets/uploads/pictures/' . $picture->getName();
        $imagePathMini = 'assets/uploads/pictures/mini/300x300-' . $picture->getName();
        if (file_exists($imagePath)) {
            unlink($imagePath);
            unlink($imagePathMini);
        }

        return $this->redirectToRoute('admin_hairdresser_edit',
            ['id' => $hairdresser->getId()

            ]);
    }

}
