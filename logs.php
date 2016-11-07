<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bridge Management System - Logs</title>

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
            margin:  5px;

        }
    </style>
</head>
<body>




    <?php



    echo '<h3>'. apache_get_version(). ' LOG</h3>';

    $p1 = str_replace( "bin/openssl.cnf", "logs/error.log", $_SERVER["OPENSSL_CONF"]);
    $p2 = str_replace( "web", "app/logs/prod.log", $_SERVER["DOCUMENT_ROOT"]);

    function logLast($fname)
    {
        echo "<p>See full log "  .  $fname . "</a></p>";
        $file = file($fname);
        echo '<div class="log">';
        for ($i = max(0, count($file) - 10); $i < count($file); $i++) {
            echo "<p>" .  $file[$i] . "</p>";
        }
        echo '</div>';
    }

    logLast($p1);

    echo '<h3>SYMFONY LOG</h3>';
    logLast($p2);
    ?>

</body>
</html>
