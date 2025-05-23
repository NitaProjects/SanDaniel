<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Department;
use App\School\Repositories\Interfaces\IDepartmentRepository;
use PDO;

class DepartmentRepository implements IDepartmentRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function add(Department $department): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO departments (name)
            VALUES (:name)
        ");
        $stmt->bindValue(':name', $department->getName());
        $stmt->execute();

        // Obtener el ID generado y asignarlo al objeto
        $department->setId((int)$this->db->lastInsertId());
    }

    public function update(Department $department): void
    {
        if (!$department->getId()) {
            throw new \InvalidArgumentException("Cannot update a department without an ID.");
        }

        $stmt = $this->db->prepare("
            UPDATE departments SET 
                name = :name
            WHERE id = :id
        ");
        $stmt->bindValue(':id', $department->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $department->getName());
        $stmt->execute();
    }

    public function findById(int $id): ?Department
    {
        $stmt = $this->db->prepare("SELECT * FROM departments WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToDepartment($data) : null;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM departments WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM departments");
        $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToDepartment'], $departments);
    }

    private function mapToDepartment(array $data): Department
    {
        $department = new Department($data['name']);
        $department->setId((int)$data['id']);

        return $department;
    }
}
