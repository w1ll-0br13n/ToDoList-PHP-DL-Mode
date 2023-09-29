<?php
    session_start();

    if(isset($_SESSION['id_user'])){
        
        require_once "../../helpers/helpers.php";
        require_once "../../config.php";

        if(isset($_POST['cattr']) && !empty($_POST['cattr'])){
            
            $db = new Database();
            $conn = $db->connect();

            if($conn){
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
                        null,
                        [$idTask],
                        ['(id = ?)']
                    );
                    $task->delete();
                }
            }
        }
    }
?>