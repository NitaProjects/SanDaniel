<?php

namespace App\School\Entities;

use App\School\Trait\Timestampable;
use App\School\Entities\Department;

class Teacher extends User
{
    use Timestampable;

    protected ?Department $department = null;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $userType
    ) {
        parent::__construct($firstName, $lastName, $email, $password, $userType);
        $this->updateTimestamps();
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function addToDepartment(Department $department): self
    {
        $this->department = $department;
        return $this;
    }
}
