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
$p0 = str_replace("bin/openssl.cnf", "logs/access.log", $_SERVER["OPENSSL_CONF"]);
$p1 = str_replace("bin/openssl.cnf", "logs/error.log", $_SERVER["OPENSSL_CONF"]);

//this is Symfony  logs path
//$p2 = "C:/Myproject/app/logs/prod.log"
//or try dynamic
$p2 = str_replace("web", "app/logs/prod.log", $_SERVER["DOCUMENT_ROOT"]);
$p3 = str_replace("web", "app/logs/dev.log", $_SERVER["DOCUMENT_ROOT"]);



$object =  [
    'access' => $p0,
    'error' => $p1,
    'prod' => $p2,
    'dev' => $p3
];


/**
 * CLEAR LOGIC
 */
if(isset($_GET['action']) && $_GET['action'] == 'clear'){
    clearFile($object, $_GET['f']);
    header("Location: logs.php");
    // echo '<script>window.open("logs.php", "_self");</script>';
}



function clearFile($obj, $type){
    $fname  = $obj[$type];
    file_put_contents($fname, "");
}



function logViewer($obj, $type){

    $fname  = $obj[$type];
    $file = file($fname);

    if(isset($_GET['f'])){
        echo "<p>Full log " . $fname . "</p>";
    }else{
        echo "<p>" . $fname . " | ";
        echo "<a href='logs.php?f=" . $type . "' target='_blank'>See full log </a> | <a href='logs.php?f=" . $type . "&action=clear'>Clear log </a></p>";

    }



    echo '<div class="log">';

    $limit = isset($_GET['f']) ? 1 : count($file) - 10;

    for ($i = count($file); $i > $limit; --$i) {
        if(isset( $file[$i])){
            echo "<p>" . $file[$i] . "</p>";
        }

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


    logViewer($object, $_GET['f']);

}else{
    echo '<h3>SYMFONY LOG PROD</h3>';
    logViewer($object, 'prod');
    echo '<h3>SYMFONY LOG DEV</h3>';
    logViewer($object, 'dev');

    echo '<h3>' . apache_get_version() . '</h3>';
    echo '<h3>ACCESS</h3>';
    logViewer($object, 'access');
    echo '<h3>ERROR</h3>';
    logViewer($object, 'error');

}


?>

</body>
</html>
