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
$results = $parsed->getParsed();

/* Loop through each category. */
foreach ($results as $category => $paramters) 
{
	/* Print the category. */
	print("\n$category");

	/* Loop through each parameter. */
	foreach ($paramters as $param => $arguments)
	{
		/* Print the parameter. */
		print("\n'$param' ");

		/* If there are multiple arguments for a given paramter then continue. */
		if(is_array($arguments))
		{
			/* Loop through each argument of a paramter. */
			foreach ($arguments as $arg => $value)
			{
				/* Print the arguments for a paramter with the index and value. */
				print("[$arg] '$value'");
				if(next($arguments) == TRUE) print(", ");
				
			}
			$numOfArgs = count($arguments);
			print(" ($numOfArgs arguments) ");
		}
		/* If there is only 1 argument for a parameter then skip here. */
		else if(!empty($arguments))
		{
			print("=> $arguments");
			print(" (1 argument) ");
		}
	}
	print("\n");	
}






?>