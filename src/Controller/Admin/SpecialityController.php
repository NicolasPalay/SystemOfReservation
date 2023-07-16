<?php

namespace App\Controller\Admin;

use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\PicturesRepository;

use App\Service\AddService;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/speciality', name: 'admin_speciality_')]
class SpecialityController extends AbstractController
{
    #[Route('/edit/{id}', name: 'edit')]
    public function update(Request $request, PictureService $pictureService, PicturesRepository
    $picturesRepository, EntityManagerInterface $entityManager, Speciality $speciality,AddService $addService): Response
    {
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $speciality = $addService -> processForm($form, $speciality);

            return $this->redirectToRoute('speciality_index');
        }

        return $this->render('admin/speciality/edit.html.twig', [
            'form' => $form->createView(),
            'speciality' => $speciality
        ]);
    }

    #[Route('/new', name: 'new')]
    public function add(Request $request,
                        PictureService $pictureService,
                        EntityManagerInterface $entityManager,
                        AddService $addService): Response
    {
        $newSpeciality = new Speciality();
        $form = $this->createForm(SpecialityType::class, $newSpeciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newSpeciality = $addService->processForm($form, $newSpeciality );

            return $this->redirectToRoute('speciality_index');
        }
        return $this->render('admin/speciality/new.html.twig', [
            'form' => $form->createView(),
            'speciality'=>$newSpeciality

        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Speciality $speciality, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($speciality);
        $entityManager->flush();
        return $this->redirectToRoute('speciality_index');
    }
}
