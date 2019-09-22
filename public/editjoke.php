<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';

    try {
        if (isset($_POST['joke'])) {

            $joke = $_POST['joke'];
            $joke['jokedate'] = new DateTime();
            $joke['authorid'] = 3;

            // insert와 update 모두 실행
            save($pdo, 'joke', 'id', $joke);

            // update 만 실행
            //update($pdo, 'joke', 'id', $joke);

            header('location: jokes.php');
        } else {
            if (isset($_GET['id'])) {
                $joke = findById($pdo, 'joke', 'id', $_GET['id']);
            }

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