<?php

namespace App\Dto;

use DateTimeImmutable;
use DomainException;

final class MenuDto
{
    private DateTimeImmutable $date;

    /**
     * @var CourseDto[]
     */
    private array $courses;
    private string $note;

    /**
     * @param DateTimeImmutable $date
     * @param CourseDto[] $courses
     * @param string|null $note
     */
    public function __construct(DateTimeImmutable $date, array $courses, ?string $note)
    {
        $this->date = $date;

        // Check if all courses are instance of CourseDto
        foreach ($courses as $course) {
            if (!$course instanceof CourseDto) {
                throw new \DomainException;
            }
        }
        $this->courses = $courses;
        $this->note = $note;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return CourseDto[]
     */
    public function getCourses(): array
    {
        return $this->courses;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }
}