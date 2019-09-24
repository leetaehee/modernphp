<?php
    try {
       include __DIR__ . '/../includes/DatabaseConnection.php';
       include __DIR__ . '/../classes/DatabaseTable.php';
       include __DIR__ . '/../controllers/JokeController.php';

       $jokesTable = new DataBaseTable($pdo, 'joke', 'id');
       $authorsTable = new DatabaseTable($pdo, 'author', 'id');

       $jokeController = new JokeController($jokesTable, $authorsTable);

       $action = $_GET['action'] ?? 'home';
       $page = $jokeController->$action();

       $title = $page['title'];
       $output = $page['output'];

    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }
    include __DIR__ .'/../templates/layout.html.php';