<?php

namespace App\School\Entities;

use App\School\Trait\Timestampable;

class Student extends User
{
    use Timestampable;


    protected int $id;
    protected ?int $userId = null; 
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
        int $enrollmentYear,
        ?int $userId = null // Añade el userId al constructor
    ) {
        parent::__construct($firstName, $lastName, $email, $password, $userType);
        $this->dni = $dni;
        $this->enrollmentYear = $enrollmentYear;
        $this->userId = $userId; // Asigna el userId
        $this->updateTimestamps();
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    // Métodos para manejar el ID del estudiante
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    // Métodos para manejar el DNI
    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;
        return $this;
    }

    // Métodos para manejar el año de inscripción
    public function getEnrollmentYear(): int
    {
        return $this->enrollmentYear;
    }

    public function setEnrollmentYear(int $enrollmentYear): self
    {
        $this->enrollmentYear = $enrollmentYear;
        return $this;
    }

    // Métodos para manejar las inscripciones (enrollments)
    public function getEnrollments(): array
    {
        return $this->enrollments;
    }

    public function addEnrollment(Enrollment $enrollment): self
    {
        $this->enrollments[] = $enrollment;
        return $this;
    }

    // Métodos para manejar las asignaturas (subjects)
    public function getSubjects(): array
    {
        return array_map(fn($enrollment) => $enrollment->getSubject(), $this->enrollments);
    }

    public function addSubject(Subject $subject): self
    {
        $enrollment = new Enrollment($this, $subject, new \DateTime());
        $this->addEnrollment($enrollment);
        return $this;
    }
}
