<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Credentials: true');


include 'Routes/Routes.php';
include 'Controller/UserController.php';

class App {
    private $routes;
    private $controller;

    public function __construct() {
        $this->routes = new Routes();
        $this->controller = new UserController();
    }

    public function run() {
        $this->allRoutes();
        $this->routes->route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    private function allRoutes() {
        $this->routes->add('/users/(\d+)', 'GET', function ($id) {
            $this->controller->getUsersByIDController($id);
        });

        $this->routes->add('/users', 'GET', function () {
            $this->controller->getUsersController();
        });

        $this->routes->add('/users', 'POST', function () {
            $this->controller->createUserController();
        });

        $this->routes->add('/users/(\d+)', 'DELETE', function (int $id) {
            $this->controller->deleteUserByIDController($id);
        });

        $this->routes->add('/users/(\d+)', 'PUT', function ($id) {
            $this->controller->editUserByIDController($id);
        });
    }
}

$app = new App();
$app->run();

