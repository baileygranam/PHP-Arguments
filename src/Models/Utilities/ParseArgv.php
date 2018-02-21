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
    	$this->parse();
        $this->argsParsed['FLAGS'] = $this->flags;
        $this->argsParsed['SINGLES'] = $this->singles;
        $this->argsParsed['DOUBLES'] = $this->doubles;
    }

	/**
    * Method to get the unParsed arguments array. 
    * @return - Array of unParsed arguments.
    */
    public function getUnparsed()
    {
    	return $this->argsUnparsed;
    }

    /**
    * Method to get the parsed arguments array. 
    * @return - Array of parsed arguments.
    */
    public function getParsed()
    {
        return $this->argsParsed;
    }

    /**
    * Method to check if a value in the argsUnparsed array at $index is a flag.
    * @param $index - Index value reference of the argsUnparsed array.
    * @return $isFlag - Boolean validating flag status.
    */
    private function isFlag($index)
    {
    	/* Check to see if the value at argsUnparsed[$index] contains a single dash followed by a letter. */
    	$isFlag = preg_match("/^-.{1}$/", $this->argsUnparsed[$index]);

		/* If the next value at argsUnparsed[$index+1] contains a dash or is empty/null then the value at argsUnparsed[$index] is a flag. */
    	$isFlag = ($isFlag && (preg_match("/^-/", $this->argsUnparsed[$index+1]) || !isset($this->argsUnparsed[$index+1])));

    	/* Return. */
    	return $isFlag;
    }

    /**
    * Method to check if a value in the argsUnparsed array at $index is a single.
    * @param $index - Index value reference of the argsUnparsed array.
    * @return $isSingle - Boolean validating single status.
    */
    private function isSingle($index)
    {
    	/* Check to see if the value at argsUnparsed[$index] contains a single dash followed by a letter. */
    	$isSingle = preg_match("/^-.{1}$/", $this->argsUnparsed[$index]);

    	/* Check to see if the value at argsUnparsed[$index+1] is an argument(s) for argsUnparsed[$index]. */
    	$isSingle = ($isSingle && !preg_match("/^-/", $this->argsUnparsed[$index+1]));

    	/* Return. */
    	return $isSingle;
    }

    /**
    * Method to check if a value in the argsUnparsed array at $index is a double.
    * @param $index - Index value reference of the argsUnparsed array.
    * @return $isDouble - Boolean validating double status.
    */
    private function isDouble($index)
    {
    	/* Check to see if the value at argsUnparsed[$index] contains a double dash. */
    	$isDouble = preg_match("/^--/", $this->argsUnparsed[$index]);

    	/* Return. */
    	return $isDouble;
    }

    /**
    * Method to place the value at argsUnparsed[$index] into the flags array.
    * @param $index - Index value reference of the argsUnparsed array.
    */
    private function parseFlag($index)
    {
    	/* Get/Clean the parameter. */
    	$parameter = $this->extractParameter($this->argsUnparsed[$index]);

    	/* Place parameter as a key into the flags array. */
    	$this->flags[$parameter] = null;
    }

	/**
    * Method to place the value at argsUnparsed[$index] into the singles array.
    * @param $index - Index value reference of the argsUnparsed array.
    */
    private function parseSingle($index)
    {
    	/* Get/Clean the parameter. */
    	$parameter = $this->extractParameter($this->argsUnparsed[$index]);

		/* Check to see if the value at argsUnparsed[$index+1] is a comma seperated argument list. */
    	if (preg_match("/,/", $this->argsUnparsed[$index+1])) 
		{
			/* Explode the multiple argument value(s) at argsUnparsed[$index+1] and place it into a temp array. */
			$temp = explode(",",$this->argsUnparsed[$index+1]);
						
			/* For each value in the temp array we will put it into our singles array for the specific parameter. */
			foreach ($temp as $index => $value)
			{
				$this->singles[$parameter][$index] = $value;
			}
		}
		/* If this is a single argument then directly place it into the array. */
		else
		{
			$this->singles[$parameter] = $this->argsUnparsed[$index+1];
		}
    }

	/**
    * Method to place the value at argsUnparsed[$index] into the doubles array.
    * @param $index - Index value reference of the argsUnparsed array.
    */
    private function parseDouble($index)
    {
    	/* Get/Clean the parameter and remove the part of the string after/including the '=' delimeter. */
		$parameter = strtok($this->extractParameter($this->argsUnparsed[$index]),"=");
		
		/* Retrieve the arguments by getting the string after the '=' delimeter. */
		$arguments = substr($this->argsUnparsed[$index], strrpos($this->argsUnparsed[$index], '=') + 1);

		/* Check to see if the value at argsUnparsed[$index+1] is a comma seperated argument list. */
		if (preg_match("/,/", $arguments, $match)) 
		{
			/* Explode the multiple argument value(s) at argsUnparsed[$index+1] and place it into a temp array. */
			$temp = explode(",",$arguments);
			
			/* For each value in the temp array we will put it into our doubles array for the specific parameter. */	
			foreach ($temp as $index => $value)
			{
				$this->doubles[$parameter][$index] = $value;
			}
		}
		/* If this is a single argument then directly place it into the array. */
		else
		{
			$this->doubles[$parameter] = $arguments;
		}
    }

    /**
    * Method to extract the paramter by removing the dashes from the string.
    * @param $parameter - Value to clean up.
    */
    private function extractParameter($parameter)
    {
    	return str_replace("-","",$parameter);
    }

    /* Method to parse all the values in the argsUnparsed array. */
    private function parse()
    {
    	/* Loop through the array of unparsed arguments. */
    	for($i = 0; $i < count($this->argsUnparsed); $i++)
		{
			/* Check to see if the value at argsUnparsed[$i] is a flag. */
			if($this->isFlag($i))
			{
				/* Parse the value as a flag. */
				$this->parseFlag($i);
			}

			/* Check to see if the value at argsUnparsed[$i] is a single. */
			else if($this->isSingle($i))
			{
				/* Parse the value as a single. */
				$this->parseSingle($i);
			}

			/* Check to see if the value at argsUnparsed[$i] is a double. */
			else if($this->isDouble($i))
			{
				/* Parse the value as a double. */
				$this->parseDouble($i);
			}

			/* If no matches are found then print an error. */
			else
			{
				print("\nError: Unable to parse value at index $i.\n");
			}
		}
    }   
}

?>