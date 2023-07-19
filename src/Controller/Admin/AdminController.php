<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminRegisterType;
use App\Form\BookType;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Service\ReservationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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



        return $this->render('admin/index.html.twig', [

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

    #[Route('/admin/user/edit/{id}', name: 'admin_user_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function update(User $user,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié');

            return $this->redirectToRoute('app_admin_user');
        }

        return $this->render('admin/user/registerAdmin.html.twig', [
            'form' => $form->createView(),
            'user' => $user,

        ]);
    }

    #[Route('/delete/{id}', name: 'user_delete', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(User $user, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($user->getId());

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé');
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}
