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
       include_once __DIR__ . '/../controllers/JokeController.php';

       $jokesTable = new DataBaseTable($pdo, 'joke', 'id');
       $authorsTable = new DatabaseTable($pdo, 'author', 'id');

       $jokeController = new JokeController($jokesTable, $authorsTable);

       $action = $_GET['action'] ?? 'home';

       $page = $jokeController->$action();

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