<?php include "Views/form.html";
$handler = new FindHandler();
$response = $handler->handleRequest($_POST);?>
<div>
    <form action="" method="post" name="show">
        <?php
            echo "Title:  ".$response['film']['Title']."<br>";
            echo "Year:  ".$response['film']['Year']."<br>";
            echo "Format:  ".$response['film']['Format']."<br>";
            echo "Stars:  ";
            foreach ($response['stars'] as $star) {
                echo $star.", ";
            }
        ?>
        <br>
        <input type="submit" name="action[delete][<?php echo $response['film']['id']?>]" value="Delete"><br>
    </form>
</div>

