<?php

namespace App\Controller;

use App\Service\Api\RestaurantApi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(
        RestaurantApi $restaurantApi
    ): Response
    {
        $restaurants = [];
        try {
            $restaurants = $restaurantApi->fetchRestaurants();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->addFlash("error", "Couldn't receive list of restaurants due: $message");
        }
        return $this->render("restaurant/index.html.twig", [
            "restaurants" => $restaurants
        ]);
    }

    /**
     * @Route("/restaurant/{restaurantID}/menu", name="menu")
     */
    public function detail(
        int           $restaurantID,
        RestaurantApi $restaurantApi
    ): Response
    {
        $menus = [];
        try {
            $menus = $restaurantApi->fetchMenu($restaurantID);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->addFlash("error", "Couldn't receive menu due: $message");
        }
        return $this->render("restaurant/detail.html.twig", [
            "menus" => $menus
        ]);
    }
}