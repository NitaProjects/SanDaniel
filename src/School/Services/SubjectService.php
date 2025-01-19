<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\ISubjectRepository;
use App\School\Entities\Subject;

class SubjectService
{
    private ISubjectRepository $subjectRepository;

    public function __construct(ISubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Crea una nueva asignatura.
     */
    public function createSubject(string $name, int $courseId): Subject
    {
        $subject = new Subject($name, $courseId);
        $this->subjectRepository->add($subject);
        return $subject;
    }

    /**
     * Obtiene una asignatura por su ID.
     */
    public function getSubjectById(int $id): ?Subject
    {
        return $this->subjectRepository->findById($id);
    }

    /**
     * Actualiza una asignatura existente.
     */
    public function updateSubject(int $id, string $name, int $courseId): void
    {
        $subject = $this->getSubjectById($id);

        if (!$subject) {
            throw new \Exception("Subject with ID $id not found.");
        }

        $subject->setName($name)
                ->setCourseId($courseId);

        $this->subjectRepository->update($subject);
    }

    /**
     * Elimina una asignatura por su ID.
     */
    public function deleteSubject(int $id): void
    {
        $this->subjectRepository->delete($id);
    }

    /**
     * Obtiene todas las asignaturas.
     */
    public function getAllSubjects(): array
    {
        return $this->subjectRepository->getAll();
    }
}
