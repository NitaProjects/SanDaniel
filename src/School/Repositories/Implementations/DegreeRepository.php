<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Degree;
use App\School\Repositories\Interfaces\IDegreeRepository;
use PDO;

class DegreeRepository implements IDegreeRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Degree $degree): void
    {
        if ($degree->getId()) {
            // Actualizar titulación existente
            $stmt = $this->db->prepare("
                UPDATE degrees SET 
                    name = :name,
                    duration_years = :duration_years
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $degree->getId());
        } else {
            // Crear nueva titulación
            $stmt = $this->db->prepare("
                INSERT INTO degrees (name, duration_years)
                VALUES (:name, :duration_years)
            ");
        }

        $stmt->bindValue(':name', $degree->getName());
        $stmt->bindValue(':duration_years', $degree->getDurationYears());
        $stmt->execute();
    }

    public function findById(int $id): ?Degree
    {
        $stmt = $this->db->prepare("SELECT * FROM degrees WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToDegree($data) : null;
    }

    public function findByDurationYears(int $years): array
    {
        $stmt = $this->db->prepare("SELECT * FROM degrees WHERE duration_years = :duration_years");
        $stmt->bindValue(':duration_years', $years);
        $stmt->execute();

        $degrees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToDegree'], $degrees);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM degrees WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM degrees");
        $degrees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToDegree'], $degrees);
    }

    private function mapToDegree(array $data): Degree
{
    // Pasar los dos argumentos requeridos
    $degree = new Degree($data['name'], $data['duration_years']);
    $degree->setId($data['id']); // Asignar el ID, si es necesario

    return $degree;
}

}
