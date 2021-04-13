<?php

if (!isset($_POST['first_name'])) {
    header('Location: /signup');
    echo 'first name';
    exit();
}

if (!isset($_POST['last_name'])) {
    header('Location: /signup');
    echo 'last name';
    exit();
}

if (!isset($_POST['email'])) {
    header('Location: /signup');
    echo 'email';
    exit();
}
if (!isset($_POST['pass'])) {
    header('Location: /signup');
    echo 'password';
    exit();
}

if (!isset($_POST['con_pass'])) {
    header('Location: /signup');
    echo 'con password';
    exit();
}

if (!isset($_POST['age'])) {
    header('Location: /signup');
    echo 'age';
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: /signup');
    echo 'bad email';
    exit();
}
if (
    strlen($_POST['pass']) < 6 ||
    strlen($_POST['pass']) > 8
) {
    header('Location: /signup');
    echo 'password length';
    exit();
}

if (
    $_POST['con_pass'] != $_POST['pass']
) {
    header('Location: /signup');
    echo 'passwords dont match';
    exit();
}

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(' INSERT INTO users
                    VALUES (:user_uuid , :first_name , :last_name , :email , :age , :password , :active)');
    $q->bindValue(':user_uuid', bin2hex(random_bytes(16)));
    $q->bindValue(':first_name', $_POST['first_name']);
    $q->bindValue(':last_name', $_POST['last_name']);
    $q->bindValue(':email', $_POST['email']);
    $q->bindValue(':age', $_POST['age']);
    $q->bindValue(':password', $_POST['pass']);
    $q->bindValue(':active', 1);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /login');
        exit();
    }
    header('Location: /signup');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
