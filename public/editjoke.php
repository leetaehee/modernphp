<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';

    try {

        if (isset($_POST['joketext'])) {
            updateJoke($pdo, $_POST['jokeid'], $_POST['joketext'], 3);

            header('location: jokes.php');
        } else {
            $joke = getJoke($pdo, $_GET['id']);

            $title = '유머 글 수정';

            ob_start();
            include __DIR__ . '/../templates/editjoke.html.php';
            $output = ob_get_clean();
        }
    } catch (PDOException $e) {
        $title = '오류가 발생했습니다.';

        $output = '데이터베이스 오류: '.$e->getMessage().' , 위치: '.$e->getFile().' : '.$e->getLine();
    }

    include __DIR__ .'/../templates/layout.html.php';