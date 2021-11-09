<?php

namespace App\Dto;

final class CourseDto
{
    private string $course;

    /**
     * @var MealDto[]
     */
    private array $meals;

    /**
     * @param string $course
     * @param MealDto[] $meals
     */
    public function __construct(string $course, array $meals)
    {
        $this->course = $course;

        // Check if all meals are instance of MealDto
        foreach ($meals as $meal) {
            if (!$meal instanceof MealDto) {
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
     * @return MealDto[]
     */
    public function getMeals(): array
    {
        return $this->meals;
    }
}