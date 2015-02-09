<?php include "Views/form.html";?>
<form action="../index.php" method="post" name="add">
    <input type="text" name="film[Title]" placeholder="Title"><br>
    <input type="text" name="film[Year]" placeholder="Year"><br>

    <select size="1" name="film[Format]">
        <?php
        $formats = Format::getAllFormats();
        foreach ($formats as $format) {
            echo "<option value=".$format['Format'].">".$format['Format']."</option>";
        }?>
    </select><br>

    <input type="text" name="film[Stars]" placeholder="Stars"><br>
    <input type="submit" name="action[add]" value="Add">
</form>
<?php
if (isset($_POST['film'])) {
    $handler = new FindHandler();
    $response = $handler->handleRequest($_POST);

    if (isset($response['error'])) {
        echo $response['error'];
    }
}?>