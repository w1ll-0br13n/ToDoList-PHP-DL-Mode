<?php
    session_start();

    if(isset($_SESSION['id_user'])){
        
        require_once "../../helpers/helpers.php";
        require_once "../../config.php";

        if(isset($_POST['newStatus'], $_POST['cattr']) && !empty($_POST['newStatus']) && !empty($_POST['cattr'])){
            
            $db = new Database();
            $conn = $db->connect();

            if($conn){
                $newStatus = filter_var($_POST['newStatus'], FILTER_SANITIZE_STRING);
                $newStatus = ($newStatus == 'true') ? true : false;
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
                            'status'
                        ],
                        [$newStatus, $idTask],
                        ['(id = ?)']
                    );
                    $task->update();
                }
            }
        }
    }
?>