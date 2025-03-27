<?php
echo "<h1>Insert Brouwer</h1>";
require_once('functions.php');

if(isset($_POST) && isset($_POST['btn_ins'])){
    if(insertRecord($_POST) == true){
        echo "<script>alert('Brouwer is toegevoegd')</script>";
    } else {
        echo '<script>alert("Brouwer is NIET toegevoegd")</script>';
    }
}
?>
<html>
    <body>
        <form method="post">
            <label for="naam">Naam:</label>
            <input type="text" brouwcode="naam" name="naam" required><br>

            <label for="land">Land:</label>
            <input type="text" brouwcode="land" name="land" required><br>

            <input type="submit" name="btn_ins" value="Insert">
        </form>
        <br><br>
        <a href='index.php'>Home</a>
    </body>
</html>