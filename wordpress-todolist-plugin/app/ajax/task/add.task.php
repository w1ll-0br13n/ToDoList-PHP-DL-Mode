<?php
    session_start();

    if(isset($_SESSION['id_user'])){
        
        require_once "../../helpers/helpers.php";
        require_once "../../config.php";

        if(isset($_POST['title'], $_POST['description']) && !empty($_POST['title'])){
            
            $db = new Database();
            $conn = $db->connect();

            if($conn){
                $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

                try{
                    
                    // Start a transactional request
                    $conn->beginTransaction();

                    $task = new Task(
                        $conn, 
                        $config['Databases'][0], // Choose todolist database 
                        "tasks",
                        [
                            'title', 
                            'description'
                        ], 
                        [
                            $title, 
                            $description
                        ], 
                        null
                    );

                    $task->create();

                    $idTask = $task->last_id;

                    $userTask = new UserTask(
                        $conn,
                        $config['Databases'][0], // Choose todolist database
                        "user_tasks",
                        [
                            'id_task', 
                            'id_user'
                        ],
                        [
                            $idTask,
                            $_SESSION['id_user']
                        ],
                        null
                    );

                    $userTask->create();    

                    // If all operations are successful, commit the transaction
                    $conn->commit();               

                }catch (PDOException $e) {
                    // If an error occurs, rollback the transaction
                    $conn->rollBack();
                    die ("Transaction failed: " . $e->getMessage());
                }
            }
            
        }
    }
?>