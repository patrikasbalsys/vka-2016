<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cord;
use AppBundle\Form\CordType;
use AppBundle\Form\ParacordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CordController
 *
 * @Route("/admin")
 */
class CordController extends Controller
{
    /**
     * @Route("/cord/new", name="cord_new")
     */
    public function newAction(Request $request)
    {
        $cord = new Cord();

        $form = $this->createForm(CordType::class, $cord);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($cord);
            $em->flush();

            return $this->redirectToRoute('cord_list');
        }

        return $this->render('cord/new.html.twig', array(
            'quote' => "Add a new Cord",
            'form' => $form->createView(),

        ));
    }

    /**
     * @Route("/cords", name="cord_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cords = $em->getRepository('AppBundle:Cord')
            ->findAll();

        return $this->render('cord/list.html.twig', array(
            'cords' => $cords
        ));
    }

    /**
     * @Route("/cord/delete/{cord}", name="cord_delete")
     */
    public function  deleteAction(Request $request, Cord $cord)
    {

        $form = $this->createFormBuilder($cord)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cord);
            $em->flush();

            return $this->redirectToRoute('cord_list');
        }

        // Default return
        return $this->render('cord/delete.html.twig', [
            'cord' => $cord,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/cord/edit/{cord}", name="cord_edit")
     */
    public function editAction(Request $request, Cord $cord)
    {

        // Create our form
        $form = $this->createForm(CordType::class, $cord);


        // Handling a form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('cord_list');
        }

        // Default return
        return $this->render('cord/new.html.twig', [
            'cord' => $cord,
            'form' => $form->createView(),
            'quote' => 'Edit a Cord',
            'subQuote' => 'Edit an entity:',
        ]);

    }

}
