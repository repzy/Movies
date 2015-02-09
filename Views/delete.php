<?php
$handler = new FindHandler();
$response = $handler->handleRequest($_POST);
header('Location: ../index.php');