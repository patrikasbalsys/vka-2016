<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Model;
use AppBundle\Form\ModelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ModelController
 *
 * @Route("/admin")
 */
class ModelController extends Controller
{
    /**
     * @Route("/model/new", name="model_new")
     */
    public function newAction(Request $request)
    {
        $model = new Model();

        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();

            return $this->redirectToRoute('model_list');
        }

        return $this->render('model/new.html.twig', array(
            'quote' => "Add a new Model",
            'form' => $form->createView(),

        ));
    }

    /**
     * @Route("/models", name="model_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $models = $em->getRepository('AppBundle:Model')
            ->findAll();

        return $this->render('model/list.html.twig', array(
            'models' => $models
        ));
    }

    /**
     * @Route("/delete/{model}", name="model_delete")
     */
    public function  deleteAction(Request $request, Model $model)
    {

        $form = $this->createFormBuilder($model)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($model);
            $em->flush();

            return $this->redirectToRoute('model_list');
        }

        // Default return
        return $this->render('model/delete.html.twig', [
            'model' => $model,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/model/edit/{model}", name="model_edit")
     */
    public function editAction(Request $request, Model $model)
    {

        // Create our form
        $form = $this->createForm(ModelType::class, $model);


        // Handling a form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('model_list');
        }

        // Default return
        return $this->render('model/new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
            'quote' => 'Edit a Model',
            'subQuote' => 'Edit an entity:',
        ]);

    }

}
