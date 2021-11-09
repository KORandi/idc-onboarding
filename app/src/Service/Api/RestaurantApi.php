<?php

namespace App\Service\Api;

use App\Dto\CourseDTO;
use App\Dto\GpsDTO;
use App\Dto\MealDTO;
use App\Dto\MenuDTO;
use App\Dto\RestaurantDTO;
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
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws DecodingExceptionInterface
     * @return RestaurantDTO[]
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
            $restaurants[] = $this->getRestaurantDTO($restaurant);
        }
        return $restaurants;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     * @return MenuDTO[]
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
            $menus[] = $this->getMenuDTO($menu);
        }
        return $menus;
    }

    private function getRestaurantDTO($restaurant): RestaurantDTO
    {
        $gps = $restaurant["gps"];
        return new RestaurantDTO(
            $restaurant["id"],
            $restaurant["name"],
            $restaurant["address"],
            $restaurant["url"],
            new GpsDTO(
                $gps["lat"],
                $gps["lng"]
            )
        );
    }

    /**
     * @throws Exception
     */
    private function getMenuDTO($menu): MenuDTO
    {
        $courses = [];
        foreach ($menu["courses"] as $course) {
            $courses[] = $this->getCourseDTO($course);
        }
        return new MenuDTO(
            new DateTimeImmutable($menu["date"]),
            $courses,
            $menu["note"]
        );
    }

    private function getCourseDTO($course): CourseDTO {
        $meals = [];
        foreach ($course["meals"] as $meal) {
            $meals[] = $this->getMealDTO($meal);
        }
        return new CourseDTO(
            $course["course"],
            $meals
        );
    }

    private function getMealDTO($meal): MealDTO {
        return new MealDTO(
            $meal["name"],
            $meal["price"]
        );
    }
}