<?php
    session_start();
    
    require_once "app/helpers/helpers.php";
    require_once "app/config.php";

    $db = new Database();
    $conn = $db->connect();

    if($conn){
        
        $editMode = false;
        if(isset($_GET['cattr'])){
            $idTask = filter_var($_GET['cattr'], FILTER_SANITIZE_STRING);
            $editMode = true;            
        }

        $loadMode = false;
        if(isset($_GET['l']) && ((int)$_GET['l'] == 202 || (int)$_GET['l'] == 408)){
            $mode = filter_var($_GET['l'], FILTER_SANITIZE_STRING);
            $toLoad = ($mode == 202) ? 0 : 1;
            $loadMode = true;
        }

        $resetMode = (isset($_GET['reset']) && ((int)$_GET['reset'] == 200)) ? true : false;
        
        $userDevice = new UserDevice();
        $userIp = $userDevice->getUserIP();
        $userTerminal = $userDevice->getUserTerminal();

        $usernameExist = new Ifexist(
            $conn, 
            $config['Databases'][0], // Choose todolist database on config file
            "users", 
            null, 
            [$userIp, $userTerminal], 
            ['ip_address = ?', 'device = ?']
        );

        $userData = $usernameExist->readAlone()->fetch();
        if(!$usernameExist->exist()){
            
            $_SESSION['id_user'] = $userData['id'];
            $_SESSION['ip_address'] = $userData['ip_address'];
            $_SESSION['device'] = $userData['device'];
            $_SESSION['username'] = $userData['username'];
        
        }else{
            $taskExist = new Ifexist(
                $conn, 
                $config['Databases'][0], // Choose todolist database on config file
                "user_tasks", 
                null, 
                ($editMode) ? [$userData['id'], $idTask] : [$userData['id']],
                ($editMode) ? ['id_user = ?', 'id_task = ?'] : ['(id_user = ?)']
            );

            if($taskExist->exist()){
                
                if($resetMode){
                    $dataTasksToDelete = $taskExist->readAlone();
                    foreach ($dataTasksToDelete as $value) {
                        $taskResetAll = new Task(
                            $conn,
                            $config['Databases'][0],
                            "tasks",
                            null,
                            [$value['id_task']],
                            ['id = ?']
                        );
                        $taskResetAll->delete();
                    }
                }

                $dataTasks = $taskExist->readJoin(['tasks'], [['id_task', 'id']], [['id'], ['id', 'title', 'status', 'description', 'created_at']]);
                if($editMode){
                    $dataTasks = $dataTasks->fetch();
                    $title = $dataTasks['first_title'];
                    $description = $dataTasks['first_description'];
                }
            }
            if($resetMode){
                header('location: ' . $config['Home']);
            }
        }
    }
?>