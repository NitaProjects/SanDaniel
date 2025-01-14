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

    public function createSubject(string $name, int $courseId): Subject
    {
        $subject = new Subject($name, $courseId);
        $this->subjectRepository->save($subject);
        return $subject;
    }

    public function getSubjectById(int $id): ?Subject
    {
        return $this->subjectRepository->findById($id);
    }

    public function updateSubject(int $id, string $name, int $courseId): void
    {
        $subject = $this->getSubjectById($id);

        if (!$subject) {
            throw new \Exception("Subject with ID $id not found.");
        }

        $subject->setName($name)
                ->setCourseId($courseId);

        $this->subjectRepository->save($subject);
    }

    public function deleteSubject(int $id): void
    {
        $this->subjectRepository->delete($id);
    }

    public function getAllSubjects(): array
    {
        return $this->subjectRepository->getAll();
    }

    // Búsquedas adicionales
    public function findSubjectsByCourseId(int $courseId): array
    {
        return $this->subjectRepository->findByCourseId($courseId);
    }

    public function findSubjectsByName(string $name): array
    {
        return $this->subjectRepository->findByName($name);
    }
}
