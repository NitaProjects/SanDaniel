<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Exam;

interface IExamRepository
{
    public function add(Exam $exam): void; 
    public function update(Exam $exam): void; 
    public function findById(int $id): ?Exam; 
    public function delete(int $id): void; 
    public function getAll(): array; 
}
