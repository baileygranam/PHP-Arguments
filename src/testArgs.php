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

/* Get unparsed arguments. */
$unparsed = $parsed->getUnparsed();

/* Parse the arguments. */
$parsed->parseArgs();

/* Get the parsed arguments. */
$parsed = $parsed->getParsed();

print("\n---------- Unparsed ----------\n");
print_r($unparsed);

print("\n---------- Parsed ----------\n");
print_r($parsed);

print("\n---------- Parsed w/ Styling ----------\n");
/* Loop through each category. */
foreach ($parsed as $category => $paramters) 
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
			print("=> ");
			/* Loop through each argument of a paramter. */
			foreach ($arguments as $arg => $value)
			{
				/* Print the arguments for a paramter with the ($arg)index and value. */
				print("[$arg] '$value'");
				if(next($arguments) == TRUE) print(", "); /* Print comma if we are not at the end of the array. */
				
			}
			$numOfArgs = count($arguments);
			print(" ($numOfArgs arguments) ");
		}
		/* If there is only 1 argument for a parameter then skip here. */
		else if(!empty($arguments))
		{
			print("=> '$arguments'");
			print(" (1 argument) ");
		}
	}
	print("\n\n");	
}






?>