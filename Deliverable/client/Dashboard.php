<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
include "login.php";
$username = $_SESSION['username'];

require "config.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BANG!!!-DASHBOARD</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css" media="screen" />

    </head>
    <body>
        <?php
        include "header.php";
        ?>

        <div id="category">
        </div>
        <div id="addCat">
            <a onclick="addCategory();">+ category</a>
        </div>

        <div id ="listtugas" class="list">
        </div>

        <div id='add'>
            <form id="addcat" action="addkategori.php" method="post">
                Category Name:<br/> <input type='text' id='cate' name="cate"><br/>
                User:<br/> <input type='text' name="join" onkeyup="suggestion(this.value);" list="join"><br/>
                <datalist id="join">
                </datalist>
                <input type="submit" value="create">
                <input type="button" onclick="restore();" value="cancel">
            </form>
        </div>
        <script type="text/javascript" src="script.js"></script>
        <script>
        window.onload = update;
        setInterval(function() {
            update('<?php echo $username;?>');
        }, 5000)
        </script>
    </body>
</html>
