<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\IsTrue;
use Psr\Log\LoggerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/new/user", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $logger->info($user->getUsername() . ' is registered.');
            $this->addFlash('success', 'User Created!');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/account.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

     /**
     * @Route("/edit/user/{id}", name="editUser")
     */
    public function edit(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createFormBuilder($user)
        ->add('email')
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('firstName')
        ->add('lastName')
        ->add('birthdate', BirthdayType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            // $this->addFlash('success your account was edited.');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/account.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Show a video entity.
     *
     * @Route("/users", name="showUsers")
     *
     */
    public function show(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager()->getRepository(User::class);
        $users = $em->findAll();

        return $this->render('security/usersList.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Delete a userity.
     *
     * @Route("/delete/user/{id}", name="deleteUser")
     *
     */
    public function delete(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        if (!$id) {
            throw $this->createNotFoundException('No user found');
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->find(User::class, $id);
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', $user->getFirstName() . ' was deleted.');

        return $this->redirectToRoute('home');
    }
}
