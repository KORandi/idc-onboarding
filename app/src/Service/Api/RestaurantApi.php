<?php

namespace App\Service\Api;

use App\Dto\CourseDto;
use App\Dto\GpsDto;
use App\Dto\MealDto;
use App\Dto\MenuDto;
use App\Dto\RestaurantDto;
use DateTimeImmutable;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RestaurantApi
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return RestaurantDto[]
     *@throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function fetchRestaurants(): array
    {
        $response = $this->httpClient->request(
            "GET",
            "https://private-anon-8e6c12d538-idcrestaurant.apiary-mock.com/restaurant"
        );
        $content = $response->toArray(true);
        $restaurants = [];
        foreach ($content as $restaurant) {
            $restaurants[] = $this->getRestaurantDto($restaurant);
        }
        return $restaurants;
    }

    /**
     * @return MenuDto[]
     *@throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    public function fetchMenu(int $restaurantID): array
    {
        $response = $this->httpClient->request(
            "GET",
            "https://private-anon-8e6c12d538-idcrestaurant.apiary-mock.com/daily-menu?restaurant_id=$restaurantID"
        );
        $content = $response->toArray(true);

        $menus = [];
        foreach ($content as $menu) {
            $menus[] = $this->getMenuDto($menu);
        }
        return $menus;
    }

    private function getRestaurantDto($restaurant): RestaurantDto
    {
        $gps = $restaurant["gps"];
        return new RestaurantDto(
            $restaurant["id"],
            $restaurant["name"],
            $restaurant["address"],
            $restaurant["url"],
            new GpsDto(
                $gps["lat"],
                $gps["lng"]
            )
        );
    }

    /**
     * @throws Exception
     */
    private function getMenuDto($menu): MenuDto
    {
        $courses = [];
        foreach ($menu["courses"] as $course) {
            $courses[] = $this->getCourseDto($course);
        }
        return new MenuDto(
            new DateTimeImmutable($menu["date"]),
            $courses,
            $menu["note"]
        );
    }

    private function getCourseDto($course): CourseDto {
        $meals = [];
        foreach ($course["meals"] as $meal) {
            $meals[] = $this->getMealDto($meal);
        }
        return new CourseDto(
            $course["course"],
            $meals
        );
    }

    private function getMealDto($meal): MealDto {
        return new MealDto(
            $meal["name"],
            $meal["price"]
        );
    }
}