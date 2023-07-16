<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/booking', name: 'app_booking_')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository
    $userRepository, BookingRepository $bookingRepository)
    : Response
    {
        $users = $users = $userRepository->findAll(['roles' => 'ROLE_HAIRDRESSER']);
        $newBooking = new Booking();
        $form = $this->createForm(BookingType::class, $newBooking);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $newBooking = $form->getData();
            $newBooking->setHairdresser($form->get('hairdresser')->getData());
            $newBooking->setClient($this->getUser());
            $bookingRepository->save( $newBooking, true);
            $this->addFlash('success', 'Votre réservation a bien été enregistrée');
            return $this->redirectToRoute('app_booking_new');
        }
        return $this->render('booking/new.html.twig', [
'form' => $form->createView(),
            'booking' => $newBooking,
            'users' => $users,


        ]);
    }
}
