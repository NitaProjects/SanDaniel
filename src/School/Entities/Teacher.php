<?php

namespace App\School\Entities;

use App\School\Trait\Timestampable;

class Student extends User
{
    use Timestampable;

    protected array $enrollments = [];
    protected string $dni;
    protected int $enrollmentYear;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $userType,
        string $dni,
        int $enrollmentYear
    ) {
        parent::__construct($firstName, $lastName, $email, $password, $userType);
        $this->dni = $dni;
        $this->enrollmentYear = $enrollmentYear;
        $this->updateTimestamps();
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;
        return $this;
    }

    public function getEnrollmentYear(): int
    {
        return $this->enrollmentYear;
    }

    public function setEnrollmentYear(int $enrollmentYear): self
    {
        $this->enrollmentYear = $enrollmentYear;
        return $this;
    }

    public function getEnrollments(): array
    {
        return $this->enrollments;
    }

    public function addEnrollment($enrollment): self
    {
        $this->enrollments[] = $enrollment;
        return $this;
    }
}
