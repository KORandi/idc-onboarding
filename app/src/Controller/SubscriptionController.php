<?php

namespace App\Controller;

use App\Dto\RestaurantDto;
use App\Form\Type\RestaurantSubscriptionType;
use App\Service\Api\RestaurantApi;
use App\Service\EmailService;
use App\Service\MenuSubscription;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends BaseController
{
    /**
     * @Route("/menu-subscription", name="menu_subscription")
     */
    public function index(RestaurantApi $restaurantApi, Request $request, MenuSubscription $menuSubscription): Response
    {
        $restaurants = [];
        try {
            $restaurants = $restaurantApi->fetchRestaurants();
        } catch (Exception $e) {
            $message = $e->getMessage();
            $this->addFlash("error", "Couldn't receive list of restaurants due: $message");
        }

        $form = $this->createForm(RestaurantSubscriptionType::class, null, [
            "data" => array_reduce($restaurants, function($carry, RestaurantDto $restaurant) {
                $carry[$restaurant->getName()] = $restaurant;
                return $carry;
            }, [])
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $menuSubscription->processForm($data);
            return $this->redirectToRoute("menu_subscription_success");
        }

        return $this->render("subscription/index.html.twig", [
            "menu_sub_form" => $form->createView()
        ]);
    }

    /**
     * @Route("/menu-subscription/success", name="menu_subscription_success")
     */
    public function success(): Response
    {
        return $this->render("subscription/success.html.twig");
    }
}