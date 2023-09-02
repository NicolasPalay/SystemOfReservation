<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profile', name: 'app_profile_')]
#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(BookingRepository $bookingRepository,
                          Request $request,
                          EntityManagerInterface $entityManager,): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile_user');
        }


        $bookings=$bookingRepository->findBy(['client' => $user],['date' => 'DESC']);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'bookings'=>$bookingRepository->findBy(['client' => $user],['date' => 'DESC']),
            'form'=>$form->createView(),

        ]);
    }
}
