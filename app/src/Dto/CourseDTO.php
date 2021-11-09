<?php

namespace App\Dto;

final class CourseDTO
{
    private string $course;

    /**
     * @var MealDTO[]
     */
    private array $meals;

    /**
     * @param string $course
     * @param MealDTO[] $meals
     */
    public function __construct(string $course, array $meals)
    {
        $this->course = $course;

        // Check if all meals are instance of MealDTO
        foreach ($meals as $meal) {
            if (!$meal instanceof MealDTO) {
                throw new \DomainException;
            }
        }

        $this->meals = $meals;
    }

    /**
     * @return string
     */
    public function getCourse(): string
    {
        return $this->course;
    }

    /**
     * @return MealDTO[]
     */
    public function getMeals(): array
    {
        return $this->meals;
    }
}