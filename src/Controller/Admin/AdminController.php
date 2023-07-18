<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository, ReservationService $reservationService, BookingRepository $bookingRepository): Response
    {

        $data = $reservationService->reservation($bookingRepository);
        $admin = $this->getUser();
       $users = $userRepository->findAll();


        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'admin' => $admin,
            'data' => $data->getContent(),

        ]);
    }


    #[Route('/admin/user', name: 'app_admin_user')]
    #[IsGranted('ROLE_ADMIN')]
    public function userAdmin(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();


        return $this->render('admin/user/index.html.twig', [
            'users' => $users,


        ]);
    }
    #[Route('delete/{id}', name: 'user_delete', methods: ['POST', 'GET'])]
    public function delete(User $user, UserRepository $userRepository): Response

    {
        $user = $userRepository->find(['id' => $user->getId()]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable');
        }

        $userRepository->remove($user, true);
        $this->addFlash('success', 'Utilisateur supprimé');
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}
