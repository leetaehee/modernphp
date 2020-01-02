<?php
    namespace Ijdb;

    class IjdbRoutes implements \Hanbit\Routes
    {
        public function getRoutes()
        {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $jokeTable = new \Hanbit\DatabaseTable($pdo, 'joke', 'id');
            $authorTable = new \Hanbit\DatabaseTable($pdo, 'author', 'id');

            $jokeController = new \Ijdb\Controller\Joke($jokeTable, $authorTable);
            $authorController = new \Ijdb\Controller\Register($authorTable);

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
                ],
                'author/register'=> [
                    'GET'=> [
                        'controller'=> $authorController,
                        'action'=> 'registrationForm'
                    ],
                    'POST'=> [
                        'controller'=> $authorController,
                        'action'=> 'registerUser'
                    ]
                ],
                'author/success'=> [
                    'GET'=> [
                        'controller'=> $authorController,
                        'action'=> 'success'
                    ]
                ]
            ];

            return $routes;
        }
    }