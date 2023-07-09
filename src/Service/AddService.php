<?php

namespace App\Service;

use App\Entity\Pictures;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;


class AddService
{
    private  PictureService $pictureService;
    private EntityManagerInterface $entityManager;

    public function __construct(PictureService $pictureService, EntityManagerInterface $entityManager)
    {
        $this->pictureService = $pictureService;
        $this->entityManager = $entityManager;
    }

    function processForm($form, $entity)
    {

            $picture = $form->get('picture')->getData();
            $folder = 'pictures';
            $pictureName = $this->pictureService->add($picture, $folder, 300, 300);
            $newPicture = new Pictures();
            $newPicture->setName($pictureName);

            $entity->setPicture($newPicture);
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return $entity;

    }
}