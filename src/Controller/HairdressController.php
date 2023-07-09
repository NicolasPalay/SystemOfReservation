<?php

namespace App\Controller;

use App\Entity\Hairdresser;
use App\Entity\Pictures;
use App\Form\HairdresserType;
use App\Repository\HairdresserRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hairdresser', name: 'hairdresser_')]
class HairdressController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(HairdresserRepository $hairdresserRepository): Response
    {
        return $this->render('hairdress/index.html.twig', [
            'hairdressers' => $hairdresserRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'new')]
    public function add(Request $request, PictureService $pictureService, EntityManagerInterface $entityManager): Response
    {
        $newHairdresser = new Hairdresser();
        $form = $this->createForm(HairdresserType::class, $newHairdresser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            $folder = 'pictures';
            $pictureName = $pictureService->add($picture, $folder, 300, 300);
            $newPicture = new Pictures();
            $newPicture->setName($pictureName);

            $newHairdresser = $form->getData();
            $newHairdresser->setPicture($newPicture);
            $entityManager->persist($newHairdresser);
            $entityManager->flush();

        }
        return $this->render('hairdress/new.html.twig', [
        'form' => $form->createView(),
        'hairdresser' => $newHairdresser,
            ]);
    }
    #[Route('show/{id}', name: 'show', methods: ['GET'])]
    public function show(Hairdresser $hairdresser): Response
    {

        return $this->render('hairdress/show.html.twig', [
            'hairdresser'=> $hairdresser,
        ]);
    }

}