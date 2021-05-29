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
    <a class="add" onclick="display()">+</a>

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
                ?>
                        <div class='task' id="<?= $task['task_uuid'] ?>" draggable='true' ondragstart='drag(event)'>
                            <div class="desc">
                                <h4 class="task_name"><?= $task['task_name'] ?></h4>
                                <?php
                                if ($task['task_desc']) {
                                ?>
                                    <p class="task_name"><?= $task['task_desc'] ?></p>
                                <?php
                                }
                                ?>
                            </div>
                            <button class="delete" onclick="delete_task('<?= $task['task_uuid'] ?>')"><img src="/images/trash.png" alt="delete"></button>
                        </div>
                <?php
                    }

                    if (!$tasks) {
                        echo 'no tasks yet';
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
                ?>
                        <div class='task' id="<?= $task['task_uuid'] ?>" draggable='true' ondragstart='drag(event)'>
                            <div class="desc">
                                <h4 class="task_name"><?= $task['task_name'] ?></h4>
                                <?php
                                if ($task['task_desc']) {
                                ?>
                                    <p class="task_name"><?= $task['task_desc'] ?></p>
                                <?php
                                }
                                ?>
                            </div>
                            <button class="delete" onclick="delete_task('<?= $task['task_uuid'] ?>')"><img src="/images/trash.png" alt="delete"></button>
                        </div>
                <?php
                    }

                    if (!$tasks) {
                        echo 'no tasks yet';
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
                ?>
                        <div class='task' id="<?= $task['task_uuid'] ?>" draggable='true' ondragstart='drag(event)'>
                            <div class="desc">
                                <h4 class="task_name"><?= $task['task_name'] ?></h4>
                                <?php
                                if ($task['task_desc']) {
                                ?>
                                    <p class="task_name"><?= $task['task_desc'] ?></p>
                                <?php
                                }
                                ?>
                            </div>
                            <button class="delete" onclick="delete_task('<?= $task['task_uuid'] ?>')"><img src="/images/trash.png" alt="delete"></button>
                        </div>
                <?php
                    }

                    if (!$tasks) {
                        echo 'no tasks yet';
                        //header('Location: /admin');
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
                ?>
            </div>
        </div>
    </div>
    <div class="bg hidden">
        <form action="/projects/<?= $project['project_uuid'] ?>" method="post" class="new_project">
            <h2 onclick="close_form()">X</h2>
            <input type="hidden" value="<?= $project['project_uuid'] ?>" name="project_uuid">
            <label for="task_name">task name:</label>
            <input required type="text" name="task_name">
            <label for="task_desc">task description:</label>
            <input required type="text" name="task_desc">
            <button>Add task</button>
        </form>
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
        let data = ev.dataTransfer.getData("text");
        let location;
        console.log(ev.target);
        //console.log(data + ", " + ev.target.parentNode.className);
        if (ev.target.className == "task") {
            ev.target.parentNode.appendChild(document.getElementById(data));
            location = ev.target.parentNode.className;

        } else if (ev.target.className == "task_name") {
            ev.target.parentNode.parentNode.parentNode.appendChild(document.getElementById(data));
            location = ev.target.parentNode.parentNode.parentNode.className;

        } else if (ev.target.className == "desc") {
            ev.target.parentNode.parentNode.appendChild(document.getElementById(data));
            location = ev.target.parentNode.parentNode.className;
        } else {
            ev.target.appendChild(document.getElementById(data));
            location = ev.target.className;
        }
        console.log(location);
        update_status(data, location);
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
        //console.log(data)
    }

    function display() {
        document.querySelector(".bg").classList.remove('hidden');
    }

    function close_form() {
        document.querySelector(".bg").classList.add('hidden');
        document.querySelector(".new_project").reset();
    }

    async function delete_task(task_id) {
        let task = event.target.parentNode
        if (task.className == "delete") {
            task = task.parentNode
        }
        let conn = await fetch(`/tasks/delete/${task_id}`, {
            "method": "POST"
        })
        if (!conn.ok) {
            alert("upps...");
            return
        }
        let data = await conn.text()
        console.log(data)
        task.remove()
    }
</script>
</body>

</html>