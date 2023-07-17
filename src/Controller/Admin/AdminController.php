<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        $admin = $this->getUser();
       $users = $userRepository->findAll();


        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'admin' => $admin,

        ]);
    }
    #[Route('/delete/{id}', name: 'user_delete', methods: ['POST', 'GET'])]
    public function delete(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable');
        }

        $userRepository->remove($user, true);
        $this->addFlash('success', 'Utilisateur supprimé');
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}
