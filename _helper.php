<?php
//php 7.0

function pr($s)
{
	echo $s . PHP_EOL;
}


function myAutoload ($c) 
{
    include 'classes/' . $c . '.php';
}

/*
function  myAutoload ($classn) {
    include 'classes/' . $classn . '.php';
}
*/
spl_autoload_register('myAutoload');
