<?php

namespace App\Controller;

use App\Repository\HairdresserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hairdresser', name: 'hairdress_')]
class HairdressController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(HairdresserRepository$hairdresserRepository): Response
    {


        return $this->render('hairdress/index.html.twig', [

            'hairdressers' => $hairdresserRepository->findAll(),
        ]);
    }
}
