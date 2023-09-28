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
        
        if(isset($_GET['reset']) && ((int)$_GET['reset'] == 200)){
            $taskResetAll = new Task(
                $conn,
                $config['Databases'][0],
                "tasks",
                null,
                [],
                []
            );
            $taskResetAll->delete();
        }

        $userDevice = new UserDevice();
        $userIp = $userDevice->getUserIP();
        $userTerminal = $userDevice->getUserTerminal();

        $usernameExist = new Ifexist(
            $conn, 
            $config['Databases'][0], // Choose todolist database on config file
            "users", 
            null, 
            [$userIp, $userTerminal], 
            ['(ip_address = ? OR device = ?)']
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
                $dataTasks = $taskExist->readJoin(['tasks'], [['id_task', 'id']], [['id'], ['id', 'title', 'status', 'description', 'created_at']]);
                if($editMode){
                    $dataTasks = $dataTasks->fetch();
                    $title = $dataTasks['first_title'];
                    $description = $dataTasks['first_description'];
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Will J. KEMMOE" />
    <title>TODO APP | PHP - MySQL</title>
    <meta name="description" content="This is TODO APP created using PHP, MySQL, HTML, CSS & JS" />
    <link rel="icon" type="image/png" href="./assets/favicon/favicon.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/webfonts.css" />
    <link rel="stylesheet" href="./assets/css/feather.css" />
    <link rel="stylesheet" href="./assets/css/app.css" />
</head>
<body>
    <?php
        if(!isset($_SESSION['id_user'])){
    ?>
    <div class="layer backdrop-blur"></div>
    <div class="form-m">
        <div class="wrap">
            <img src="./assets/images/logo.png" alt="TODO">
        </div>
        <form id="saveUser" action="./app/ajax/user/add.user.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="txt-input" placeholder="Mr Bigfoot" spellcheck="false" autocomplete="off" id="title" required />
                <span class="error-text"></span>
                <button>OK</button>
            </div>
        </form>
    </div>
    <?php
        }
    ?>
    <header class="card">
    <?php
        require_once __DIR__ . "/app/components/header.php";
    ?>
    </header>
    
    <main>
    <?php
        require_once __DIR__ . "/app/components/app.php";
    ?>
    </main>

    <footer>
    <?php
        require_once __DIR__ . "/app/components/footer.php";
    ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="./assets/js/app.js"></script>
</body>
</html>