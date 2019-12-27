<?php
    function loadTemplate($templateFileName, $variables = []){
        extract($variables);

        ob_start();
        include_once __DIR__ . '/../templates/' . $templateFileName;

        return ob_get_clean();
    }

    try {
       include_once __DIR__ . '/../includes/DatabaseConnection.php';
       include_once __DIR__ . '/../classes/DatabaseTable.php';
       include_once __DIR__ . '/../controllers/JokeController.php';

       $jokesTable = new DataBaseTable($pdo, 'joke', 'id');
       $authorsTable = new DatabaseTable($pdo, 'author', 'id');

       $action = $_GET['action'] ?? 'home';

       $controllerName = $_GET['controller'] ?? 'joke';

       $page = [];

       if ($action == strtolower($action) && $controllerName == strtolower($controllerName)) {
           $className = ucfirst($controllerName) . 'Controller';

           include_once __DIR__ . '/../controllers/' . $className . '.php';

           $controller = new $className($jokesTable, $authorsTable);
           $page = $controller->$action();
       } else {
           http_response_code(301);
           header('location: index.php?controller='. strtolower($controller). '&action=' . strtolower($action));
       }

       $title = $page['title'];

       if (isset($page['variables'])) {
           $output = loadTemplate($page['template'], $page['variables']);
       } else {
           $output = loadTemplate($page['template']);
       }
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속 할 수 없습니다: '.$e->getMessage().', 위치: '.$e->getFile().':'.$e->getLine();
    }
    include_once __DIR__ .'/../templates/layout.html.php';