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
    $q = $db->prepare('INSERT INTO tasks (task_uuid, project_uuid, task_name, task_desc, status)
                       VALUES (:task_uuid, :project_uuid, :task_name, :task_desc, :status) ');
    $q->bindValue(':task_uuid', bin2hex(random_bytes(16)));
    $q->bindValue(':project_uuid', $_POST['project_uuid']);
    $q->bindValue(':task_name', $_POST['task_name']);
    $q->bindValue(':task_desc', $_POST['task_desc']);
    $q->bindValue(':status', 'todo');
    $q->execute();
    $res = $q->fetch();
    header("Location: /projects/{$_POST['project_uuid']}");
} catch (PDOException $ex) {
    echo $ex;
}
