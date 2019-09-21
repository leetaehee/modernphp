<?php
    try {
        include_once __DIR__ . '/../includes/DatabaseConnection.php';

        $title = '인터넷 유머 세상';

        // 버퍼 저장 시작.
        ob_start();
        include __DIR__.'/../templates/home.html.php';
        // 출력 버퍼의 내용을 읽고 $output 변수에 저장한다.
        // $output 변수는 layout.html.php에서 사용한다.
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }

    //include __DIR__ . '/../templates/output.html.php';
    //include __DIR__ .'/../templates/joke.html.php';
    include __DIR__ .'/../templates/layout.html.php';