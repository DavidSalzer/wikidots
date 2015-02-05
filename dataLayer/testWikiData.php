<?php

include_once("wikidotValue.php");


echo "from DB: <br>";
$wikidotValue=new WikidotValue();
$data=$wikidotValue->getValue($_GET["value"]);

Krumo($data);
echo '<img src='.$data->img_url.'>';


echo "<hr>";

echo "from wikipadia: <br>";
$wikidotValue=new WikidotValue();
$data=$wikidotValue->importValue($_GET["value"]);

Krumo($data);
echo '<img src='.$data->img_url.'>';