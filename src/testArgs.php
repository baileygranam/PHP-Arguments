<?php

/* Load the utility file. */
require_once 'Models/Utilities/ParseArgv.php';

/* Give alias to name of class. */
use Models\Utilities\ParseArgv;

if(!isset($_SERVER['argv']))
{
	print("<b>Error:</b> No Arguments!");
	exit();
}

$parsed = new ParseArgv($_SERVER['argv']);
$arguments = $parsed->getParsed();


foreach ($arguments as $k => $v) {
    print("$k=>$v\n");
}



?>