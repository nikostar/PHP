<?php
spl_autoload_register('myAutoLoader');

//include all the classes
function myAutoLoader($className){
	$path="Classes/";
	$extension=".php";
	$fullPath=$path.$className.$extension;

	include_once $fullPath;
}