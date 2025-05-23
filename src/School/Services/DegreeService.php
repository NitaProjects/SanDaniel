<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\IDegreeRepository;
use App\School\Entities\Degree;

class DegreeService
{
    private IDegreeRepository $degreeRepository;

    public function __construct(IDegreeRepository $degreeRepository)
    {
        $this->degreeRepository = $degreeRepository;
    }

    public function addDegree(string $name, int $durationYears): Degree
    {
        $degree = new Degree($name, $durationYears);
        $this->degreeRepository->add($degree); // Usamos add en el repositorio para insertar.
        return $degree;
    }

    public function updateDegree(int $id, string $name, int $durationYears): void
    {
        $degree = $this->getDegreeById($id);

        if (!$degree) {
            throw new \Exception("Degree with ID $id not found.");
        }

        $degree->setName($name)
               ->setDurationYears($durationYears);

        $this->degreeRepository->update($degree); // Usamos update en el repositorio para actualizar.
    }

    public function getDegreeById(int $id): ?Degree
    {
        return $this->degreeRepository->findById($id);
    }

    public function deleteDegree(int $id): void
    {
        $this->degreeRepository->delete($id);
    }

    public function getAllDegrees(): array
    {
        return $this->degreeRepository->getAll();
    }
}
