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