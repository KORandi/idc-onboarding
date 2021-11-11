<?php

namespace App\Dto;

use Exception;

final class RestaurantDto
{
    private int $id;
    private string $name;
    private string $address;
    private string $url;
    private GpsDto $gps;

    /**
     * @var MenuDto[] | null
     */
    private ?array $menus;

    /**
     * @param int $id
     * @param string $name
     * @param string $address
     * @param string $url
     * @param GpsDto $gps
     * @param MenuDto[] | null
     * @throws Exception
     */
    public function __construct(int $id, string $name, string $address, string $url, GpsDto $gps, ?array $menus)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->url = $url;
        $this->gps = $gps;

        foreach ($menus as $menu) {
            if (!$menu instanceof MenuDto) {
                throw new Exception;
            }
        }

        $this->menus = $menus;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return GpsDto
     */
    public function getGps(): GpsDto
    {
        return $this->gps;
    }

    /**
     * @return MenuDto[]|null
     */
    public function getMenus(): ?array
    {
        return $this->menus;
    }
}