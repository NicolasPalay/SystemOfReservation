<?php

namespace App\Controller\Admin;

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

#[Route('admin/hairdresser', name: 'admin_hairdresser_')]
class HairdressController extends AbstractController
{
       #[Route('/new', name: 'new')]
    public function add(Request $request,HairdresserRepository $hairdresserRepository, PictureService $pictureService, EntityManagerInterface $entityManager,AddService $addService): Response
    {
        $hairdressers = $hairdresserRepository->findAll();
        $newHairdresser = new Hairdresser();
        $form = $this->createForm(HairdresserType::class, $newHairdresser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newHairdresser = $addService->processForm($form, $newHairdresser);
            $hairdressSpecials= $form->get('speciality')->getData();
            foreach ($hairdressSpecials as $hairdressSpecial){
                $newHairdresser->addSpeciality($hairdressSpecial);
            }
            return $this->redirectToRoute('admin_hairdresser_new');
        }
        return $this->render('admin/hairdress/new.html.twig', [
        'form' => $form->createView(),
        'hairdresser' => $newHairdresser,
        'hairdressers' => $hairdressers,
            ]);
    }
    #[Route('/edit/{id}', name: 'edit')]
    public function update(Request $request, AddService $addService,PictureService $pictureService, EntityManagerInterface $entityManager, Hairdresser $hairdresser, HairdresserRepository $hairdresserRepository): Response
    {
        $form = $this->createForm(HairdresserType::class, $hairdresser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Process the hairdresser form
            $hairdresser = $addService->processForm($form, $hairdresser);

            // Get the selected specialities from the form
            $hairdressSpecials = $form->get('specialities')->getData();

            // Clear the existing specialities (optional if it's a many-to-many relationship)
            $hairdresser->getSpecialities()->clear();

            // Add the selected specialities to the hairdresser
            foreach ($hairdressSpecials as $hairdressSpecial) {
                $hairdresser->addSpeciality($hairdressSpecial);
            }

            // Save the hairdresser
            $hairdresserRepository->save($hairdresser, true);

            // Redirect to a new route (you might want to change this)
            return $this->redirectToRoute('admin_hairdresser_new');
        }
        return $this->render('admin/hairdress/edit.html.twig', [
            'form' => $form->createView(),
            'hairdresser' => $hairdresser,
        ]);
    }
}