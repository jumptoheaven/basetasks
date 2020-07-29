<?php
//php 7.0

function pr($s)
{
	echo $s . PHP_EOL;
}

spl_autoload_register(function ($c) {
    $path = explode('\\', $c);
    if ($path[0] === 'App') {
        $path[0] = 'classes';
    }
    $filePath = implode('/', $path);
    $phpFile = $filePath . '.php';
    var_export( [
        $c,
        $filePath,
        $path,
        $phpFile,
    ]);
    include $phpFile;
});

