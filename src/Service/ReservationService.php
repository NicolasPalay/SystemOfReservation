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
            ];
        }

        $data = json_encode($rdvs);
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
}