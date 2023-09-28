<?php
    session_start();

    if(isset($_SESSION['id_user'])){
        
        require_once "../../helpers/helpers.php";
        require_once "../../config.php";

        if(isset($_POST['title'], $_POST['description'], $_POST['cattr']) && !empty($_POST['title']) && !empty($_POST['cattr'])){
            
            $db = new Database();
            $conn = $db->connect();

            if($conn){
                $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                $idTask = filter_var($_POST['cattr'], FILTER_SANITIZE_STRING);
                
                $usernameExist = new Ifexist(
                    $conn, 
                    $config['Databases'][0], // Choose todolist database
                    "tasks", 
                    null, 
                    [$idTask], 
                    ['(id = ?)']
                );

                if($usernameExist->exist()){
                    $task = new Task(
                        $conn,
                        $config['Databases'][0],
                        "tasks",
                        [
                            'title',
                            'description'
                        ],
                        [$title, $description, $idTask],
                        ['(id = ?)']
                    );
                    $task->update();
                }
            }
        }
    }
?>