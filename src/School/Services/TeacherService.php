<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\ITeacherRepository;
use App\School\Entities\Teacher;

class TeacherService
{
    private ITeacherRepository $teacherRepository;

    public function __construct(ITeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function createTeacher(int $userId): Teacher
    {
        $teacher = new Teacher('', '', '', ''); // Los datos del usuario ya existen
        $teacher->setUserId($userId);

        $this->teacherRepository->save($teacher);
        return $teacher;
    }

    public function getTeacherById(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    public function getTeacherByUserId(int $userId): ?Teacher
    {
        return $this->teacherRepository->findByUserId($userId);
    }

    public function updateTeacher(int $id, int $userId): void
    {
        $teacher = $this->getTeacherById($id);

        if (!$teacher) {
            throw new \Exception("Teacher with ID $id not found.");
        }

        $teacher->setUserId($userId);
        $this->teacherRepository->save($teacher);
    }

    public function deleteTeacher(int $id): void
    {
        $this->teacherRepository->delete($id);
    }

    public function getAllTeachers(): array
    {
        return $this->teacherRepository->getAll();
    }
}
