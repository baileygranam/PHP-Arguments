<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../.');
set_include_path(get_include_path() . PATH_SEPARATOR . '../../.');

echo __DIR__ . "\n";
exec("ls -l ../.", $arr1);
exec("ls -l ../../.", $arr2);

print("ls -l ../. output is:\n");
print_r($arr1);
print("ls -l ../../. output is:\n");
print_r($arr2);

function my_autoloader($className)
{
 	$filePathHead = str_replace('_', DIRECTORY_SEPARATOR, $className);
    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    
    $filePath = $filePathHead . ".php";
    foreach($includePaths as $includePath){
        $fullPath = $includePath . DIRECTORY_SEPARATOR . $filePath;
        if(file_exists($fullPath)){
            require_once $filePath;
            return;
        }
    }
}
spl_autoload_register('my_autoloader');
?>