<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Service\ReservationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/booking', name: 'app_booking_')]
#[IsGranted('ROLE_USER')]
class BookingController extends AbstractController
{

    #[Route('/new', name: 'new')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, 
                        EntityManagerInterface $entityManager, 
                        UserRepository $userRepository, 
                        BookingRepository $bookingRepository, 
                        ReservationService $reservationService): Response

    {
        $userRdV = $bookingRepository->findOneBy(['client' => $this->getUser()], ['date' => 'DESC']);

        $users = $userRepository->findAll(['roles' => 'ROLE_HAIRDRESSER']);
        $newBooking = new Booking();
        $form = $this->createForm(BookingType::class, $newBooking);
        $form->handleRequest($request);

        $calendar = $reservationService->reservation($bookingRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            $newBooking = $form->getData();
            $newBooking->setHairdresser($form->get('hairdresser')->getData());
            $newBooking->setClient($this->getUser());
            $bookingRepository->save($newBooking, true);
            $this->addFlash('success', 'Votre réservation a bien été enregistrée');
            $this->addFlash('success', 'Un email vous a été envoyé pour confirmer votre réservation');
            $url = $this->generateUrl('app_booking_new',[
                'token' => uniqid()]);
            $mail = new Mail();
            $content = "bonjour " . $newBooking->getclient()->getFullName() . "<br> Vous avez dmandez à réinitialiser votre mot de passe sur le site de Lyvia Palay<br><br>";
            $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe</a>";
            $mail->send( $newBooking->getClient()->getEmail(), $newBooking->getclient()->getFullName(), 'Votre rendez-vous est pris' , $content);
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

}
