<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}
if (!isset($_POST['first_name'])) {
    header('Location: /profile');
    echo 'first name';
    exit();
}

if (!isset($_POST['last_name'])) {
    header('Location: /profile');
    echo 'last name';
    exit();
}

if (!isset($_POST['email'])) {
    header('Location: /profile');
    echo 'email';
    exit();
}
if (!isset($_POST['pass'])) {
    header('Location: /profile');
    echo 'password';
    exit();
}

if (!isset($_POST['con_pass'])) {
    header('Location: /profile');
    echo 'con password';
    exit();
}

if (!isset($_POST['age'])) {
    header('Location: /profile');
    echo 'age';
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: /profile');
    echo 'bad email';
    exit();
}
if (
    strlen($_POST['pass']) < 6 ||
    strlen($_POST['pass']) > 8
) {
    header('Location: /profile');
    echo 'password length';
    exit();
}

if (
    $_POST['con_pass'] != $_POST['pass']
) {
    header('Location: /profile');
    echo 'passwords dont match';
    exit();
}

if (!isset($_FILES['pic'])) {
    header('Location: /profile');
    echo 'pic';
    exit();
}

echo var_dump($_FILES['pic']);
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif', 'zip', 'pdf'];
$image_type = mime_content_type($_FILES['pic']['tmp_name']); // image/png
$extension = strrchr($image_type, '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain

if (!in_array($extension, $valid_extensions)) {
    echo "mmm.. hacking me?";
    header('Location: /profile');
    exit();
}
$random_image_name = bin2hex(random_bytes(16)) . ".$extension";
move_uploaded_file($_FILES['pic']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/images/$random_image_name");
echo 'File uploaded';
try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(' UPDATE users
                    SET first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        age = :age,
                        user_password = :user_password,
                        image_path=:image_path
                    WHERE user_uuid = :user_uuid ');
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':first_name', $_POST['first_name']);
    $q->bindValue(':last_name', $_POST['last_name']);
    $q->bindValue(':email', $_POST['email']);
    $q->bindValue(':age', $_POST['age']);
    $q->bindValue(':user_password', $_POST['pass']);
    $q->bindValue(':image_path', "/images/$random_image_name");
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /admin');
        exit();
    }
    header('Location: /profile');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
