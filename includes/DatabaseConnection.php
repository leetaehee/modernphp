<?php
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8','ijdb','Modernijdb1234@');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);