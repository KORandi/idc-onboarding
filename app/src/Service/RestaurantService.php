<?php

namespace App\Service;

use App\Dto\GpsDto;
use App\Dto\RestaurantDto;
use App\Service\Api\RestaurantApi;
use Exception;

class RestaurantService
{
    private RestaurantApi $restaurantApi;

    public function __construct(RestaurantApi $restaurantApi)
    {
        $this->restaurantApi = $restaurantApi;
    }


    /**
     * @param RestaurantDto[] $restaurants
     * @throws Exception
     */
    public function loadMenus(array $restaurants) {
        foreach ($restaurants as $restaurant) {
            if (!$restaurant instanceof RestaurantDto) {
                throw new Exception;
            }
        }

        $newRestaurants = [];
        foreach ($restaurants as $restaurant) {
            $newRestaurants[] = new RestaurantDto(
                $restaurant->getId(),
                $restaurant->getName(),
                $restaurant->getAddress(),
                $restaurant->getUrl(),
                $restaurant->getGps(),
                $this->restaurantApi->fetchMenus($restaurant->getId())
            );
        }
        return $newRestaurants;
    }
}