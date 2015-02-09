<?php
include "Views/form.html";?>
<form action="../index.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file"><br>
    <input type="submit" name="action[file]" value="Download">
</form>

<?php

if (sizeof($_FILES) !== 0) {
    $handler = new FindHandler();
    $response = $handler->handleRequest($_POST);
    if (isset($response['error'])) {
        echo $response['error'];
    }
}
?>