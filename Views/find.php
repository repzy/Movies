<?php include "Views/form.html";
$handler = new FindHandler();
$response = $handler->handleRequest($_POST);
if (isset($response['error'])) {
    echo $response['error'];
} else {?>
<div>
    <form action="" method="post" name="show">
        <?php
        if (isset($response['Stars'])) {
            echo "Title:  ".$response['film']['Title']."<br>";
            echo "Year:  ".$response['film']['Year']."<br>";
            echo "Format:  ".$response['film']['Format']."<br>";
            echo "Stars:  ";
            foreach ($response['Stars'] as $star) {
                echo $star.", ";
            }
        }else {
            foreach ($response['film'] as $film) {
                echo $film['Title']?><input type="submit" name="action[show][<?php echo $film['id']?>]" value="Show"><br>
            <?php }
        }?>


    </form>
</div>
<?php }?>