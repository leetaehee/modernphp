<?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ijdb','ijdb','Modernijdb1234@');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        /*
         * title: 데이터 베이스 커넥션 성공 메세지 출력하기
         * view: 화면: /../templates/output.html.php
         */

        //$output = '데이터베이스 접속 성공!';

        // 테이블 생성
        /*
        $sql = 'CREATE TABLE `joke` (
                  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `joketext` TEXT,
                  `jokedate` DATE NOT NULL
                ) DEFAULT  CHARACTER SET utf8 ENGINE=InnoDB';
        $pdo->exec($sql);
        */

        // 데이터 업데이트
        /*
        $sql = 'UPDATE `joke` 
                SET `jokedate` = "%2012-04-01%"
                WHERE `joketext` LIKE "%웹프로그래머%"
               ';
        $affectedRows = $pdo->exec($sql);
        $output = '갱신된 row: '.$affectedRows.' 개.';
        */

        /*
         * title: joke 테이블 내용 뿌려주기
         * view: 화면: /../templates/joke.html.php
         */
        /*
        $sql = 'SELECT `joketext` FROM `joke`';
        $result = $pdo->query($sql);
        while($row=$result->fetch()){
            $jokes[]=$row['joketext'];
        }
        */

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