<?php

use App\ActiveSpeech;

require __DIR__ . "/../vendor/autoload.php";

echo "**\n";

$simpleTense = new ActiveSpeech();
echo $simpleTense->presentSimple('I', 'see', 'TV') . PHP_EOL;
echo $simpleTense->presentSimple('He', 'see', 'TV') . PHP_EOL;

echo $simpleTense->presentContinues('I', 'see', 'TV') . PHP_EOL;
echo $simpleTense->presentContinues('He', 'see', 'TV') . PHP_EOL;
