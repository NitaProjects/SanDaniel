<?php

namespace App\Controllers;

use App\School\Services\DepartmentService;
use App\Infrastructure\Routing\Request;

class DepartmentController
{
    private DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function createDepartment(Request $request)
    {
        $data = $request->getBody();
        $name = $data['name'] ?? null;

        if (!$name) {
            http_response_code(400);
            echo json_encode(['error' => 'Department name is required']);
            return;
        }

        $department = $this->departmentService->createDepartment($name);
        echo json_encode($department);
    }

    public function getDepartmentById(Request $request, int $id)
    {
        $department = $this->departmentService->getDepartmentById($id);

        if (!$department) {
            http_response_code(404);
            echo json_encode(['error' => 'Department not found']);
            return;
        }

        echo json_encode($department);
    }

    public function getAllDepartments()
    {
        $departments = $this->departmentService->getAllDepartments();
        echo json_encode($departments);
    }

    public function deleteDepartment(Request $request, int $id)
    {
        $this->departmentService->deleteDepartment($id);
        http_response_code(204); // No Content
    }
}
