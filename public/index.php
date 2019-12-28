<?php
    try {
      include __DIR__ . '/../classes/EntryPoint.php';
      include __DIR__ . '/../classes/IjdbRoutes.php';

      $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

      $entryPoint = new EntryPoint($route, new IjdbRoutes());
      $entryPoint->run();
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }
    include_once __DIR__ .'/../templates/layout.html.php';