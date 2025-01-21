<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\AssignTeacherToDepartmentService;

class AssignTeacherController
{
    private AssignTeacherToDepartmentService $assignTeacherService;

    public function __construct(AssignTeacherToDepartmentService $assignTeacherService)
    {
        $this->assignTeacherService = $assignTeacherService;
    }

    /**
     * Mostrar la página de asignación de profesores a departamentos.
     */
    public function assignTeacherPage(): void
    {
        try {
            $teachers = $this->assignTeacherService->getAllTeachers();
            $departments = $this->assignTeacherService->getAllDepartments();

            echo view('assign-teacher', [
                'teachers' => $teachers,
                'departments' => $departments,
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo "Error al cargar la página de asignación: " . $e->getMessage();
        }
    }

    /**
     * Asignar un profesor a un departamento.
     */
    public function assignDepartmentToTeacher(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['teacher_id']) || empty($data['teacher_id'])) {
                throw new \InvalidArgumentException("El campo teacher_id es obligatorio.");
            }

            if (!isset($data['department_id']) || empty($data['department_id'])) {
                throw new \InvalidArgumentException("El campo department_id es obligatorio.");
            }

            $this->assignTeacherService->assignDepartmentToTeacher(
                (int)$data['teacher_id'],
                (int)$data['department_id']
            );

            http_response_code(201);
            echo json_encode(['message' => 'Profesor asignado correctamente.']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error interno del servidor.', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Eliminar un departamento asignado a un profesor.
     */
    public function removeDepartmentFromTeacher(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['teacher_id']) || empty($data['teacher_id'])) {
                throw new \InvalidArgumentException("El campo teacher_id es obligatorio.");
            }

            if (!isset($data['department_id']) || empty($data['department_id'])) {
                throw new \InvalidArgumentException("El campo department_id es obligatorio.");
            }

            $this->assignTeacherService->removeDepartmentFromTeacher(
                (int)$data['teacher_id'],
                (int)$data['department_id']
            );

            http_response_code(204);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error interno del servidor.', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Obtener todas las asignaciones de profesores a departamentos.
     */
    public function getTeacherDepartments(): void
    {
        try {
            $assignments = $this->assignTeacherService->getTeacherDepartments();
            echo json_encode($assignments);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
