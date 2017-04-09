<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accent;
use AppBundle\Entity\Cord;
use AppBundle\Form\AntiqueShopType;
use AppBundle\Form\CordType;
use AppBundle\Form\JesterShopType;
use AppBundle\Form\MonkeyShopType;
use AppBundle\Form\OrderType;
use AppBundle\Form\ParacordType;
use AppBundle\Form\ShopType;
use AppBundle\Form\SolomonShopType;
use AppBundle\Form\ThimbleShopType;
use AppBundle\Form\TrioShopType;
use AppBundle\Form\TripleInfiShopType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class CordController
 *
 * @Route("/shop")
 */
class ShopController extends Controller
{
    /**
     * @Route("/all", name="all_shop")
     */
    public function allAction()
    {
        return $this->render('shop/all.html.twig', array(
        ));
    }

    /**
     * @Route("/clear_cart", name="clear_cart")
     */
    public function clearCartAction()
    {
        $session = new Session();

        $session->clear('shoppingCart');

        return $this->render('shop/shopCart.html.twig', array(
            'cart' => null
        ));
    }

    /**
     * @Route("/cart", name="cart_shop")
     * @param Request $request
     * @return Response
     */
    public function cartAction(Request $request)
    {
        $cart = $this->get('session')->get('shoppingCart');
        $carts = $this->get('session')->get('shoppingCart');

        //Create form
        $form = $this->createForm(OrderType::class)
            ->add('save', SubmitType::class, ['label' => 'Proceed to Checkout']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->get('user')->getData();

            return $this->redirectToRoute('checkout_shop', array(
                'user' => $user
            ));
        }

        return $this->render('shop/shopCart.html.twig', array(
            'form' => $form->createView(),
            'cart' => $cart,
            'carts' => $carts
        ));
    }

    /**
     * @Route("/checkout/{user}", name="checkout_shop")
     * @param $user
     * @return Response
     */
    public function checkoutAction($user)
    {
        $cart = $this->get('session')->get('shoppingCart');
        $carts = $this->get('session')->get('shoppingCart');

        $ordernumber = rand(100000,999999);
        $message = \Swift_Message::newInstance()
            ->setSubject('Order ' . $ordernumber . ' Placed')
            ->setFrom(array('paraweaveshop@gmail.com' => 'Paraweave'))
            ->setTo('ultimatepixelmc@gmail.com')
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/order.html.twig',
                    array(
                        'ordernumber' => $ordernumber,
                        'user' => $user,
                        'cart' => $cart,
                        'carts' => $carts
                        )
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        $session = new Session();

        $session->invalidate();

        return $this->render('shop/shopCheckout.html.twig', array(
            'ordernumber' => $ordernumber
        ));
    }

