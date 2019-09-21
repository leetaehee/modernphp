<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';

    try {
        $jokes = allJokes($pdo);

        $title = '유머 글 목록';

        $totalJokes = totalJokes($pdo);

        // 버퍼 저장 시작.
        ob_start();
        include __DIR__.'/../templates/jokes.html.php';
        // 출력 버퍼의 내용을 읽고 $output 변수에 저장한다.
        // $output 변수는 layout.html.php에서 사용한다.
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }

    include __DIR__ .'/../templates/layout.html.php';