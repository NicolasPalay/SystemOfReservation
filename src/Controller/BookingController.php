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
        $userRdV = $bookingRepository->findOneBy(['client' => $this->getUser()], ['date' => 'DESC']);

       $users = $userRepository->findAll(['roles' => 'ROLE_HAIRDRESSER']);
        $newBooking = new Booking();
        $form = $this->createForm(BookingType::class, $newBooking);
        $form->handleRequest($request);

    $calendar = $this->reservation($bookingRepository);


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
            'data' => $calendar->getContent(),
            'userRdV' => $userRdV,

        ]);
    }
    public function reservation(BookingRepository $bookingRepository): Response {

        $events = $bookingRepository->findAll();
        $rdvs = [];

        foreach ($events as $event) {
            $start = $event->getDate();
            $end = clone $start;
            $duration = $event->getSpeciality()->getDuration();
            $hairdresser = $event->getHairdresser();
            $backgroundColor = '';

            if ($hairdresser->getId() == 4) {
                $backgroundColor = 'orange';
            } elseif ($hairdresser->getId() == 5) {
                $backgroundColor = 'blue';
            } elseif ($hairdresser->getId() == 6) {
                $backgroundColor = 'black';
            }

            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $start->format('Y-m-d H:i:s'),
                $end = $end->modify("+{$duration} minutes"),
                'end' => $end->format('Y-m-d H:i:s'),
                'backgroundColor' => $backgroundColor,
            ];
        }

        $data = json_encode($rdvs);
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

}
