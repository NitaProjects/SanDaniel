<?php

namespace App\School\Entities;

class Student extends User
{
    protected int $id;                
    protected int $userId;             
    protected string $dni;              
    protected int $enrollmentYear;      

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $dni,
        int $enrollmentYear,
        int $userId
    ) {
        parent::__construct($firstName, $lastName, $email, $password, 'student'); // Siempre 'student'
        $this->setUserId($userId);
        $this->setDni($dni);
        $this->setEnrollmentYear($enrollmentYear);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("ID must be a positive integer.");
        }
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("User ID must be a positive integer.");
        }
        $this->userId = $userId;
        return $this;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        if (empty($dni)) {
            throw new \InvalidArgumentException("DNI cannot be empty.");
        }
        $this->dni = $dni;
        return $this;
    }

    public function getEnrollmentYear(): int
    {
        return $this->enrollmentYear;
    }

    public function setEnrollmentYear(int $enrollmentYear): self
    {
        $currentYear = (int) date("Y");
        if ($enrollmentYear < 1900 || $enrollmentYear > $currentYear) {
            throw new \InvalidArgumentException("Enrollment year must be between 1900 and the current year.");
        }
        $this->enrollmentYear = $enrollmentYear;
        return $this;
    }
}
