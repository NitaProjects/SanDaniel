<?php

namespace App\Controllers;

use App\Database\Database;
use App\School\Repositories\Implementations\CourseRepository;
use App\School\Repositories\Implementations\DegreeRepository;

class HomeController
{
    private CourseRepository $courseRepository;

    public function __construct()
    {
        $database = new Database();
        $degreeRepo = new DegreeRepository($database->getConnection());
        $this->courseRepository = new CourseRepository($database->getConnection(), $degreeRepo);
    }

    public function index()
    {
        $courses = $this->courseRepository->getAll();
        $data = [
            'name' => 'Colegio San Daniel',
            'courses' => $courses,
        ];
        echo view('home', $data);
    }

    public function teachers()
    {
        echo 'teachers';
    }
}
