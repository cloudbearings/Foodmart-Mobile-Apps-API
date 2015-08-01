<?php
//echo $connect = mysql_connect('localhost','foodmarb_madminh','321`NazmuL@!~');
$link = mysql_connect('localhost', 'foodmarb_madminh', '321`NazmuL@!~');


$db = mysql_select_db ('foodmarb_foodmart');

if (!$db) {
    die('Could not connect: ' . mysql_error());
}
?>