<?php
    require_once "../../helpers/helpers.php";
    require_once "../../config.php";
    
    if(isset($_POST['username']) AND !empty($_POST['username'])){

        $db = new Database();
        $conn = $db->connect();

        if($conn){
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    
            $userDevice = new UserDevice();
            $userIp = $userDevice->getUserIP();
            $userTerminal = $userDevice->getUserTerminal();

            $usernameExist = new Ifexist(
                $conn, 
                $config['Databases'][0], // Choose todolist database
                "users", 
                null, 
                [$username, $userIp, $userTerminal], 
                ['username = ?', 'ip_address = ?', 'device = ?']
            );

            if(!$usernameExist->exist()){
                $newUser = new User(
                    $conn, 
                    $config['Databases'][0], // Choose todolist database
                    "users", 
                    [
                        'username',
                        'ip_address',
                        'device'
                    ],
                    [
                        $username,
                        $userIp,
                        $userTerminal
                    ],
                    null
                );

                $newUser->create();

                session_start();
                $_SESSION['id_user'] = $newUser->last_id;
                $_SESSION['username'] = $username;
                $_SESSION['ip_address'] = $userIp;
                $_SESSION['device'] = $userTerminal;

                header('location: ' . $config['Home']);
            
            }else{
                header('location: ' . $config['Home'] . '?r=407');

            }

        }else{
            header('location: ' . $config['Home']);
        }

    }else{
        header('location: ' . $config['Home']);
    }
?>