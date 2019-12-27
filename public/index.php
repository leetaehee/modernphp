<?php
    function loadTemplate($templateFileName, $variables = []){
        extract($variables);

        ob_start();
        include_once __DIR__ . '/../templates/' . $templateFileName;

        return ob_get_clean();
    }

    try {
       include_once __DIR__ . '/../includes/DatabaseConnection.php';
       include_once __DIR__ . '/../classes/DatabaseTable.php';

       $jokesTable = new DataBaseTable($pdo, 'joke', 'id');
       $authorsTable = new DatabaseTable($pdo, 'author', 'id');

       $page = [];

       // route 변수가 없으면 'joke/home'을 할당
       $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

       if ($route == strtolower($route)) {
           if ($route == 'joke/list') {
               include_once __DIR__ . '/../controllers/JokeController.php';
               $controller = new JokeController($jokesTable, $authorsTable);
               $page = $controller->list();
           } elseif ($route == '') {
               include_once __DIR__ . '/../controllers/JokeController.php';
               $controller = new JokeController($jokesTable, $authorsTable);
               $page = $controller->home();
           } elseif ($route == 'joke/edit') {
               include_once __DIR__ . '/../controllers/JokeController.php';
               $controller = new JokeController($jokesTable, $authorsTable);
               $page = $controller->edit();
           } elseif ($route == 'joke/delete') {
               include_once __DIR__ . '/../controllers/JokeController.php';
               $controller = new JokeController($jokesTable, $authorsTable);
               $page = $controller->delete();
           }
       } else {
           http_response_code(301);
           header('location: index.php?route=' . strtolower($route));
       }

       $title = $page['title'];

       if (isset($page['variables'])) {
           $output = loadTemplate($page['template'], $page['variables']);
       } else {
           $output = loadTemplate($page['template']);
       }
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }
    include_once __DIR__ .'/../templates/layout.html.php';