    /**
     * @Route("/trio", name="trio_shop")
     * @param Request $request
     * @return Response
     */
    public function trioAction(Request $request)
    {
        $form = $this->createForm(TrioShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = new Session();
            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }
            $accent = $form->get('accent')->getData();
            $cord1 = $form->get('color1')->getData();
            $cart[] = [
                'model' => 'Trio',
                'color1' => $cord1->getColor(),
                'color2' => '',
                'color3' => '',
                'accent' => $accent->getModel(),
                'size' => '',
                'quantity' => $form->get('quantity')->getData(),
                'price' => (3 + $accent->getPrice() + $cord1->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);

            return $this->redirectToRoute('cart_shop');
        }
        return $this->render('shop/trio.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/antique", name="antique_shop")
     * @param Request $request
     * @return Response
     */
    public function antiqueAction(Request $request)
    {
        //Create form
        $form = $this->createForm(AntiqueShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $accent = $form->get('accent')->getData();
            $cord1 = $form->get('color1')->getData();

            $cart[] = [
                'model' => 'Antique',
                'color1' => $cord1->getColor(),
                'color2' => '',
                'color3' => '',
                'accent' => $accent->getModel(),
                'size' => '',
                'quantity' => $form->get('quantity')->getData(),
                'price' => (3 + $accent->getPrice() + $cord1->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);

            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/antique.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/jester", name="jester_shop")
     * @param Request $request
     * @return Response
     */
    public function jesterAction(Request $request)
    {
        //Create form
        $form = $this->createForm(JesterShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $accent = $form->get('accent')->getData();
            $cord1 = $form->get('color1')->getData();

            $cart[] = [
                'model' => 'Jester',
                'color1' => $cord1->getColor(),
                'color2' => '',
                'color3' => '',
                'accent' => $accent->getModel(),
                'size' => '',
                'quantity' => $form->get('quantity')->getData(),
                'price' => (3 + $accent->getPrice() + $cord1->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);

            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/jester.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/thimble", name="thimble_shop")
     * @param Request $request
     * @return Response
     */
    public function thimbleAction(Request $request)
    {
        //Create form
        $form = $this->createForm(ThimbleShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $accent = $form->get('accent')->getData();
            $cord1 = $form->get('color1')->getData();

            $cart[] = [
                'model' => 'Thimble',
                'color1' => $cord1->getColor(),
                'color2' => '',
                'color3' => '',
                'accent' => $accent->getModel(),
                'size' => '',
                'quantity' => $form->get('quantity')->getData(),
                'price' => (3 + $accent->getPrice() + $cord1->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);

            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/thimble.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/solomon", name="solomon_shop")
     * @param Request $request
     * @return Response
     */
    public function solomonAction(Request $request)
    {
        //Create form
        $form = $this->createForm(SolomonShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $cord1 = $form->get('color1')->getData();
            $cord2 = $form->get('color2')->getData();

            $cart[] = [
                'model' => 'Solomon',
                'color1' => $cord1->getColor(),
                'color2' => $cord2->getColor(),
                'color3' => '',
                'accent' => '',
                'size' => $form->get('size')->getData(),
                'quantity' => $form->get('quantity')->getData(),
                'price' => (4 + $cord1->getPrice() + $cord2->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);

            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/solomon.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/thinline", name="thinline_shop")
     * @param Request $request
     * @return Response
     */
    public function thinlineAction(Request $request)
    {
        //Create form
        $form = $this->createForm(SolomonShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $cord1 = $form->get('color1')->getData();
            $cord2 = $form->get('color2')->getData();

            $cart[] = [
                'model' => 'Thinline',
                'color1' => $cord1->getColor(),
                'color2' => $cord2->getColor(),
                'color3' => '',
                'accent' => '',
                'size' => $form->get('size')->getData(),
                'quantity' => $form->get('quantity')->getData(),
                'price' => (4 + $cord1->getPrice() + $cord2->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);


            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/thinline.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/snake", name="snake_shop")
     * @param Request $request
     * @return Response
     */
    public function snakeAction(Request $request)
    {
        //Create form
        $form = $this->createForm(SolomonShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $cord1 = $form->get('color1')->getData();
            $cord2 = $form->get('color2')->getData();

            $cart[] = [
                'model' => 'Snake',
                'color1' => $cord1->getColor(),
                'color2' => $cord2->getColor(),
                'color3' => '',
                'accent' => '',
                'size' => $form->get('size')->getData(),
                'quantity' => $form->get('quantity')->getData(),
                'price' => (6 + $cord1->getPrice() + $cord2->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);


            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/snake.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/monkey", name="monkey_shop")
     * @param Request $request
     * @return Response
     */
    public function monkeyAction(Request $request)
    {
        //Create form
        $form = $this->createForm(MonkeyShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $cord1 = $form->get('color1')->getData();

            $cart[] = [
                'model' => 'Monkey',
                'color1' => $cord1->getColor(),
                'color2' => '',
                'color3' => '',
                'accent' => '',
                'size' => '',
                'quantity' => $form->get('quantity')->getData(),
                'price' => (4 + $cord1->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);


            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/monkey.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/doubleInfi", name="doubleInfi_shop")
     * @param Request $request
     * @return Response
     */
    public function doubleInfiAction(Request $request)
    {
        //Create form
        $form = $this->createForm(SolomonShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $cord1 = $form->get('color1')->getData();
            $cord2 = $form->get('color2')->getData();

            $cart[] = [
                'model' => 'Double Infi',
                'color1' => $cord1->getColor(),
                'color2' => $cord2->getColor(),
                'color3' => '',
                'accent' => '',
                'size' => $form->get('size')->getData(),
                'quantity' => $form->get('quantity')->getData(),
                'price' => (4 + $cord1->getPrice() + $cord2->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);


            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/doubleInfi.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/tripleInfi", name="tripleInfi_shop")
     * @param Request $request
     * @return Response
     */
    public function tripleInfiAction(Request $request)
    {
        //Create form
        $form = $this->createForm(TripleInfiShopType::class)
            ->add('save', SubmitType::class, ['label' => 'Add to Cart']);;

        //Handling the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = new Session();

            $cart = $session->get('shoppingCart');
            if ($cart == null) {
                $cart = [];
            }

            $cord1 = $form->get('color1')->getData();
            $cord2 = $form->get('color2')->getData();
            $cord3 = $form->get('color3')->getData();

            $cart[] = [
                'model' => 'Triple Infi',
                'color1' => $cord1->getColor(),
                'color2' => $cord2->getColor(),
                'color3' => $cord3->getColor(),
                'accent' => '',
                'size' => $form->get('size')->getData(),
                'quantity' => $form->get('quantity')->getData(),
                'price' => (5 + $cord1->getPrice() + $cord2->getPrice() + $cord3->getPrice()) * $form->get('quantity')->getData()

            ];
            $session->set('shoppingCart', $cart);


            return $this->redirectToRoute('cart_shop');
        }

        return $this->render('shop/tripleInfi.html.twig', array(
            'form' => $form->createView()
        ));
    }

}











