<?php

/* Namespace definition. */
namespace Models\Utilities;

class ParseArgv
{
    private $argsUnparsed;
    private $flags = array();
    private $singles = array();
    private $doubles = array();
    private $size = 0;

    public function __construct($args)
    {
        $this->argsUnparsed = $args;
    }

    public function getParsed()
    {
        return $this->argsUnparsed;
    }

    public function getSingles()
    {
    	return $this->singles;
    }

    public function getFlags()
    {
    	return $this->flags;
    }

   
    public function parseFlags()
    {
		for($i = 0; $i < count($this->argsUnparsed); $i++)
		{
			if(preg_match("/^-.{1}$/", $this->argsUnparsed[$i], $match))
			{
				if (preg_match("/^-/", $this->argsUnparsed[$i+1], $match) || !isset($this->argsUnparsed[$i+1])) 
				{
					array_push($this->flags, str_replace("-","",$this->argsUnparsed[$i]));
				}
			}
		}
    }

    /**
    * Function to parse singles from the user provided arguments.
    */
    public function parseSingles()
    {
    	/* Loop through the arguments array. */
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
}

?>