<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\IDepartmentRepository;
use App\School\Entities\Department;

class DepartmentService
{
    private IDepartmentRepository $departmentRepository;

    public function __construct(IDepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function createDepartment(string $name): Department
    {
        $department = new Department($name);
        $this->departmentRepository->add($department); // Cambiado a `add` en lugar de `save`.

        return $department;
    }

    public function updateDepartment(int $id, string $name): void
    {
        $department = $this->getDepartmentById($id);

        if (!$department) {
            throw new \Exception("Department with ID $id not found.");
        }

        $department->setName($name);
        $this->departmentRepository->update($department); // Cambiado a `update`.
    }

    public function getDepartmentById(int $id): ?Department
    {
        return $this->departmentRepository->findById($id);
    }

    public function deleteDepartment(int $id): void
    {
        $this->departmentRepository->delete($id);
    }

    public function getAllDepartments(): array
    {
        return $this->departmentRepository->getAll();
    }
}
