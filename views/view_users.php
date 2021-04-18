<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>


<title>Users</title>
</head>

<body class="main">

    <header>
        <nav>
            <a href="/login">Login</a>
            <a href="/signup">Sign-up</a>
        </nav>
    </header>
    <main>
        <h1>Users</h1>
        <?php
        try {

            $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
            $db = new PDO("sqlite:$db_path");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $q = $db->prepare('SELECT * FROM users
                                ORDER BY age asc');
            $q->execute();
            $users = $q->fetchAll();
            echo '<div id="users">';
            foreach ($users as $user) {
                unset($user['user_password']);
        ?>
                <div class="user">
                    <div class="bold">ID: </div>
                    <div> <?= $user['user_uuid'] ?></div>
                    <div class="bold">LAST NAME: </div>
                    <div><?= $user['last_name'] ?></div>
                    <div class="bold">EMAIL: </div>
                    <div><?= $user['email'] ?></div>
                    <div class="bold">NAME: </div>
                    <div><?= $user['first_name'] ?></div>
                    <div class="bold">AGE: </div>
                    <div><?= $user['age'] ?></div>
                </div>
        <?php
            }
            echo '</div>';
        } catch (PDOException $ex) {
            echo $ex;
        }
        ?>
    </main>
</body>

</html>