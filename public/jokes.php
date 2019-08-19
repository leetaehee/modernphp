<?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ijdb','ijdb','Modernijdb1234@');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        /*
         * title: 유머글 사이트 만들기
         * view: 화면: /../templates/layout.html.php
         */
        $sql = 'SELECT `id`,`joketext` FROM `joke`';
        // 아래 구문으로 변경
        /*
        $result = $pdo->query($sql);
        while($row=$result->fetch()){
            $jokes[]=$row['joketext'];
        }
        */
        $jokes = $pdo->query($sql);

        $title = '유머 글 목록';

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