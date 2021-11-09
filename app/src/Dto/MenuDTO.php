<?php

namespace App\Dto;

use DateTimeImmutable;
use DomainException;

final class MenuDTO
{
    private DateTimeImmutable $date;

    /**
     * @var CourseDTO[]
     */
    private array $courses;
    private string $note;

    /**
     * @param DateTimeImmutable $date
     * @param CourseDTO[] $courses
     * @param string|null $note
     */
    public function __construct(DateTimeImmutable $date, array $courses, ?string $note)
    {
        $this->date = $date;

        // Check if all courses are instance of CourseDTO
        foreach ($courses as $course) {
            if (!$course instanceof CourseDTO) {
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
     * @return CourseDTO[]
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