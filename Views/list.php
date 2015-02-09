<?php
include "Views/form.html";
$handler = new FindHandler();
$films = $handler->handleRequest($_POST);

foreach ($films as $film) {?>
    <div>
        <form action="../index.php" method="post" name="show">
            <?php echo $film['Title']?><input type="submit" name="action[show][<?php echo $film['id']?>]" value="Show"><br>
        </form>
    </div>
<?php } ?>
