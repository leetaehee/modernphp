<?php
    if(!isset($_POST['firstname']) || empty($_POST['firstname'])){
        include __DIR__ . '/../templates/form.html.php';
    }else {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        if ($firstname == 'Kevin' && $lastname == 'Yank') {
            $output = '환영합니다. 관리자시군요!';
        } else {
            $output = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' . '님, 홈페이지 방문을 환영합니다!';
        }
        include __DIR__ . '/../templates/welcome.html.php';
    }