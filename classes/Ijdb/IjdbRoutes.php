<?php
    namespace Ijdb;

    class IjdbRoutes
    {
        public function callAction($route)
        {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $jokeTable = new \Hanbit\DatabaseTable($pdo, 'joke', 'id');
            $authorsTable = new \Hanbit\DatabaseTable($pdo, 'author', 'id');

            $page = [];

            if ($route == 'joke/list') {
                $controller = new \Ijdb\Controller\Joke($jokeTable, $authorsTable);
                $page = $controller->list();
            } elseif ($route == '') {
                $controller = new \Ijdb\Controller\Joke($jokeTable, $authorsTable);
                $page = $controller->home();
            } elseif ($route == 'joke/edit') {
                $controller = new \Ijdb\Controller\Joke($jokeTable, $authorsTable);
                $page = $controller->edit();
            } elseif ($route == 'joke/delete') {
                $controller = new \Ijdb\Controller\Joke($jokeTable, $authorsTable);
                $page = $controller->delete();
            }

            return $page;
        }
    }