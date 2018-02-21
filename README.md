##Features
- Abiliy to parse specific command line arguments.
- Utilization of namespaces.

# About

This program parses arguments from the command line. The program,`testArgs.php`, should exist directly in the`src`directory, while the`ParseArgv.php` class should be in`src/Models/Utilities`. 

Running the program involves passing in a list of arguments on the command line (in any order), of a certain form, for example:

`php testArgs.php -v --grades=good -T 5 -l val1,val2,val3 --names=Dominic,Mimi,Luke`

# Arguments
The following types of arguments are accepted:
1. A single dash followed by a letter (no space separating them) followed by either no argument or by a space and either a single argument or a comma-separated list of arguments that are either integers or strings.

 `-m 1,2,3 -Z bailey -f -a Erica,is,36,inches,tall`

2. A double dash followed by a string (one or more characters) followed by an equal sign followed by a comma separated string of arguments or just one argument with no comma.

`--geek=eckroth,duncan,hans,sam --cool=plante --slick=sam,RYAN,Huddy,drew,john`

**Note** that single and double-dash arguments can be interspersed, as shown in the initial example above.

# Groups
The command line arguments are parsed into three groups: **FLAGS, SINGLES, **and** DOUBLES.**

**FLAGS** are single dash parameters with no arguments. 

**SINGLES** are single-dash parameters with one or more comma-separated arguments, 

**DOUBLES** are double-dash parameters with one or more comma-separated arguments. 

# Output
The results are printed by category on one line, followed by all parameters and their arguments on separate lines, followed by the number of arguments in the line. For the first example, output would look something like:

>FLAGS
'v' 

>SINGLES
'T' => '5' (1 argument) 
'l' => [0] 'val1', [1] 'val2', [2] 'val3' (3 arguments) 

>DOUBLES
'grades' => 'good' (1 argument) 
'names' => [0] 'Dominic', [1] 'Mimi', [2] 'Luke' (3 arguments)

# Created By
Bailey Granam
