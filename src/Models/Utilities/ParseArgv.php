<?php

/* Namespace definition. */
namespace Models\Utilities;

class ParseArgv
{
	private $argsParsed;
    private $argsUnparsed;

    public function __construct($args)
    {
        $this->argsUnparsed = $args;
        $this->argsParsed = array(
            "One" => "one",
            "Two" => "two"
        );
    }

    public function getParsed()
    {
        return $this->argsParsed;
    }
}

?>