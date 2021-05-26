<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}
try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('INSERT INTO projects (project_uuid, user_uuid, project_name)
                       VALUES (:project_uuid, :user_uuid, :project_name) ');
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':project_uuid', bin2hex(random_bytes(16)));
    $q->bindValue(':project_name', $_POST['project_name']);
    $q->execute();
    $res = $q->fetch();
    header('Location: /admin');
} catch (PDOException $ex) {
    echo $ex;
}
