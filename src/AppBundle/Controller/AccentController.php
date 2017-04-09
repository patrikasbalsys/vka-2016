<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accent;
use AppBundle\Form\AccentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccentController
 *
 * @Route("/admin")
 */
class AccentController extends Controller
{
    /**
     * @Route("/accent/new", name="accent_new")
     */
    public function newAction(Request $request)
    {
        $accent = new Accent();

        $form = $this->createForm(AccentType::class, $accent);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($accent);
            $em->flush();

            return $this->redirectToRoute('accent_list');
        }

        return $this->render('accent/new.html.twig', array(
            'quote' => "Add a new Accent",
            'form' => $form->createView(),

        ));
    }

    /**
     * @Route("/accents", name="accent_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $accents = $em->getRepository('AppBundle:Accent')
            ->findAll();

        return $this->render('accent/list.html.twig', array(
            'accents' => $accents
        ));
    }

    /**
     * @Route("/accent/delete/{accent}", name="accent_delete")
     */
    public function  deleteAction(Request $request, Accent $accent)
    {

        $form = $this->createFormBuilder($accent)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accent);
            $em->flush();

            return $this->redirectToRoute('accent_list');
        }

        // Default return
        return $this->render('accent/delete.html.twig', [
            'accent' => $accent,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/accent/edit/{accent}", name="accent_edit")
     */
    public function editAction(Request $request, Accent $accent)
    {

        // Create our form
        $form = $this->createForm(AccentType::class, $accent);


        // Handling a form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('accent_list');
        }

        // Default return
        return $this->render('accent/new.html.twig', [
            'accent' => $accent,
            'form' => $form->createView(),
            'quote' => 'Edit an Accent',
            'subQuote' => 'Edit an entity:',
        ]);

    }

}
