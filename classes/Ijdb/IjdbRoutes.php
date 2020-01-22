<?php
    namespace Ijdb;

    class IjdbRoutes implements \Hanbit\Routes
    {
        private $authorTable;
        private $jokesTable;
        private $authentication;
        private $categoriesTable;
        private $jokeCategoriesTable;

        public function __construct()
        {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $this->jokesTable = new \Hanbit\DatabaseTable($pdo, 'joke', 'id',
                '\Ijdb\Entity\Joke', [&$this->authorTable, &$this->jokeCategoriesTable]);
            $this->authorTable = new \Hanbit\DatabaseTable($pdo, 'author', 'id',
                '\Ijdb\Entity\Author', [&$this->jokesTable]);
            $this->categoriesTable = new \Hanbit\DatabaseTable($pdo, 'category', 'id',
                '\Ijdb\Entity\Category', [&$this->jokesTable, &$this->jokeCategoriesTable]);
            $this->jokeCategoriesTable = new \Hanbit\DatabaseTable($pdo, 'joke_category',
                'categoryId');
            $this->authentication = new \Hanbit\Authentication($this->authorTable, 'email',
                'password');
        }

        public function getRoutes() : array
        {
            $jokeController = new \Ijdb\Controller\Joke($this->jokesTable, $this->authorTable,
                $this->categoriesTable, $this->authentication);
            $authorController = new \Ijdb\Controller\Register($this->authorTable);
            $loginController = new \Ijdb\Controller\Login($this->authentication);
            $categoryController = new \Ijdb\Controller\Category($this->categoriesTable);

            $routes = [
                'joke/edit'=> [
                    'POST'=> [
                        'controller'=> $jokeController,
                        'action'=> 'saveEdit'
                    ],
                    'GET'=> [
                        'controller'=> $jokeController,
                        'action'=> 'edit'
                    ],
                    'login'=> true
                ],
                'joke/delete'=> [
                    'POST'=> [
                        'controller'=> $jokeController,
                        'action'=> 'delete'
                    ],
                    'login'=> true
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
                ],
                'login/error'=> [
                    'GET'=> [
                        'controller'=> $loginController,
                        'action'=> 'error'
                    ]
                ],
                'login'=> [
                    'GET'=> [
                        'controller'=> $loginController,
                        'action'=> 'loginForm'
                    ],
                    'POST'=> [
                        'controller'=> $loginController,
                        'action'=> 'processLogin'
                    ]
                ],
                'login/success'=> [
                    'GET'=> [
                        'controller'=> $loginController,
                        'action'=> 'success'
                    ],
                    'login'=> true
                ],
                'logout/success'=> [
                    'GET'=> [
                        'controller'=> $loginController,
                        'action'=> 'logout'
                    ]
                ],
                'logout'=> [
                    'GET'=> [
                        'controller'=> $loginController,
                        'action'=> 'logoutForm'
                    ]
                ],
                'category/edit'=> [
                    'POST'=> [
                        'controller'=> $categoryController,
                        'action'=> 'saveEdit'
                    ],
                    'GET'=> [
                        'controller'=> $categoryController,
                        'action'=> 'edit'
                    ],
                    'login'=> true,
                    'permissions'=> \Ijdb\Entity\Author::EDIT_CATEGORIES
                ],
                'category/list'=> [
                    'GET'=> [
                        'controller'=> $categoryController,
                        'action'=> 'list'
                    ],
                    'login'=> true,
                    'permissions'=> \Ijdb\Entity\Author::LIST_CATEGORIES
                ],
                'category/delete'=> [
                    'POST'=> [
                        'controller'=> $categoryController,
                        'action'=> 'delete'
                    ],
                    'login'=> true,
                    'permissions'=> \Ijdb\Entity\Author::REMOVE_CATEGORIES
                ],
                'author/permissions'=> [
                    'GET'=> [
                        'controller'=> $authorController,
                        'action'=> 'permissions'
                    ],
                    'POST'=> [
                        'controller'=> $authorController,
                        'action'=> 'savePermissions'
                    ],
                    'login'=> true,
                    'permissions'=> \Ijdb\Entity\Author::EDIT_USER_ACCESS
                ],
                'author/list'=> [
                    'GET'=> [
                        'controller'=> $authorController,
                        'action'=> 'list'
                    ],
                    'login'=> true,
                    'permissions'=>\Ijdb\Entity\Author::EDIT_USER_ACCESS
                ],
                'php/info'=> [
                    'GET'=> [
                        'controller'=> $loginController,
                         'action'=> 'phpInfo'
                    ]
                ]
            ];

            return $routes;
        }

        public function getAuthentication() : \Hanbit\Authentication
        {
            return $this->authentication;
        }

        public function checkPermission($permission) : bool
        {
            $user = $this->authentication->getUser();

            if ($user && $user->hasPermission($permission)) {
                return true;
            } else {
                return false;
            }

        }
    }