<?php

namespace App\Dto;

final class MealDTO
{
    private string $name;
    private int $price;

    /**
     * @param string $name
     * @param int $price
     */
    public function __construct(string $name, int $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}