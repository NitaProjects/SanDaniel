<?php

namespace App\Controllers;

use App\School\Services\DegreeService;
use App\Infrastructure\Routing\Request;

class DegreeController
{
    private DegreeService $degreeService;

    public function __construct(DegreeService $degreeService)
    {
        $this->degreeService = $degreeService;
    }

    /**
     * Añadir una nueva titulación.
     */
    public function addDegree(Request $request): void
    {
        try {
            $data = $request->getBody();
            $name = $data['name'] ?? null;
            $durationYears = $data['durationYears'] ?? null;

            if (!$name || !$durationYears) {
                throw new \InvalidArgumentException("Name and duration years are required.");
            }

            $degree = $this->degreeService->addDegree($name, (int)$durationYears);
            http_response_code(201); // Created
            echo json_encode([
                'id' => $degree->getId(),
                'name' => $degree->getName(),
                'durationYears' => $degree->getDurationYears(),
            ]);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener una titulación por ID.
     */
    public function getDegreeById(Request $request, int $id): void
    {
        try {
            $degree = $this->degreeService->getDegreeById($id);

            if (!$degree) {
                http_response_code(404);
                echo json_encode(['error' => 'Degree not found.']);
                return;
            }

            http_response_code(200); // OK
            echo json_encode([
                'id' => $degree->getId(),
                'name' => $degree->getName(),
                'durationYears' => $degree->getDurationYears(),
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener todas las titulaciones.
     */
    public function getAllDegrees(): void
    {
        try {
            $degrees = $this->degreeService->getAllDegrees();
            http_response_code(200); // OK
            echo json_encode(array_map(fn($degree) => [
                'id' => $degree->getId(),
                'name' => $degree->getName(),
                'durationYears' => $degree->getDurationYears(),
            ], $degrees));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Eliminar una titulación por ID.
     */
    public function deleteDegree(Request $request, int $id): void
    {
        try {
            $this->degreeService->deleteDegree($id);
            http_response_code(204); // No Content
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }
}
