<?php

namespace App\Dto;

use Exception;

final class SubscriptionDto
{
    private string $email;
    private array $restaurants;

    /**
     * @param string $email
     * @param RestaurantDto[] $restaurants
     * @throws Exception
     */
    public function __construct(string $email, array $restaurants)
    {
        $this->email = $email;

        foreach ($restaurants as $restaurant) {
            if (!$restaurant instanceof RestaurantDto) {
                throw new Exception();
            }
        }

        $this->restaurants = $restaurants;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return RestaurantDto[]
     */
    public function getRestaurants(): array
    {
        return $this->restaurants;
    }
}