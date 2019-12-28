<?php
    class IjdbRoutes
    {
        public function callAction($route)
        {
            include __DIR__ . '/../classes/DatabaseTable.php';
            include __DIR__ . '/../includes/DatabaseConnection.php';

            $jokeTable = new DatabaseTable($pdo, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, 'author', 'id');

            $page = [];

            if ($route == 'joke/list') {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokeTable, $authorsTable);
                $page = $controller->list();
            } elseif ($route == '') {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokeTable, $authorsTable);
                $page = $controller->home();
            } elseif ($route == 'joke/edit') {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokeTable, $authorsTable);
                $page = $controller->edit();
            } elseif ($route == 'joke/delete') {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokeTable, $authorsTable);
                $page = $controller->delete();
            }

            return $page;
        }
    }