<?php

namespace App\Controller;

use App\Entity\Hairdresser;
use App\Entity\Pictures;
use App\Form\HairdresserType;
use App\Repository\HairdresserRepository;
use App\Service\AddService;
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
            'hairdressers' => $hairdresserRepository->findBy([],['id'=>'DESC']),
        ]);
    }


    #[Route('/new', name: 'new')]
    public function add(Request $request, PictureService $pictureService, EntityManagerInterface $entityManager,AddService $addService): Response
    {
        $newHairdresser = new Hairdresser();
        $form = $this->createForm(HairdresserType::class, $newHairdresser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newHairdresser = $addService->processForm($form, $newHairdresser);

        }
        return $this->render('hairdress/new.html.twig', [
        'form' => $form->createView(),
        'hairdresser' => $newHairdresser,
            ]);
    }
    #[Route('/edit/{id}', name: 'edit')]
    public function update(Request $request, AddService $addService,PictureService $pictureService, EntityManagerInterface $entityManager, Hairdresser $hairdresser): Response
    {
        $form = $this->createForm(HairdresserType::class, $hairdresser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form -> isValid()) {
            $hairdresser = $addService->processForm($form, $hairdresser);

        }
        return $this->render('hairdress/edit.html.twig', [
            'form' => $form->createView(),
            'hairdresser' => $hairdresser,
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