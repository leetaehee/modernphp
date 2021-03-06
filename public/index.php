<?php
    try {
      include __DIR__  . '/../includes/autoload.php';

      $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
      $entryPoint = new \Hanbit\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Ijdb\IjdbRoutes());
      $entryPoint->run();
    } catch (\PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }