<?php

/*
 * This is simple symfony and apache log viewer
 *
 * (c) Lev.Savranskiy@gmail com
 *
 * See https://github.com/lev-savranskiy
 */


/***
 * SETUP
 */

//this is apache logs path
//$p1 = "C:/xampp/apache/logs/error.log"
//or try dynamic
$p1 = str_replace("bin/openssl.cnf", "logs/error.log", $_SERVER["OPENSSL_CONF"]);

//this is Symfony  logs path
//$p2 = "C:/Myproject/app/logs/prod.log"
//or try dynamic
$p2 = str_replace("web", "app/logs/prod.log", $_SERVER["DOCUMENT_ROOT"]);




function logViewer($fname){

    $file = file($fname);

    if(isset($_GET['f'])){
        echo "<p>Full log " . $fname . "</p>";
    }else{
        echo "<p>See full log <a href='logs.php?f=" . $fname . "' target='_blank'>" . $fname . "</a></p>";
    }



    echo '<div class="log">';

    $limit = isset($_GET['f']) ? count($file) : 10;

    for ($i = max(0, count($file) - $limit); $i < count($file); $i++) {
        echo "<p>" . $file[$i] . "</p>";
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symfony and apache log viewer</title>

    <style>
        .log {
            font-size: 14px;
            font-family: "Bitstream Vera Sans Mono", monospace;
            border: 3px groove #ccc;
            display: block;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            background-color: black;
            color: #fff;
            padding: 5px 20px;
        }

        p {
            margin: 5px;

        }
    </style>
</head>
<body>

<?php

if(isset($_GET['f'])){
    logViewer($_GET['f']);
}else{
    echo '<h3>' . apache_get_version() . ' LOG</h3>';
    logViewer($p1);
    echo '<h3>SYMFONY LOG</h3>';
    logViewer($p2);
}


?>

</body>
</html>
