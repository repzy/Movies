<html>
<head>
    <title>Movie</title>
</head>
<body>
    <?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    include "Handlers/FindHandler.php";
    include "Utils/database.php";
    include "Utils/validator.php";
    include "Entities/format.php";
    include "Entities/movie.php";
    include "Entities/star.php";
    include "Entities/file.php";
    var_dump($_POST);
    if (key($_POST) !== null) {
        include "Views/".key($_POST['action']).".php";
    } else {
        include "Views/form.html";
    } ?>
</body>
</html>
