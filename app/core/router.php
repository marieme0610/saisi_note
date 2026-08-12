<?php

$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
// dd($uri);


$routes = [
    '/'=>[
        'controller' => 'authController', 'action' =>'login'
    ],
     '/logout'=>[
        'controller' => 'authController', 'action' =>'logout'
    ],
    '/saisi/note'=>[
        'controller' => 'noteController', 'action' =>'ShowSaisi'
    ]
];

// if($uri === '/'){
//     $uri = '/listPatients';
// }


$route = $routes[$uri];
$controller = $route['controller'];
$action = $route['action'];

if(isset($routes[$uri])) {
    $route = $routes[$uri];

    $controller = $route['controller'];
    $action = $route['action'];

    if(file_exists(dirname(__DIR__)."/controller/$controller.php")) {

        require_once dirname(__DIR__)."/controller/$controller.php";

        if(function_exists($action)){
            $action();
        }

    }

}else{
    http_response_code(404);
    echo "Route inexistante";
}