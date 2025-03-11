<?php

$directory = $_SERVER["DOCUMENT_ROOT"];
$directory .= '/Minifourchan/assets/functions/*.php';

$functions = glob($directory);

foreach ($functions as $function) {
    include($function);
}
