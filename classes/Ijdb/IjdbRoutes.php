<?php
    namespace Ijdb;

    class IjdbRoutes
    {
        public function callAction($route)
        {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $jokeTable = new \Hanbit\DatabaseTable($pdo, 'joke', 'id');
            $authorTable = new \Hanbit\DatabaseTable($pdo, 'author', 'id');

            $jokeController = new \Ijdb\Controller\Joke($jokeTable, $authorTable);

            $routes = [
                'joke/edit'=> [
                    'POST'=> [
                        'controller'=> $jokeController,
                        'action'=> 'saveEdit'
                    ],
                    'GET'=> [
                        'controller'=> $jokeController,
                        'action'=> 'edit'
                    ]
                ],
                'joke/delete'=> [
                    'POST'=> [
                        'controllers'=> $jokeController,
                        'action'=> 'delete'
                    ]
                ],
                'joke/list'=> [
                    'GET'=> [
                        'controller'=> $jokeController,
                        'action'=> 'list'
                    ]
                ],
                ''=> [
                    'GET'=> [
                        'controller'=> $jokeController,
                        'action'=> 'home'
                    ]
                ]
            ];

            $method = $_SERVER['REQUEST_METHOD'];

            $controller =$routes[$route][$method]['controller'];
            $action = $routes[$route][$method]['action'];

            return $controller->$action();
        }
    }