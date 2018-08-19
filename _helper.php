<?php
//php 7.0

function pr($s)
{
	echo $s . PHP_EOL;
}

spl_autoload_register(function ($c) {
    include 'classes/' . $c . '.php';
});

