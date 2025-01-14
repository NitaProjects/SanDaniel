<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Renderiza directamente la vista del home
        echo view('home');
    }

    public function management()
    {
        // Renderiza directamente la vista de gestión
        echo view('management');
    }
}
