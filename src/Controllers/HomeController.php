<?php 

    namespace App\Controllers;


    class HomeController{

        function index(){
            $data=['name'=>'CEFPNuria'];
            echo view('home',$data);
        }
        function teachers(){
            echo 'teachers';
        }
    }