<?php

/* Namespace definition. */
namespace Models\Utilities;

class ParseArgv
{
	/* Variables */
    private $argsUnparsed = array();
    private $argsParsed   = array();
    private $flags        = array();
    private $singles      = array();
    private $doubles      = array();

    /* Constructor */
    public function __construct($args)
    {
        $this->argsUnparsed = $args;
    }

    /* Method to parse all the arguments and add to the $argsParsed array. */
    public function parseArgs()
    {
    	$this->parseFlags();
        $this->parseSingles();
        $this->parseDoubles();
        $this->argsParsed['FLAGS'] = $this->flags;
        $this->argsParsed['SINGLES'] = $this->singles;
        $this->argsParsed['DOUBLES'] = $this->doubles;
    }

    /* Return the array of parsed arguments. */
    public function getParsed()
    {
        return $this->argsParsed;
    }
 
    public function parseFlags()
    {
		for($i = 0; $i < count($this->argsUnparsed); $i++)
		{
			if(preg_match("/^-.{1}$/", $this->argsUnparsed[$i], $match))
			{
				if (preg_match("/^-/", $this->argsUnparsed[$i+1], $match) || !isset($this->argsUnparsed[$i+1])) 
				{
					$this->flags[str_replace("-","",$this->argsUnparsed[$i])] = '';
				}
			}
		}
    }

    /**
    * Function to parse singles from the user provided arguments.
    */
    public function parseSingles()
    {
    	/* Loop through the args array. */
    	for($i = 0; $i < count($this->argsUnparsed); $i++)
		{
			/* Check to see if the value at argsUnparsed[$i] contains a single hypen at the start of the string. */
			if(preg_match("/^-.{1}$/", $this->argsUnparsed[$i], $match))
			{
				/* Check to make sure the value at argsUnparsed[$i+1] does not contain a hypen or is null. */
				if (!preg_match("/^-/", $this->argsUnparsed[$i+1], $match) || !isset($this->argsUnparsed[$i+1])) 
				{
					/* 
					* If the value at argsUnparsed[$i+1] is a comma seperated list then we are going to explode 
					* the string and place it into an array. Then for each value in the array we will put it into 
					* our singles array for the specific argument.
					*/
					if (preg_match("/,/", $this->argsUnparsed[$i+1], $match)) 
					{
						$tempData = explode(",",$this->argsUnparsed[$i+1]);
						
						foreach ($tempData as $key => $val)
						{
							$this->singles[str_replace("-","",$this->argsUnparsed[$i])][$key] = $val;
						}
					}
					else
					{
						$tempSingles = array(str_replace("-","",$this->argsUnparsed[$i])=>$this->argsUnparsed[$i+1]);
						$this->singles = array_merge($this->singles,$tempSingles);
					}
				}
			}
		}
    }

    public function parseDoubles()
    {
    	/* Loop through the args array. */
    	for($i = 0; $i < count($this->argsUnparsed); $i++)
		{
			/* Check to see if the value at argsUnparsed[$i] contains a double hypen at the start of the string. */
			if(preg_match("/^--/", $this->argsUnparsed[$i], $match))
			{
				/* Retrieve the parameter by removing the hyphens and string after the '=' delimeter. */
				$parameter = strtok((str_replace("--","",$this->argsUnparsed[$i])),"=");

				/* Retrieve the argument by getting the string after the '=' delimeter. */
				$arguments = substr($this->argsUnparsed[$i], strrpos($this->argsUnparsed[$i], '=') + 1);

					if (preg_match("/,/", $arguments, $match)) 
					{

						$tempData = explode(",",$arguments);
						
						foreach ($tempData as $key => $val)
						{
							$this->doubles[$parameter][$key] = $val;
						}
					}
					else
					{
						$this->doubles[$parameter] = $arguments;
					}
			}
		}
    }
}

?>