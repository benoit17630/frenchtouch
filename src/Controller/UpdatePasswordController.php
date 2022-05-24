<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UpdatePwdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UpdatePasswordController extends AbstractController
{
    #[Route('/update/password', name: 'app_update_password')]
    public function index(Request $request,  UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): Response
    {
        $user =$this->getUser();

       $form = $this->createForm(UpdatePwdType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $password = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $manager->flush();



            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/update_password/index.html.twig', [
            "user"=> $user,
            'form'=>$form->createView()

        ]);
    }
}
