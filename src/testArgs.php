<?php

/* Load the utility file. */
require_once 'Models/Utilities/ParseArgv.php';

/* Give alias to name of class. */
use Models\Utilities\ParseArgv;

/* Check to validate that arguments were provided. */
if(!isset($_SERVER['argv']))
{
	print("<b>Error:</b> No Arguments!");
	exit();
}

/* Create new ParseArgv object. */
$parsed = new ParseArgv($_SERVER['argv']);

/* Get the parsed arguments. */
$parsed->parseArgs();
$arguments = $parsed->getParsed();



foreach ($arguments as $k => $v) 
{
    print("$k => $v\n");
}

// print("\nFLAGS\n");

// foreach ($flags as $k => $v) {
//     print("'$v'\n");
// }

// print("\nSINGLES");

// foreach ($singles as $k => $v) 
// {
// 	print("\n'$k' => ");

// 	if(is_array($v))
// 	{
// 		foreach($v as $j => $i)
// 		{
// 		    print("[$j] '$i', ");
// 		}
// 	}
// 	else
// 	{
// 		print("'$v'");
// 	}
// }





?>