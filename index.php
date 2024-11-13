<?php
    ini_set('display_errors','On');
    define('VIEWS',__DIR__.'/src/views');
    require __DIR__.'/vendor/autoload.php';

   

    //require __DIR__.'/bootstrap.php';

    use App\Infrastructure\Routing\Router;
    use App\Controllers\HomeController;
    use App\Infrastructure\Routing\Request;

    $router=new Router();
    $router->addRoute('GET','/',[new HomeController(),'index'])
            ->addRoute('GET','/teachers',[new HomeController(),'teachers']);

    $router->dispatch(new Request());


   
