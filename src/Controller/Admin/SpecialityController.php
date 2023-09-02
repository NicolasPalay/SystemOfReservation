<?php

namespace App\Controller\Admin;

use App\Entity\Pictures;
use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\PicturesRepository;

use App\Repository\SpecialityRepository;
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
    #[Route('/new', name: 'new')]
    public function add(Request $request,
                        PictureService $pictureService,
                        EntityManagerInterface $entityManager,
                        SpecialityRepository $specialityRepository,
                        AddService $addService): Response
    {
        $specialities = $specialityRepository->findAll();
        $newSpeciality = new Speciality();
        $form = $this->createForm(SpecialityType::class, $newSpeciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérez le fichier téléchargé
            $uploadedFile = $form->get('picture')->getData();

            if ($uploadedFile !== null) {
                $folder = 'pictures';
                $pictureName = $pictureService->add($uploadedFile, $folder, 300, 300);

                // Créez un nouvel objet Pictures et configurez son nom
                $newPicture = new Pictures();
                $newPicture->setName($pictureName);

                // Associez le nouvel objet Pictures à votre entité Speciality
                $newSpeciality->setPicture($newPicture);

                // Enregistrez le nouvel objet Pictures et l'entité Speciality
                $entityManager->persist($newPicture);


            $entityManager->persist($newSpeciality);
            $entityManager->flush();

            return $this->redirectToRoute('admin_speciality_new');}
        }
        return $this->render('admin/speciality/new.html.twig', [
            'form' => $form->createView(),
            'speciality'=>$newSpeciality,
            'specialities'=>$specialities

        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function update(Request $request, PictureService $pictureService, PicturesRepository
    $picturesRepository, EntityManagerInterface $entityManager, Speciality $speciality,AddService $addService): Response
    {
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newSpeciality = $addService->processForm($form, $newSpeciality );
            $picture = $form->get('picture')->getData();
            $folder = 'pictures';
            $pictureName = $pictureService->add($picture, $folder, 300, 300);
            $newPicture = new Pictures();
            $newPicture->setName($pictureName);
            $entityManager->persist($newPicture);
            $newSpeciality->setPicture($newPicture);
            $entityManager->persist($newSpeciality);
            $entityManager->flush();

            return $this->redirectToRoute('speciality_index');
        }

        return $this->render('admin/speciality/edit.html.twig', [
            'form' => $form->createView(),
            'speciality' => $speciality
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
