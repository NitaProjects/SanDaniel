<?php
    ini_set('display_errors','On');
    define('VIEWS',__DIR__.'/src/views');
    require __DIR__.'/vendor/autoload.php';

    //carga automatica de rutas y entorno

    //require __DIR__.'/bootstrap.php';

    use App\Infrastructure\Routing\Router;
    use App\Controllers\HomeController;
    use App\Infrastructure\Routing\Request;

    $router=new Router();
    $router->addRoute('GET','/',[new HomeController(),'index'])
            ->addRoute('GET','/teachers',[new HomeController(),'teachers']);

    $router->dispatch(new Request());


   
/*
    $student=new Student("test@test.com","Alberto");
    $teacher=new Teacher("profe@test.com","Jordi");
    $teacher->addToDepartment(new Department("Informatica"));
    
    
    $daw_2=new Course("2DAW");
    $daw_2->addSubject(new Subject("M7"))
            ->addSubject(new Subject("M8"))
            ->addSubject(new Subject("M6"));

            
*/  
