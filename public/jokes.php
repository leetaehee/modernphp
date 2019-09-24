<?php
    try {
        include_once  __DIR__ . '/../includes/DatabaseConnection.php';
        include_once  __DIR__ . '/../classes/DatabaseTable.php';

        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorTable = new DatabaseTable($pdo, 'author', 'id');

        $result = $jokesTable->findAll();

        $jokes = [];
        foreach ($result as $joke) {
            $author = $authorTable->findById($joke['authorid']);

            $jokes[] = [
              'id'=> $joke['id'],
              'joketext'=> $joke['joketext'],
              'jokedate'=> $joke['jokedate'],
              'name'=> $author['name'],
              'email'=> $author['email']
            ];
        }

        $title = '유머 글 목록';

        $totalJokes = $jokesTable->total();

        ob_start();
        include __DIR__.'/../templates/jokes.html.php';
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }

    include __DIR__ .'/../templates/layout.html.php';