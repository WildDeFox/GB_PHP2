<?php

use Main\Component\Http\Request;

require_once __DIR__ . "/vendor/autoload.php";

$request = new Request($_GET, $_SERVER);
$name = $request->header('cookie');
var_dump($name);
