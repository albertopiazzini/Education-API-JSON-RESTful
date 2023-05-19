
<?php

include_once 'app/controllers/CourseController.php';
include_once 'app/controllers/SubjectController.php';


class Router 

{
    protected $routes;

    function load ($routes) {
        $this-> routes= $routes;
    }

    function direct($path, $method)
{
    // Check if the URL matches the specific route
    if (array_key_exists($path, $this->routes[$method])) {
        return $this->callAction(...explode('@', $this->routes[$method][$path]));
    }
    // Check if URL matches pattern 'courses/{id:\d+}'
    elseif (preg_match('/^courses\/(\d+)$/', $path, $matches)) {
        if($method=='POST') {
            echo json_encode(array("message" => "No route defined for this URI"));
            return;
        }
        $routeParams = ['id' => $matches[1]];
        $controllerAction = explode('@', $this->routes[$method]['courses/{id:\d+}']);
        $controller = $controllerAction[0];
        $action = $controllerAction[1];
        return $this->callAction($controller, $action, $routeParams);
    }
    // Check if URL matches pattern 'subjects/{id:\d+}'
    elseif (preg_match('/^subjects\/(\d+)$/', $path, $matches)) {

        if($method=='POST') {
            echo json_encode(array("message" => "No route defined for this URI"));
            return;
        }
        $routeParams = ['id' => $matches[1]];
        $controllerAction = explode('@', $this->routes[$method]['subjects/{id:\d+}']);
        $controller = $controllerAction[0];
        $action = $controllerAction[1];
        return $this->callAction($controller, $action, $routeParams);
    }
    
    
    
 else {
        http_response_code(404);
        echo json_encode(array("message" => "No route defined for this URI"));
    }
}

    

protected function callAction($controller, $action, $routeParams = null)
{
    $controller = new $controller;

    if (!method_exists($controller, $action)) {
        throw new Exception(
            "{$controller} does not respond to action {$action} action."
        );
    }
    
    if ($routeParams !== null) {
        return $controller->$action($routeParams);
    } else {
        return $controller->$action();
    }
}

}





