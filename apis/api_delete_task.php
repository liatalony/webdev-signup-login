<?php

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('DELETE FROM tasks WHERE task_uuid = :task_uuid');
    $q->bindValue(':task_uuid', $task_id);
    $q->execute();
} catch (PDOException $ex) {
    echo $ex;
}
