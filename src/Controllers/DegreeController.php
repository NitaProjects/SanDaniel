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

    public function createDegree(Request $request)
    {
        $data = $request->getBody();
        $name = $data['name'] ?? null;
        $durationYears = $data['durationYears'] ?? null;

        if (!$name || !$durationYears) {
            http_response_code(400);
            echo json_encode(['error' => 'Name and duration years are required']);
            return;
        }

        $degree = $this->degreeService->createDegree($name, (int)$durationYears);
        echo json_encode($degree);
    }

    public function getDegreeById(Request $request, int $id)
    {
        $degree = $this->degreeService->getDegreeById($id);

        if (!$degree) {
            http_response_code(404);
            echo json_encode(['error' => 'Degree not found']);
            return;
        }

        echo json_encode($degree);
    }

    public function getAllDegrees()
    {
        $degrees = $this->degreeService->getAllDegrees();
        echo json_encode($degrees);
    }

    public function deleteDegree(Request $request, int $id)
    {
        $this->degreeService->deleteDegree($id);
        http_response_code(204); // No Content
    }
}
