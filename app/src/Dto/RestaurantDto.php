<?php

namespace App\Dto;

final class RestaurantDto
{
    private int $id;
    private string $name;
    private string $address;
    private string $url;
    private GpsDto $gps;

    /**
     * @param int $id
     * @param string $name
     * @param string $address
     * @param string $url
     * @param GpsDto $gps
     */
    public function __construct(int $id, string $name, string $address, string $url, GpsDto $gps)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->url = $url;
        $this->gps = $gps;
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

}