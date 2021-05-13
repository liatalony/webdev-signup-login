<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

if (!isset($project_id)) {
    header('Location: /admin');
    exit();
}

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('SELECT * FROM projects WHERE project_uuid = :project_uuid');
    $q->bindValue(':project_uuid', $project_id);
    $q->execute();
    $project = $q->fetch();
    if (!$project) {
        echo 'no project';
        //header('Location: /admin');
        exit();
    }
    if ($project['user_uuid'] != $_SESSION['user_uuid']) {
        echo 'not equal';
        //header('Location: /admin');
        exit();
    }
} catch (PDOException $ex) {
    echo $ex;
}
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<title><?= "{$project['project_name']}" ?></title>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_admin_top.php');
?>
<main>
    <h1><?= "{$project['project_name']}" ?></h1>
    <div id="tasks">

        <div>
            <h2>To Do</h2>
            <div class="todo" ondrop="drop(event)" ondragover="allowDrop(event)">
                <?php
                try {
                    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
                    $db = new PDO("sqlite:$db_path");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $q = $db->prepare('SELECT * FROM tasks WHERE project_uuid = :project_uuid AND status="todo"');
                    $q->bindValue(':project_uuid', $project_id);
                    $q->execute();
                    $tasks = $q->fetchAll();
                    foreach ($tasks as $task) {
                        echo "<div class='task' id={$task['task_uuid']} draggable='true' ondragstart='drag(event)'>{$task['task_name']}</div>";
                    }

                    if (!$tasks) {
                        echo 'no project';
                        //header('Location: /admin');
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
                ?>
            </div>
        </div>
        <div>
            <h2>Doing</h2>
            <div class="doing" ondrop="drop(event)" ondragover="allowDrop(event)">
                <?php
                try {
                    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
                    $db = new PDO("sqlite:$db_path");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $q = $db->prepare('SELECT * FROM tasks WHERE project_uuid = :project_uuid AND status="doing"');
                    $q->bindValue(':project_uuid', $project_id);
                    $q->execute();
                    $tasks = $q->fetchAll();
                    foreach ($tasks as $task) {
                        echo "<div class='task' id={$task['task_uuid']} draggable='true' ondragstart='drag(event)'>{$task['task_name']}</div>";
                    }

                    if (!$tasks) {
                        echo 'no project';
                        //header('Location: /admin');
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
                ?>
            </div>
        </div>
        <div>
            <h2>Done</h2>
            <div class="done" ondrop="drop(event)" ondragover="allowDrop(event)">
                <?php
                try {
                    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
                    $db = new PDO("sqlite:$db_path");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $q = $db->prepare('SELECT * FROM tasks WHERE project_uuid = :project_uuid AND status="done"');
                    $q->bindValue(':project_uuid', $project_id);
                    $q->execute();
                    $tasks = $q->fetchAll();
                    foreach ($tasks as $task) {
                        echo "<div class='task' id={$task['task_uuid']} draggable='true' ondragstart='drag(event)'>{$task['task_name']}</div>";
                    }

                    if (!$tasks) {
                        echo 'no project';
                        //header('Location: /admin');
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
                ?>
            </div>
        </div>
    </div>
</main>
<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        console.log(ev.target);
        if (ev.target.className == "task") {
            ev.target.parentNode.appendChild(document.getElementById(data));
        } else {
            ev.target.appendChild(document.getElementById(data));
        }
        console.log(data + ", " + ev.target.parentNode.className);
        update_status(data, ev.target.parentNode.className);
    }

    async function update_status(task_id, status) {
        let conn = await fetch(`/tasks/update/${task_id}/${status}`, {
            "method": "POST"
        })

        if (!conn.ok) {
            alert("upps...");
            return
        }
        let data = await conn.text()
        console.log(data)
    }
</script>
</script>
</body>

</html>