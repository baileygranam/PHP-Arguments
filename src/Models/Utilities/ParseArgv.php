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

    public function getUnparsed()
    {
    	return $this->argsUnparsed;
    }

    /* Return the array of parsed arguments. */
    public function getParsed()
    {
        return $this->argsParsed;
    }

    private function parse()
    {
    	/* Loop through the array of unparsed arguments. */
    	for($i = 0; $i < count($this->argsUnparsed); $i++)
		{
			/* Check to see if the value at argsUnparsed[$i] contains a single dash followed by a letter. */
			if(preg_match("/^-.{1}$/", $this->argsUnparsed[$i], $match))
			{
				/* If the next value at argsUnparsed[$i+1] contains a dash or is empty then the parameter at argsUnparsed[$i] is a flag. */
				if(preg_match("/^-/", $this->argsUnparsed[$i+1], $match) || !isset($this->argsUnparsed[$i+1])) 
				{
					/* Place this parameter into the flags array as a key with no value and remove the dash. */
					$this->flags[str_replace("-","",$this->argsUnparsed[$i])] = '';
				}
				/* If the next value at argsUnparsed[$i+1] does NOT contain a dash then the parameter at argsUnparsed[$i] is a single. */ 
				else if(!preg_match("/^-/", $this->argsUnparsed[$i+1], $match))
				{
					/* 
					* If the value at argsUnparsed[$i+1] is a comma seperated list then we are going to explode 
					* the string and place it into an array. Then for each value in the array we will put it into 
					* our singles array for the specific parameter.
					*/
					if (preg_match("/,/", $this->argsUnparsed[$i+1], $match)) 
					{
						$temp = explode(",",$this->argsUnparsed[$i+1]);
						
						foreach ($temp as $key => $val)
						{
							$this->singles[str_replace("-","",$this->argsUnparsed[$i])][$key] = $val;
						}
					}
					else
					{
						$temp = array(str_replace("-","",$this->argsUnparsed[$i])=>$this->argsUnparsed[$i+1]);
						$this->singles = array_merge($this->singles,$temp);
					}
				}
			}
			/* Check to see if the value at argsUnparsed[$i] contains a double hypen at the start of the string. */
			else if(preg_match("/^--/", $this->argsUnparsed[$i], $match))
			{
				/* Retrieve the parameter by removing the hyphens and string after the '=' delimeter. */
				$parameter = strtok((str_replace("--","",$this->argsUnparsed[$i])),"=");

				/* Retrieve the argument by getting the string after the '=' delimeter. */
				$arguments = substr($this->argsUnparsed[$i], strrpos($this->argsUnparsed[$i], '=') + 1);

				/* 
				* If the value at argsUnparsed[$i+1] is a comma seperated list then we are going to explode 
				* the string and place it into an array. Then for each value in the array we will put it into 
				* our singles array for the specific parameter.
				*/
				if (preg_match("/,/", $arguments, $match)) 
				{
					$temp = explode(",",$arguments);
					
					foreach ($temp as $key => $val)
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