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
    $q = $db->prepare('SELECT * FROM users WHERE user_uuid = :user_uuid');
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /login');
        exit();
    }
    // echo "Hi {$user['first_name']} {$user['last_name']}";
} catch (PDOException $ex) {
    echo $ex;
}
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<title><?= "{$user['first_name']} {$user['last_name']}" ?></title>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_admin_top.php');
?>

<main>
    <h1 class="welcome"><?= "Welcome {$user['first_name']}" ?></h1>
    <?php
    try {
        $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
        $db = new PDO("sqlite:$db_path");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $q = $db->prepare('SELECT image_path FROM users WHERE user_uuid = :user_uuid');
        $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
        $q->execute();
        $img = $q->fetch();
    } catch (PDOException $ex) {
        echo $ex;
    }
    ?>
    <style>
        .img {
            background-image: url(<?= $img ?>);
            background-position: center;
            background-size: cover;
            border-radius: 50px;
            height: 100px;
            width: 100px;
        }
    </style>
    <div class="img"></div>
    <h2>Your Projects</h2>
    <div id="projects">
        <?php
        try {
            $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
            $db = new PDO("sqlite:$db_path");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $q = $db->prepare('SELECT * FROM projects WHERE user_uuid = :user_uuid');
            $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
            $q->execute();
            $projects = $q->fetchAll();
            if (!$projects) {
                echo "You dont own projects yet";
            }
            foreach ($projects as $project) {
        ?>
                <a href="/projects/<?= $project['project_uuid'] ?>">
                    <div class="project">
                        <?= $project['project_name'] ?>
                    </div>
                </a>
        <?php
            }
            // echo "Hi {$user['first_name']} {$user['last_name']}";
        } catch (PDOException $ex) {
            echo $ex;
        }
        ?>
    </div>
</main>
</body>

</html>