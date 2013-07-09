<?php

$framework=dirname(__FILE__).DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'jf.php';
$config_file=dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.php';

require_once $framework;
try
{
	jf::app($config_file)->run();//mvc
	//jf::app($config_file)->run();//no mvc
}
catch(Exception $e)
{
	die($e->getMessage());
}