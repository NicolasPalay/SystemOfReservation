<?php

namespace App\Service;

use App\Entity\Hairdresser;
use App\Entity\Speciality;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Response;

class ReservationService
{
    private BookingRepository $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function isSlotAvailable(\DateTimeInterface $dateTime, Hairdresser $hairdresser, Speciality $speciality): bool
    {
        $existingBooking = $this->bookingRepository->findOneBy([
            'date' => $dateTime,
            'hairdresser' => $hairdresser,
            'speciality' => $speciality,
        ]);

        return !$existingBooking; // Si $existingBooking est null, alors le créneau est disponible.
    }


    public function reservation(BookingRepository $bookingRepository): Response {

        $events = $bookingRepository->findAll();
        $rdvs = [];

        foreach ($events as $event) {
            $start = $event->getDate();
            $end = clone $start;
            $duration = $event->getSpeciality()->getDuration();
            $hairdresser = $event->getHairdresser();

            if ($hairdresser->getId() == $events[0]->getHairdresser()->getId()) {
                $backgroundColor = 'orange';
                $titleName = $hairdresser->getUser()->getFullname();
            } elseif ($hairdresser->getId() == $events[1]->getHairdresser()->getId()) {
                $backgroundColor = 'blue';
                $titleName = $hairdresser->getUser()->getFullname();
            } elseif ($hairdresser->getId() == $events[2]->getHairdresser()->getId()) {
                $backgroundColor = 'grey';
                $titleName = $hairdresser->getUser()->getFullname();
            }

            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $start->format('Y-m-d H:i:s'),
                $end = $end->modify("+{$duration} minutes"),
                'end' => $end->format('Y-m-d H:i:s'),
                'backgroundColor' => $backgroundColor,
                'title' => $titleName
            ];
        }

        $data = json_encode($rdvs);
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
}