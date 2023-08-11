<?php
$mysqli = new mysqli("localhost", "root", "", "pos");

if(!$mysqli){
    echo "failed!";
    die;
}

?>