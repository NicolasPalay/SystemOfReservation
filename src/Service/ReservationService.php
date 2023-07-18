<?php

namespace App\Service;

use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Response;

class ReservationService
{
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