<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';

    try {
        delete($pdo, 'joke', 'id', $_POST['id']);;

        header('location: jokes.php');
    } catch (PDOException $e) {
        $title = '오류가 발생했습니다.';
        $output = '데이터베이스 서버에 접속 할 수 없습니다.'.$e->getMessage().' , 위치: '.$e->getFile().':'.$e->getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';
