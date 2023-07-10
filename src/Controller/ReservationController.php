<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(CalendarRepository $calendarRepository): Response
    {
        $events=$calendarRepository->findAll();
        $rdvs=[];
        foreach($events as $event){
           $rdvs[]=[
               'id'=>$event->getId(),
               'start'=>$event->getStart()->format('Y-m-d H:i:s'),
               'end'=>$event->getEnd()->format('Y-m-d H:i:s'),
               'title'=>$event->getName(),
               'backgroundColor'=>$event->getColor(),
               'textColor'=>$event->getTextColor(),
           ];
        }
        $data=json_encode($rdvs);
        return $this->render('reservation/index.html.twig', compact('data'));
    }
}
