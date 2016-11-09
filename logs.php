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

const LIM = 10;

$object = [
    'access' => $p0,
    'error' => $p1,
    'prod' => $p2,
    'dev' => $p3
];


/**
 * CLEAR LOGIC
 */
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    clearFile($object, $_GET['f']);
    header("Location: logs.php");
    // echo '<script>window.open("logs.php", "_self");</script>';
}


function clearFile($obj, $type)
{
    $fname = $obj[$type];
    file_put_contents($fname, "");
}


function logViewer($obj, $type)
{

    $fname = $obj[$type];
    $file = file($fname);
    $cnt = count($file);
    $shown = $cnt > LIM ? LIM : $cnt;



    if (isset($_GET['f'])) {
        echo "<p>Full log " . $fname . ": " . $cnt . " lines </p>";
    } else {

        if ($cnt) {
            echo "<p>" . $fname . ": last " . $shown . " of " . $cnt . " lines ";
            echo "|  <a href='logs.php?f=" . $type . "' target='_blank'>See full log </a> | <a href='logs.php?f=" . $type . "&action=clear'>Clear log </a></p>";
        }else{
            echo "<p>" . $fname . ": is empty";
        }
     }


    if ($cnt) {
        echo '<div class="log">';
    }


    $limit = isset($_GET['f']) ? 1 : $cnt - LIM;

    for ($i = $cnt; $i > $limit; --$i) {
        if (isset($file[$i])) {
            echo "<p>" . $file[$i] . "</p>";
        }
    }

    if ($cnt) {
        echo '</div>';
    }

    echo "<p style='margin: 5px 0'>&nbsp;</p>";
}

function getSymfonyVersion(){

    try {
        $str = file_get_contents('../vendor/composer/installed.json');
        $json = json_decode($str);

        foreach($json as $k=>$v)
        {
            if('symfony/symfony' == $v->name){
                return ($v->version);
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }


};



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

if (isset($_GET['f'])) {


    logViewer($object, $_GET['f']);

} else {


    echo '<h2>SYMFONY ' . getSymfonyVersion() . '</h2>';
    //echo '<h4>PROD LOG</h4>';
    logViewer($object, 'prod');
  //  echo '<h4>DEV LOG</h4>';
    logViewer($object, 'dev');

    echo '<h2>' . apache_get_version() . '</h2>';
    //echo '<h4>ACCESS LOG</h4>';
    logViewer($object, 'access');
   // echo '<h4>ERROR LOG</h4>';
    logViewer($object, 'error');

}


?>

</body>
</html>
