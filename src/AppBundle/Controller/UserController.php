<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class UserController
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @var Request request This is a request
     *
     * @Route("/add", name="user")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        //Create our user object
        $user = new User();
        $user
            ->setUsername('user')
            ->setPassword('password')
            ->setEmail('user@email.com')
        ;

        // Create our form
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create User'])
            ->getForm()
        ;

        // Handling a form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            dump($user);
            return new Response();
        }


        return $this->render('user/add.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);



    }
}
